<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::truncate();

        $csvFile = fopen(base_path('database/data/students.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                Student::create([
                    'FirstName' => $data['1'],
                    'LastName' => $data['2'],
                    'School' => $data['3'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);

    }
}
