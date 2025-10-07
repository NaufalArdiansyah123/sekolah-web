<?php

namespace App\Exports;

use App\Models\AttendanceLog;
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

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $attendanceData;
    protected $filters;

    public function __construct($attendanceData, $filters = [])
    {
        $this->attendanceData = $attendanceData;
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->attendanceData;
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
            'Tanggal',
            'Status Kehadiran',
            'Waktu Scan',
            'Lokasi',
            'QR Code',
            'Catatan',
            'Jam Masuk',
            'Terlambat'
        ];
    }

    /**
     * @param mixed $attendance
     * @return array
     */
    public function map($attendance): array
    {
        static $no = 0;
        $no++;

        $isLate = $this->checkIfLate($attendance->scan_time);

        return [
            $no,
            $attendance->student->name ?? 'N/A',
            $attendance->student->nis ?? 'N/A',
            $attendance->student->class ?? 'N/A',
            $attendance->attendance_date->format('d/m/Y'),
            $this->getStatusLabel($attendance->status),
            $attendance->scan_time ? $attendance->scan_time->format('H:i:s') : '-',
            $attendance->location ?? '-',
            $attendance->qr_code ?? '-',
            $attendance->notes ?? '-',
            $attendance->scan_time ? $attendance->scan_time->format('H:i') : '-',
            $isLate ? 'Ya' : 'Tidak'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->attendanceData->count() + 1;
        
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
            "A2:L{$lastRow}" => [
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
            "E2:E{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Date
            "F2:F{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Status
            "G2:G{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Time
            "K2:K{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Jam Masuk
            "L2:L{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Terlambat
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
            'E' => 12,  // Tanggal
            'F' => 15,  // Status
            'G' => 12,  // Waktu Scan
            'H' => 20,  // Lokasi
            'I' => 15,  // QR Code
            'J' => 25,  // Catatan
            'K' => 12,  // Jam Masuk
            'L' => 10,  // Terlambat
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Data Kehadiran';
        
        if (!empty($this->filters['date'])) {
            $title .= ' - ' . date('d/m/Y', strtotime($this->filters['date']));
        }
        
        if (!empty($this->filters['class'])) {
            $title .= ' - Kelas ' . $this->filters['class'];
        }
        
        return $title;
    }

    /**
     * Get status label
     */
    private function getStatusLabel($status)
    {
        $statuses = [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha'
        ];

        return $statuses[$status] ?? ucfirst($status);
    }

    /**
     * Check if student is late
     */
    private function checkIfLate($scanTime)
    {
        if (!$scanTime) return false;
        
        $lateThreshold = '07:30:00'; // 7:30 AM
        return $scanTime->format('H:i:s') > $lateThreshold;
    }
}