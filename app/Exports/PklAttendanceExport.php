<?php

namespace App\Exports;

use App\Models\PklAttendanceLog;
use App\Models\PklRegistration;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PklAttendanceExport implements FromCollection, WithHeadings, WithStyles
{
    protected $search;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($search = '', $dateFrom = null, $dateTo = null)
    {
        $this->search = $search;
        $this->dateFrom = $dateFrom ?? Carbon::now()->subDays(30)->format('Y-m-d');
        $this->dateTo = $dateTo ?? Carbon::now()->format('Y-m-d');
    }

    public function collection()
    {
        $query = PklRegistration::with([
            'student',
            'tempatPkl',
            'pklAttendanceLogs' => function ($q) {
                $q->whereBetween('scan_date', [$this->dateFrom, $this->dateTo])
                    ->orderBy('scan_date', 'desc');
            }
        ]);

        // Apply search filter
        if ($this->search) {
            $query->whereHas('student', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
                ->orWhereHas('tempatPkl', function ($q) {
                    $q->where('nama_tempat', 'like', "%{$this->search}%");
                });
        }

        $registrations = $query->get();

        $rows = collect();

        foreach ($registrations as $registration) {
            $user = $registration->student;
            $log = $registration->pklAttendanceLogs->first();

            $rows->push([
                'No' => $rows->count() + 1,
                'NIS' => $user->student->nis ?? '-',
                'Student Name' => $user->name,
                'Email' => $user->email,
                'Class' => $user->student->class->nama_kelas ?? '-',
                'Company' => $registration->tempatPkl->nama_tempat ?? '-',
                'Location' => $registration->tempatPkl->kota ?? '-',
                'Scan Date' => $log ? ($log->scan_date ? Carbon::parse($log->scan_date)->format('d/m/Y') : '-') : '-',
                'Check-In Time' => $log ? ($log->scan_time ? Carbon::parse($log->scan_time)->format('H:i') : '-') : '-',
                'Check-Out Time' => $log ? ($log->check_out_time ? Carbon::parse($log->check_out_time)->format('H:i') : '-') : '-',
                'Duration' => $this->calculateDuration($log),
                'Status' => $log ? $log->getStatusTextAttribute() : 'Not Checked In',
                'Activity/Notes' => $log ? ($log->log_activity ?? '-') : '-',
                'IP Address' => $log ? ($log->ip_address ?? '-') : '-',
                'Created By' => $log ? ($log->created_by ?? '-') : '-',
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Student Name',
            'Email',
            'Class',
            'Company',
            'Location',
            'Scan Date',
            'Check-In Time',
            'Check-Out Time',
            'Duration',
            'Status',
            'Activity/Notes',
            'IP Address',
            'Created By',
        ];
    }

    public function styles($sheet)
    {
        // Header style
        $sheet->getStyle('A1:O1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563eb'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Data style
        $sheet->getStyle('A2:O' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(20);

        // Freeze first row
        $sheet->freezePane('A2');

        return $sheet;
    }

    private function calculateDuration($log)
    {
        if (!$log || !$log->scan_time || !$log->check_out_time) {
            return '-';
        }

        try {
            $checkIn = Carbon::parse($log->scan_time);
            $checkOut = Carbon::parse($log->check_out_time);
            $duration = $checkIn->diff($checkOut);

            $durationText = '';
            if ($duration->h > 0) {
                $durationText .= $duration->h . 'h ';
            }
            if ($duration->i > 0) {
                $durationText .= $duration->i . 'm';
            }

            return $durationText ?: '-';
        } catch (\Exception $e) {
            return '-';
        }
    }
}
