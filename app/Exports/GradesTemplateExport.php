<?php

namespace App\Exports;

use App\Imports\GradesImport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GradesTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    /**
     * @return array
     */
    public function array(): array
    {
        // Sample data for template
        return [
            [
                'Ahmad Rizki',
                '12345',
                'Matematika',
                'Tugas',
                85,
                100,
                1,
                2024,
                'Tugas harian bab 1'
            ],
            [
                'Siti Nurhaliza',
                '12346',
                'Bahasa Indonesia',
                'Kuis',
                90,
                100,
                1,
                2024,
                'Kuis pemahaman teks'
            ],
            [
                'Budi Santoso',
                '12347',
                'Fisika',
                'Ujian',
                78,
                100,
                1,
                2024,
                'UTS Semester 1'
            ]
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'NIS (Opsional)',
            'Mata Pelajaran',
            'Jenis Penilaian',
            'Nilai',
            'Nilai Maksimal',
            'Semester',
            'Tahun Ajaran',
            'Catatan (Opsional)'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Add instructions at the top
        $sheet->insertNewRowBefore(1, 5);
        
        $sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA NILAI SISWA');
        $sheet->setCellValue('A2', 'Petunjuk Penggunaan:');
        $sheet->setCellValue('A3', '1. Isi data sesuai dengan format yang telah disediakan');
        $sheet->setCellValue('A4', '2. Jenis Penilaian: Tugas, Kuis, Ujian, atau Manual');
        $sheet->setCellValue('A5', '3. Semester: 1 atau 2');
        $sheet->setCellValue('A6', '4. Hapus baris contoh ini sebelum import');
        
        return [
            // Title styling
            'A1' => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                    'color' => ['rgb' => '059669']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ]
            ],
            
            // Instructions styling
            'A2:A6' => [
                'font' => [
                    'italic' => true,
                    'color' => ['rgb' => '666666']
                ]
            ],
            
            // Header row styling (row 7 after instructions)
            7 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11
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
            
            // Sample data styling
            'A8:I10' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F8F9FA']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20,  // Nama Siswa
            'B' => 15,  // NIS
            'C' => 20,  // Mata Pelajaran
            'D' => 18,  // Jenis Penilaian
            'E' => 10,  // Nilai
            'F' => 15,  // Nilai Maksimal
            'G' => 12,  // Semester
            'H' => 15,  // Tahun Ajaran
            'I' => 25,  // Catatan
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Template Import Nilai';
    }
}