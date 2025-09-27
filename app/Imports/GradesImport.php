<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class GradesImport implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    protected $importedCount = 0;
    protected $errors = [];
    protected $skippedRows = [];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            $rowNumber = $index + 2; // +2 because of header row and 0-based index
            
            try {
                // Skip empty rows
                if ($this->isEmptyRow($row)) {
                    continue;
                }

                // Validate required fields
                $validation = $this->validateRow($row, $rowNumber);
                if (!$validation['valid']) {
                    $this->errors[] = "Baris {$rowNumber}: " . $validation['message'];
                    continue;
                }

                // Find student
                $student = $this->findStudent($row);
                if (!$student) {
                    $this->errors[] = "Baris {$rowNumber}: Siswa '{$row['nama_siswa']}' tidak ditemukan";
                    continue;
                }

                // Map type
                $type = $this->mapType($row['jenis_penilaian']);
                if (!$type) {
                    $this->errors[] = "Baris {$rowNumber}: Jenis penilaian '{$row['jenis_penilaian']}' tidak valid";
                    continue;
                }

                // Create or update grade
                $gradeData = [
                    'student_id' => $student->id,
                    'teacher_id' => Auth::id(),
                    'subject' => $row['mata_pelajaran'],
                    'type' => $type,
                    'score' => (float) $row['nilai'],
                    'max_score' => (float) $row['nilai_maksimal'],
                    'semester' => (int) ($row['semester'] ?? $this->getCurrentSemester()),
                    'year' => (int) ($row['tahun_ajaran'] ?? now()->year),
                    'notes' => $row['catatan'] ?? null,
                ];

                // Check for duplicate
                $existingGrade = Grade::where([
                    'student_id' => $gradeData['student_id'],
                    'teacher_id' => $gradeData['teacher_id'],
                    'subject' => $gradeData['subject'],
                    'type' => $gradeData['type'],
                    'semester' => $gradeData['semester'],
                    'year' => $gradeData['year'],
                ])->first();

                if ($existingGrade) {
                    // Update existing grade
                    $existingGrade->update($gradeData);
                } else {
                    // Create new grade
                    Grade::create($gradeData);
                }

                $this->importedCount++;

            } catch (\Exception $e) {
                $this->errors[] = "Baris {$rowNumber}: Error - " . $e->getMessage();
            }
        }
    }

    /**
     * Check if row is empty
     */
    private function isEmptyRow($row): bool
    {
        $requiredFields = ['nama_siswa', 'mata_pelajaran', 'jenis_penilaian', 'nilai', 'nilai_maksimal'];
        
        foreach ($requiredFields as $field) {
            if (!empty($row[$field])) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Validate row data
     */
    private function validateRow($row, $rowNumber): array
    {
        // Check required fields
        $requiredFields = [
            'nama_siswa' => 'Nama Siswa',
            'mata_pelajaran' => 'Mata Pelajaran',
            'jenis_penilaian' => 'Jenis Penilaian',
            'nilai' => 'Nilai',
            'nilai_maksimal' => 'Nilai Maksimal'
        ];

        foreach ($requiredFields as $field => $label) {
            if (empty($row[$field])) {
                return [
                    'valid' => false,
                    'message' => "{$label} tidak boleh kosong"
                ];
            }
        }

        // Validate numeric fields
        if (!is_numeric($row['nilai']) || $row['nilai'] < 0) {
            return [
                'valid' => false,
                'message' => "Nilai harus berupa angka dan tidak boleh negatif"
            ];
        }

        if (!is_numeric($row['nilai_maksimal']) || $row['nilai_maksimal'] <= 0) {
            return [
                'valid' => false,
                'message' => "Nilai Maksimal harus berupa angka dan lebih besar dari 0"
            ];
        }

        if ((float) $row['nilai'] > (float) $row['nilai_maksimal']) {
            return [
                'valid' => false,
                'message' => "Nilai tidak boleh lebih besar dari Nilai Maksimal"
            ];
        }

        // Validate semester
        if (!empty($row['semester']) && !in_array($row['semester'], [1, 2, '1', '2'])) {
            return [
                'valid' => false,
                'message' => "Semester harus 1 atau 2"
            ];
        }

        // Validate year
        if (!empty($row['tahun_ajaran'])) {
            $year = (int) $row['tahun_ajaran'];
            if ($year < 2020 || $year > 2030) {
                return [
                    'valid' => false,
                    'message' => "Tahun ajaran harus antara 2020-2030"
                ];
            }
        }

        return ['valid' => true];
    }

    /**
     * Find student by name or NIS
     */
    private function findStudent($row)
    {
        $studentName = trim($row['nama_siswa']);
        
        // Try to find by exact name match first
        $student = User::role('student')
                      ->where('name', $studentName)
                      ->first();

        if (!$student) {
            // Try to find by partial name match
            $student = User::role('student')
                          ->where('name', 'like', "%{$studentName}%")
                          ->first();
        }

        // If NIS is provided, try to find by NIS
        if (!$student && !empty($row['nis'])) {
            $studentRecord = Student::where('nis', $row['nis'])->first();
            if ($studentRecord && $studentRecord->user_id) {
                $student = User::find($studentRecord->user_id);
            }
        }

        return $student;
    }

    /**
     * Map type from Indonesian to English
     */
    private function mapType($type): ?string
    {
        $typeMapping = [
            'tugas' => 'assignment',
            'assignment' => 'assignment',
            'kuis' => 'quiz',
            'quiz' => 'quiz',
            'ujian' => 'exam',
            'exam' => 'exam',
            'manual' => 'manual',
            'uts' => 'exam',
            'uas' => 'exam',
            'ulangan' => 'quiz',
            'pr' => 'assignment',
            'praktikum' => 'assignment'
        ];

        $normalizedType = strtolower(trim($type));
        return $typeMapping[$normalizedType] ?? null;
    }

    /**
     * Get current semester
     */
    private function getCurrentSemester(): int
    {
        $month = now()->month;
        return $month >= 7 ? 1 : 2;
    }

    /**
     * Get import results
     */
    public function getResults(): array
    {
        return [
            'imported_count' => $this->importedCount,
            'errors' => $this->errors,
            'skipped_rows' => $this->skippedRows,
            'total_errors' => count($this->errors)
        ];
    }

    /**
     * Get expected headers for template
     */
    public static function getExpectedHeaders(): array
    {
        return [
            'nama_siswa' => 'Nama Siswa',
            'nis' => 'NIS (Opsional)',
            'mata_pelajaran' => 'Mata Pelajaran',
            'jenis_penilaian' => 'Jenis Penilaian (Tugas/Kuis/Ujian/Manual)',
            'nilai' => 'Nilai',
            'nilai_maksimal' => 'Nilai Maksimal',
            'semester' => 'Semester (1/2)',
            'tahun_ajaran' => 'Tahun Ajaran',
            'catatan' => 'Catatan (Opsional)'
        ];
    }
}