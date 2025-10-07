<?php

namespace App\Exports;

use App\Models\User;
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

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $users;
    protected $filters;

    public function __construct($users, $filters = [])
    {
        $this->users = $users;
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->users;
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
            'Role',
            'Status Email',
            'Kelas (Siswa)',
            'Mata Pelajaran (Guru)',
            'Tanggal Daftar',
            'Terakhir Login',
            'Status Akun',
            'Total Login'
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $user->name,
            $user->email,
            $this->getRoleLabel($user->roles->first()->name ?? 'user'),
            $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi',
            $this->getUserClass($user),
            $this->getUserSubject($user),
            $user->created_at->format('d/m/Y H:i'),
            $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Belum Pernah',
            $this->getAccountStatus($user),
            $user->login_count ?? 0
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->users->count() + 1;
        
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
            "A2:K{$lastRow}" => [
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
            "D2:D{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Role
            "E2:E{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Email Status
            "F2:F{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Kelas
            "H2:H{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Date
            "I2:I{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Last Login
            "J2:J{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Status
            "K2:K{$lastRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Login Count
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
            'C' => 30,  // Email
            'D' => 12,  // Role
            'E' => 15,  // Email Status
            'F' => 12,  // Kelas
            'G' => 20,  // Mata Pelajaran
            'H' => 15,  // Tanggal Daftar
            'I' => 15,  // Last Login
            'J' => 15,  // Status
            'K' => 12,  // Login Count
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Data Pengguna';
        
        if (!empty($this->filters['role'])) {
            $title .= ' - ' . $this->getRoleLabel($this->filters['role']);
        }
        
        return $title;
    }

    /**
     * Get role label
     */
    private function getRoleLabel($role)
    {
        $roles = [
            'admin' => 'Administrator',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            'user' => 'Pengguna'
        ];

        return $roles[$role] ?? ucfirst($role);
    }

    /**
     * Get user class (for students)
     */
    private function getUserClass($user)
    {
        if ($user->hasRole('student')) {
            return $user->class ?? '-';
        }
        return '-';
    }

    /**
     * Get user subject (for teachers)
     */
    private function getUserSubject($user)
    {
        if ($user->hasRole('teacher')) {
            return $user->subject ?? '-';
        }
        return '-';
    }

    /**
     * Get account status
     */
    private function getAccountStatus($user)
    {
        if ($user->deleted_at) {
            return 'Dihapus';
        }
        
        if (!$user->email_verified_at) {
            return 'Belum Verifikasi';
        }
        
        return 'Aktif';
    }
}