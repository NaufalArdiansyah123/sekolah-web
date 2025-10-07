<?php

namespace App\Exports;

use App\Models\Student;
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

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $students;
    protected $filters;

    public function __construct($students, $filters = [])
    {
        $this->students = $students;
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->students;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'NIS',
            'NISN',
            'Email',
            'No. Telepon',
            'Kelas',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Alamat',
            'Nama Orang Tua',
            'No. Telepon Orang Tua',
            'Status',
            'Tanggal Daftar'
        ];
    }

    /**
     * @param mixed $student
     * @return array
     */
    public function map($student): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $student->name,
            $student->nis ?? '-',
            $student->nisn ?? '-',
            $student->email ?? '-',
            $student->phone ?? '-',
            $student->class ?? '-',
            $this->getGenderLabel($student->gender),
            $student->birth_place ?? '-',
            $student->birth_date ? $student->birth_date->format('d/m/Y') : '-',
            $student->religion ?? '-',
            $student->address ?? '-',
            $student->parent_name ?? '-',
            $student->parent_phone ?? '-',
            $student->status_label,
            $student->created_at->format('d/m/Y H:i')
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->students->count() + 1;
        
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
            "A2:P{$lastRow}" => [
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
            "D2:D{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // NISN
            "G2:G{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Kelas
            "H2:H{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Gender
            "J2:J{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Birth Date
            "O2:O{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Status
            "P2:P{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Date
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama
            'C' => 12,  // NIS
            'D' => 15,  // NISN
            'E' => 25,  // Email
            'F' => 15,  // Phone
            'G' => 10,  // Kelas
            'H' => 12,  // Gender
            'I' => 15,  // Birth Place
            'J' => 12,  // Birth Date
            'K' => 12,  // Religion
            'L' => 30,  // Address
            'M' => 25,  // Parent Name
            'N' => 15,  // Parent Phone
            'O' => 12,  // Status
            'P' => 15,  // Date
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Data Siswa';
        
        if (!empty($this->filters['class'])) {
            $title .= ' - Kelas ' . $this->filters['class'];
        }
        
        if (!empty($this->filters['status'])) {
            $title .= ' - Status ' . ucfirst($this->filters['status']);
        }
        
        return $title;
    }

    /**
     * Get gender label
     */
    private function getGenderLabel($gender)
    {
        $genders = [
            'male' => 'Laki-laki',
            'female' => 'Perempuan'
        ];

        return $genders[$gender] ?? $gender ?? '-';
    }
}