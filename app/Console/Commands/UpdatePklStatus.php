<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\PklRegistration;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePklStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pkl:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update student PKL status based on PKL end date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating PKL status...');

        // Find all students with active PKL (sedang_pkl)
        $studentsWithActivePkl = Student::where('pkl_status', 'sedang_pkl')
            ->whereNotNull('active_pkl_registration_id')
            ->with('activePklRegistration')
            ->get();

        $updated = 0;

        foreach ($studentsWithActivePkl as $student) {
            if ($student->activePklRegistration) {
                $endDate = Carbon::parse($student->activePklRegistration->tanggal_selesai);

                // Check if PKL period has ended
                if ($endDate->isPast()) {
                    $student->update([
                        'pkl_status' => 'selesai_pkl',
                        'active_pkl_registration_id' => null,
                    ]);

                    $updated++;
                    $this->info("Updated: {$student->name} - PKL ended on {$endDate->format('Y-m-d')}");
                }
            }
        }

        $this->info("Total students updated: {$updated}");

        return Command::SUCCESS;
    }
}
