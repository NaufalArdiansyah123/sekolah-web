<?php

namespace App\Exports;

use App\Models\StudentRegistration;
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

class StudentRegistrationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $registrations;
    protected $filters;

    public function __construct($registrations, $filters = [])
    {
        $this->registrations = $registrations;
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->registrations;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Alamat',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'No. Telepon Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No. Telepon Ibu',
            'Alamat Orang Tua',
            'Asal Sekolah',
            'Tahun Lulus',
            'Status Pendaftaran',
            'Tanggal Daftar',
            'Catatan Admin'
        ];
    }

    /**
     * @param mixed $registration
     * @return array
     */
    public function map($registration): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $registration->full_name,
            $registration->email,
            $registration->phone ?? '-',
            $registration->birth_place ?? '-',
            $registration->birth_date ? date('d/m/Y', strtotime($registration->birth_date)) : '-',
            $this->getGenderLabel($registration->gender),
            $registration->religion ?? '-',
            $registration->address ?? '-',
            $registration->father_name ?? '-',
            $registration->father_job ?? '-',
            $registration->father_phone ?? '-',
            $registration->mother_name ?? '-',
            $registration->mother_job ?? '-',
            $registration->mother_phone ?? '-',
            $registration->parent_address ?? '-',
            $registration->previous_school ?? '-',
            $registration->graduation_year ?? '-',
            $this->getStatusLabel($registration->status),
            $registration->created_at->format('d/m/Y H:i'),
            $registration->admin_notes ?? '-'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->registrations->count() + 1;
        
        return [
            // Header row styling
            1 => [
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
            
            // Data rows styling
            "A2:U{$lastRow}" => [
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
            "F2:F{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Birth Date
            "G2:G{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Gender
            "R2:R{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Graduation Year
            "S2:S{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Status
            "T2:T{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Date
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
            'C' => 25,  // Email
            'D' => 15,  // Phone
            'E' => 15,  // Birth Place
            'F' => 12,  // Birth Date
            'G' => 12,  // Gender
            'H' => 12,  // Religion
            'I' => 30,  // Address
            'J' => 20,  // Father Name
            'K' => 20,  // Father Job
            'L' => 15,  // Father Phone
            'M' => 20,  // Mother Name
            'N' => 20,  // Mother Job
            'O' => 15,  // Mother Phone
            'P' => 30,  // Parent Address
            'Q' => 25,  // Previous School
            'R' => 12,  // Graduation Year
            'S' => 15,  // Status
            'T' => 15,  // Date
            'U' => 25,  // Admin Notes
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Data Pendaftaran Siswa';
        
        if (!empty($this->filters['status'])) {
            $title .= ' - ' . $this->getStatusLabel($this->filters['status']);
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

    /**
     * Get status label
     */
    private function getStatusLabel($status)
    {
        $statuses = [
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai'
        ];

        return $statuses[$status] ?? ucfirst($status);
    }
}