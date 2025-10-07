<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GradesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $grades;
    protected $filters;

    public function __construct($grades, $filters = [])
    {
        $this->grades = $grades;
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->grades;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Mata Pelajaran',
            'Jenis Penilaian',
            'Nilai',
            'Nilai Maksimal',
            'Persentase (%)',
            'Grade',
            'Semester',
            'Tahun Ajaran',
            'Catatan',
            'Tanggal Input',
            'Guru'
        ];
    }

    /**
     * @param mixed $grade
     * @return array
     */
    public function map($grade): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $grade->student->name ?? 'N/A',
            $grade->student->nis ?? 'N/A',
            $grade->student->class ?? 'N/A',
            $grade->subject,
            $this->getTypeLabel($grade->type),
            $grade->score,
            $grade->max_score,
            number_format($grade->percentage, 1),
            $grade->letter_grade,
            $grade->semester,
            $grade->year,
            $grade->notes ?? '-',
            $grade->created_at->format('d/m/Y H:i'),
            $grade->teacher->name ?? 'N/A'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->grades->count() + 1;
        
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],
            
            // Data rows styling
            "A2:O{$lastRow}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ],
            
            // Center align specific columns
            "A2:A{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // No
            "C2:C{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // NIS
            "D2:D{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Kelas
            "F2:F{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Jenis
            "G2:G{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Nilai
            "H2:H{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Max
            "I2:I{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Persentase
            "J2:J{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Grade
            "K2:K{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Semester
            "L2:L{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Tahun
            "N2:N{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Tanggal
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama Siswa
            'C' => 12,  // NIS
            'D' => 10,  // Kelas
            'E' => 20,  // Mata Pelajaran
            'F' => 15,  // Jenis Penilaian
            'G' => 8,   // Nilai
            'H' => 8,   // Nilai Maksimal
            'I' => 12,  // Persentase
            'J' => 8,   // Grade
            'K' => 10,  // Semester
            'L' => 12,  // Tahun Ajaran
            'M' => 20,  // Catatan
            'N' => 15,  // Tanggal Input
            'O' => 20,  // Guru
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Data Nilai Siswa';
        
        if (!empty($this->filters['semester'])) {
            $title .= ' - Semester ' . $this->filters['semester'];
        }
        
        if (!empty($this->filters['year'])) {
            $title .= ' - ' . $this->filters['year'];
        }
        
        if (!empty($this->filters['subject'])) {
            $title .= ' - ' . $this->filters['subject'];
        }
        
        if (!empty($this->filters['class'])) {
            $title .= ' - Kelas ' . $this->filters['class'];
        }
        
        return $title;
    }

    /**
     * Get type label
     */
    private function getTypeLabel($type)
    {
        $types = [
            'assignment' => 'Tugas',
            'quiz' => 'Kuis',
            'exam' => 'Ujian',
            'manual' => 'Manual'
        ];

        return $types[$type] ?? ucfirst($type);
    }
}