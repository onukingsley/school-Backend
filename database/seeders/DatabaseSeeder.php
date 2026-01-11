<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Class_type;
use App\Models\ClassType;
use App\Models\Dues;
use App\Models\GradeScale;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Results;
use App\Models\ResultsCheck;
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

        {
            $this->call([
                TestSeeder::class,
            ]);
        }
        // User::factory(10)->create();

       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/


      /*  Payment::factory(50)->create();
        GradeScale::factory(5)->create();
        Dues::factory(5)->create();
        StaffRole::factory(5)->create();
        //Session::factory(5)->has(Term::factory(3));
        Session::factory(10)->create();
        Term::factory(3)->create();



        User::factory(30)->has(Guardian::factory())->create();

        User::factory(20)->has(Staff::factory()->has(Subject::factory($this->random(1,3))))->create();
        User::factory(8)->has(Staff::factory())->create();
        ClassType::factory(10)->create();
        User::factory(90)->has(Student::factory())->create();

        Attendance::factory(200)->create();
        //SchoolInfo::factory(1)->create();
        SchoolFees::factory(200)->create();
        SalaryPayment::factory(200)->create();
        Results::factory(200)->create();
        Assignment::factory(200)->create();




        ResultsCheck::factory(30)->create();*/

    }
}
