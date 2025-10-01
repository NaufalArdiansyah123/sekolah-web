<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\ExtracurricularRegistrationSeeder;

class SeedExtracurricularRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:extracurricular-registrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed extracurricular registrations with sample data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏃‍♂️ Seeding Extracurricular Registrations...');
        
        $seeder = new ExtracurricularRegistrationSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->info('✅ Extracurricular registrations seeded successfully!');
        
        return 0;
    }
}