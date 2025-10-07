<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\TeacherSeeder;

class SeedTeachers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:teachers {--fresh : Clear existing teachers before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with sample teachers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting teacher seeding...');
        
        if ($this->option('fresh')) {
            $this->info('Fresh seeding requested - will clear existing teachers.');
        }
        
        try {
            $seeder = new TeacherSeeder();
            $seeder->setCommand($this);
            $seeder->run();
            
            $this->info('Teacher seeding completed successfully!');
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('Error during teacher seeding: ' . $e->getMessage());
            $this->error('Please check your database connection and try again.');
            return Command::FAILURE;
        }
    }
}