<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GradeController extends Controller
{
    /**
     * Display grades management dashboard
     */
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        
        // Handle export requests
        if ($request->has('export')) {
            return $this->handleExport($request);
        }
        
        // Handle template download
        if ($request->has('download') && $request->download === 'template') {
            return $this->downloadTemplate();
        }
        
        // Handle import requests
        if ($request->hasFile('excel_file')) {
            return $this->handleImport($request);
        }
        
        // Get filters
        $subject = $request->get('subject');
        $class = $request->get('class');
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        $search = $request->get('search');
        
        // Build query
        $query = Grade::with(['student', 'assignment', 'quiz'])
                     ->where('teacher_id', $teacherId)
                     ->where('semester', $semester)
                     ->where('year', $year);
        
        if ($subject) {
            $query->where('subject', $subject);
        }
        
        if ($class) {
            $query->whereHas('student', function($q) use ($class) {
                $q->where('class', $class);
            });
        }
        
        if ($search) {
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
        
        $grades = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get statistics
        $stats = [
            'total_grades' => Grade::where('teacher_id', $teacherId)->count(),
            'this_semester' => Grade::where('teacher_id', $teacherId)
                                  ->where('semester', $semester)
                                  ->where('year', $year)
                                  ->count(),
            'average_score' => Grade::where('teacher_id', $teacherId)
                                  ->where('semester', $semester)
                                  ->where('year', $year)
                                  ->avg('score') ?? 0,
            'subjects_count' => Grade::where('teacher_id', $teacherId)
                                   ->distinct('subject')
                                   ->count('subject'),
        ];
        
        // Get subjects for filter
        $subjects = Grade::where('teacher_id', $teacherId)
                        ->distinct('subject')
                        ->pluck('subject')
                        ->sort();
        
        // Get classes for filter
        $classes = User::role('student')
                      ->whereNotNull('class')
                      ->distinct('class')
                      ->pluck('class')
                      ->sort();
        
        return view('teacher.grades.index', compact(
            'grades', 'stats', 'subjects', 'classes', 
            'subject', 'class', 'semester', 'year'
        ));
    }
    
    /**
     * Show form to create new grade
     */
    public function create()
    {
        $students = User::role('student')->orderBy('name')->get();
        $assignments = Assignment::where('teacher_id', Auth::id())->get();
        $quizzes = Quiz::where('teacher_id', Auth::id())->get();
        
        return view('teacher.grades.create', compact('students', 'assignments', 'quizzes'));
    }
    
    /**
     * Store new grade
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'type' => 'required|in:assignment,quiz,exam,manual',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'semester' => 'required|integer|in:1,2',
            'year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);
        
        Grade::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'assignment_id' => $request->assignment_id,
            'quiz_id' => $request->quiz_id,
            'subject' => $request->subject,
            'type' => $request->type,
            'score' => $request->score,
            'max_score' => $request->max_score,
            'semester' => $request->semester,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('teacher.grades.index')
                        ->with('success', 'Nilai berhasil ditambahkan!');
    }
    
    /**
     * Show grade details
     */
    public function show($id)
    {
        $grade = Grade::with(['student', 'assignment', 'quiz'])
                     ->where('teacher_id', Auth::id())
                     ->findOrFail($id);
        
        return view('teacher.grades.show', compact('grade'));
    }
    
    /**
     * Show edit form
     */
    public function edit($id)
    {
        $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
        $students = User::role('student')->orderBy('name')->get();
        $assignments = Assignment::where('teacher_id', Auth::id())->get();
        $quizzes = Quiz::where('teacher_id', Auth::id())->get();
        
        return view('teacher.grades.edit', compact('grade', 'students', 'assignments', 'quizzes'));
    }
    
    /**
     * Update grade
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'type' => 'required|in:assignment,quiz,exam,manual',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'semester' => 'required|integer|in:1,2',
            'year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);
        
        $grade->update([
            'student_id' => $request->student_id,
            'assignment_id' => $request->assignment_id,
            'quiz_id' => $request->quiz_id,
            'subject' => $request->subject,
            'type' => $request->type,
            'score' => $request->score,
            'max_score' => $request->max_score,
            'semester' => $request->semester,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('teacher.grades.index')
                        ->with('success', 'Nilai berhasil diperbarui!');
    }
    
    /**
     * Delete grade
     */
    public function destroy(Request $request, $id = null)
    {
        if ($request->ajax()) {
            // Handle bulk delete
            if ($request->has('ids')) {
                $ids = $request->input('ids');
                $deleted = Grade::where('teacher_id', Auth::id())
                               ->whereIn('id', $ids)
                               ->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => $deleted . ' nilai berhasil dihapus!'
                ]);
            }
            
            // Handle single delete
            if ($id) {
                $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
                $grade->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Nilai berhasil dihapus!'
                ]);
            }
        }
        
        // Regular delete for non-AJAX requests
        $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
        $grade->delete();
        
        return redirect()->route('teacher.grades.index')
                        ->with('success', 'Nilai berhasil dihapus!');
    }
    
    /**
     * Show grades report
     */
    public function report(Request $request)
    {
        $teacherId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        
        // Get grades grouped by subject and student
        $grades = Grade::with(['student'])
                      ->where('teacher_id', $teacherId)
                      ->where('semester', $semester)
                      ->where('year', $year)
                      ->get();
        
        $gradesBySubject = $grades->groupBy('subject');
        $gradesByStudent = $grades->groupBy('student_id');
        
        // Calculate statistics
        $stats = [
            'total_students' => $gradesByStudent->count(),
            'total_subjects' => $gradesBySubject->count(),
            'total_grades' => $grades->count(),
            'average_score' => $grades->avg('score') ?? 0,
            'highest_score' => $grades->max('score') ?? 0,
            'lowest_score' => $grades->min('score') ?? 0,
        ];
        
        // Subject performance
        $subjectStats = [];
        foreach ($gradesBySubject as $subject => $subjectGrades) {
            $subjectStats[$subject] = [
                'average' => round($subjectGrades->avg('score'), 2),
                'count' => $subjectGrades->count(),
                'highest' => $subjectGrades->max('score'),
                'lowest' => $subjectGrades->min('score'),
            ];
        }
        
        return view('teacher.grades.report', compact(
            'grades', 'gradesBySubject', 'gradesByStudent', 
            'stats', 'subjectStats', 'semester', 'year'
        ));
    }
    
    /**
     * Show grade recap/summary
     */
    public function recap(Request $request)
    {
        $teacherId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        
        // Get all students with their grades
        $students = User::role('student')
                       ->with(['grades' => function($query) use ($teacherId, $semester, $year) {
                           $query->where('teacher_id', $teacherId)
                                 ->where('semester', $semester)
                                 ->where('year', $year);
                       }])
                       ->whereHas('grades', function($query) use ($teacherId, $semester, $year) {
                           $query->where('teacher_id', $teacherId)
                                 ->where('semester', $semester)
                                 ->where('year', $year);
                       })
                       ->orderBy('name')
                       ->get();
        
        // Get subjects
        $subjects = Grade::where('teacher_id', $teacherId)
                        ->where('semester', $semester)
                        ->where('year', $year)
                        ->distinct('subject')
                        ->pluck('subject')
                        ->sort();
        
        return view('teacher.grades.recap', compact('students', 'subjects', 'semester', 'year'));
    }
    
    /**
     * Handle export functionality
     */
    private function handleExport(Request $request)
    {
        $teacherId = Auth::id();
        
        // Get filters
        $subject = $request->get('subject');
        $class = $request->get('class');
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        
        // Build query
        $query = Grade::with(['student', 'assignment', 'quiz'])
                     ->where('teacher_id', $teacherId)
                     ->where('semester', $semester)
                     ->where('year', $year);
        
        if ($subject) {
            $query->where('subject', $subject);
        }
        
        if ($class) {
            $query->whereHas('student', function($q) use ($class) {
                $q->where('class', $class);
            });
        }
        
        // Handle selected export
        if ($request->export === 'selected' && $request->has('ids')) {
            $query->whereIn('id', $request->input('ids'));
        }
        
        $grades = $query->orderBy('created_at', 'desc')->get();
        
        return $this->exportToExcel($grades, $semester, $year);
    }
    
    /**
     * Export grades to Excel
     */
    private function exportToExcel($grades, $semester, $year)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
                   ->setCreator('Sistem Manajemen Sekolah')
                   ->setTitle('Data Nilai Siswa')
                   ->setSubject('Laporan Nilai')
                   ->setDescription('Data nilai siswa semester ' . $semester . ' tahun ' . $year);
        
        // Set headers
        $headers = [
            'A1' => 'No',
            'B1' => 'Nama Siswa',
            'C1' => 'Kelas',
            'D1' => 'Mata Pelajaran',
            'E1' => 'Jenis Penilaian',
            'F1' => 'Nilai',
            'G1' => 'Nilai Maksimal',
            'H1' => 'Persentase',
            'I1' => 'Grade',
            'J1' => 'Tanggal Input'
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
        
        // Add data
        $row = 2;
        foreach ($grades as $index => $grade) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $grade->student->name);
            $sheet->setCellValue('C' . $row, $grade->student->class ?? 'N/A');
            $sheet->setCellValue('D' . $row, $grade->subject);
            $sheet->setCellValue('E' . $row, ucfirst($grade->type));
            $sheet->setCellValue('F' . $row, $grade->score);
            $sheet->setCellValue('G' . $row, $grade->max_score);
            $sheet->setCellValue('H' . $row, number_format($grade->percentage, 1) . '%');
            $sheet->setCellValue('I' . $row, $grade->letter_grade);
            $sheet->setCellValue('J' . $row, $grade->created_at->format('d/m/Y H:i'));
            
            $row++;
        }
        
        // Style data rows
        $dataStyle = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ];
        
        $sheet->getStyle('A2:J' . ($row - 1))->applyFromArray($dataStyle);
        
        // Auto-size columns
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Create writer and download
        $writer = new Xlsx($spreadsheet);
        $filename = 'nilai-siswa-semester-' . $semester . '-' . $year . '-' . date('Y-m-d') . '.xlsx';
        
        return Response::streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }
    
    /**
     * Download import template
     */
    private function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $headers = [
            'A1' => 'Nama Siswa',
            'B1' => 'Mata Pelajaran',
            'C1' => 'Jenis Penilaian',
            'D1' => 'Nilai',
            'E1' => 'Nilai Maksimal',
            'F1' => 'Semester',
            'G1' => 'Tahun',
            'H1' => 'Catatan'
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Add sample data
        $sheet->setCellValue('A2', 'John Doe');
        $sheet->setCellValue('B2', 'Matematika');
        $sheet->setCellValue('C2', 'quiz');
        $sheet->setCellValue('D2', '85');
        $sheet->setCellValue('E2', '100');
        $sheet->setCellValue('F2', '1');
        $sheet->setCellValue('G2', date('Y'));
        $sheet->setCellValue('H2', 'Contoh catatan');
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        
        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'template-import-nilai.xlsx';
        
        return Response::streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }
    
    /**
     * Handle import functionality
     */
    private function handleImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048'
        ]);
        
        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            
            // Remove header row
            array_shift($rows);
            
            $imported = 0;
            $errors = [];
            
            DB::beginTransaction();
            
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and arrays are 0-indexed
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                // Validate required fields
                if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                    $errors[] = "Baris {$rowNumber}: Data tidak lengkap";
                    continue;
                }
                
                // Find student
                $student = User::role('student')->where('name', $row[0])->first();
                if (!$student) {
                    $errors[] = "Baris {$rowNumber}: Siswa '{$row[0]}' tidak ditemukan";
                    continue;
                }
                
                // Validate grade type
                $validTypes = ['assignment', 'quiz', 'exam', 'manual'];
                if (!in_array(strtolower($row[2]), $validTypes)) {
                    $errors[] = "Baris {$rowNumber}: Jenis penilaian '{$row[2]}' tidak valid";
                    continue;
                }
                
                // Validate scores
                if (!is_numeric($row[3]) || !is_numeric($row[4]) || $row[3] < 0 || $row[4] <= 0) {
                    $errors[] = "Baris {$rowNumber}: Nilai tidak valid";
                    continue;
                }
                
                // Create grade
                Grade::create([
                    'student_id' => $student->id,
                    'teacher_id' => Auth::id(),
                    'subject' => $row[1],
                    'type' => strtolower($row[2]),
                    'score' => $row[3],
                    'max_score' => $row[4],
                    'semester' => $row[5] ?? $this->getCurrentSemester(),
                    'year' => $row[6] ?? now()->year,
                    'notes' => $row[7] ?? null,
                ]);
                
                $imported++;
            }
            
            DB::commit();
            
            $message = "Berhasil mengimpor {$imported} data nilai";
            if (!empty($errors)) {
                $message .= ". Terdapat " . count($errors) . " error: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " dan " . (count($errors) - 3) . " error lainnya";
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'imported' => $imported,
                'errors' => $errors
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get current semester
     */
    private function getCurrentSemester()
    {
        $month = now()->month;
        return $month >= 7 ? 1 : 2;
    }
}