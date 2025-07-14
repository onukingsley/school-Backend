<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Class_type;
use App\Models\Dues;
use App\Models\GradeScale;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Results;
use App\Models\SalaryPayment;
use App\Models\SchoolFees;
use App\Models\SchoolInfo;
use App\Models\Session;
use App\Models\Staff;
use App\Models\StaffRole;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function random ($min,$max){
        return rand($min,$max);
    }
    public function run(): void
    {
        // User::factory(10)->create();

       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        Payment::factory(50);
        GradeScale::factory(5);
        Dues::factory(5);
        StaffRole::factory(5);
        Session::factory(5)->has(Term::factory(3));


        User::factory(30)->has(Guardian::factory());
        User::factory(90)->has(Student::factory());
        User::factory(8)->has(Staff::factory()->has(Class_type::factory()));
        User::factory(20)->has(Staff::factory()->has(Subject::factory($this->random(1,3))));

        Attendance::factory(200);
        SchoolInfo::factory(1);
        SchoolFees::factory(200);
        SalaryPayment::factory(200);
        Results::factory(200);



    }
}
