<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear tables in reverse order to avoid foreign key issues
        $this->truncateTables();

        $this->seedSchoolInfo();
        $this->seedAcademicSessionsAndTerms();
        $this->seedDuesAndGradeScales();
        $this->seedStaffRolesAndUsers();
        $this->seedClassesAndSubjects();
        $this->seedStudentsAndGuardians();
        $this->seedAssignmentsAndRecords();
        $this->seedTimetablesAndExamTables();
        $this->seedResults();
        $this->seedPaymentsAndSalary();
        $this->seedStaffAttendance();
        $this->seedNoticesAndPTSAs();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Full school system seeded successfully! 🎉');
        $this->command->info('Test Logins:');
        $this->command->table(
            ['Role', 'Email', 'Password', 'Notes'],
            [
                ['Admin/Principal', 'admin@school.com', 'password123', 'Full access'],
                ['Teacher (Form Teacher)', 'teacher@example.com', 'password123', 'SS1 Science Form Teacher'],
                ['Teacher (Non-Form)', 'biology.teacher@school.com', 'password123', 'Teaches Biology only'],
                ['Student', 'aisha.mohammed@student.com', 'password123', 'In SS1 Science'],
                ['Guardian', 'guardian.aisha@parent.com', 'password123', 'Parent of Aisha'],
            ]
        );
    }

    private function truncateTables()
    {
        $tables = [
            'notices', 'p_t_s_a_s', 'results_checks', 'exam_tables', 'timetables',
            'assignment_records', 'assignments', 'results', 'staff_attendances',
            'salary_payments', 'school_fees', 'payments', 'attendances',
            'students', 'guardians', 'class_types', 'subjects', 'staff',
            'users', 'terms', 'academic_sessions', 'grade_scales', 'dues',
            'staff_roles', 'school_infos'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }

    private function seedSchoolInfo()
    {
        DB::table('school_infos')->insert([
            'name' => 'Excellence Academy',
            'site_images' => json_encode(['logo.png', 'campus1.jpg']),
            'school_image' => json_encode(['banner.jpg']),
            'principal_details' => json_encode(['name' => 'Dr. Mrs. Grace Adebayo', 'quote' => 'Education is the key to success']),
            'nav_bar' => json_encode(['Home', 'About', 'Admissions', 'Academics', 'Contact']),
            'address' => '45 Excellence Road, Ikeja, Lagos',
            'motor' => 'Pursuit of Excellence',
            'po_box' => 'P.O. Box 1234, Ikeja',
            'long_lat' => '6.6018,3.3515',
            'phone_no' => '08090001111',
            'theme_color' => json_encode(['primary' => '#003366', 'secondary' => '#ff6600']),
            'email_address' => 'info@excellenceacademy.edu.ng',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function seedAcademicSessionsAndTerms()
    {
        DB::table('academic_sessions')->insert([
            ['id' => 1, 'year' => '2025/2026', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'year' => '2024/2025', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('terms')->insert([
            ['id' => 1, 'name' => 'First Term',  'current_term' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Second Term', 'current_term' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Third Term',  'current_term' => '0', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedDuesAndGradeScales()
    {
        DB::table('dues')->insert([
            ['id' => 1, 'title' => 'Tuition Fee', 'amount' => '250000', 'created_at' => now()],
            ['id' => 2, 'title' => 'Development Levy', 'amount' => '50000', 'created_at' => now()],
            ['id' => 3, 'title' => 'Staff Monthly Salary', 'amount' => '180000', 'created_at' => now()],
        ]);

        DB::table('grade_scales')->insert([
            ['id' => 1, 'grade' => 'A', 'min_score' => '70', 'max_score' => '100', 'remark' => 'Distinction'],
            ['id' => 2, 'grade' => 'B', 'min_score' => '60', 'max_score' => '69',  'remark' => 'Very Good'],
            ['id' => 3, 'grade' => 'C', 'min_score' => '50', 'max_score' => '59',  'remark' => 'Credit'],
            ['id' => 4, 'grade' => 'D', 'min_score' => '45', 'max_score' => '49',  'remark' => 'Pass'],
            ['id' => 5, 'grade' => 'F', 'min_score' => '0',  'max_score' => '44',  'remark' => 'Fail'],
        ]);
    }

    private function seedStaffRolesAndUsers()
    {
        // Roles
        DB::table('staff_roles')->insert([
            ['id' => 1, 'role' => 'Principal', 'description' => 'School Head'],
            ['id' => 2, 'role' => 'Teacher', 'description' => 'Classroom Teacher'],
            ['id' => 3, 'role' => 'Bursar', 'description' => 'Finance Officer'],
        ]);

        // Admin/Principal
        DB::table('users')->insert(['id' => 1, 'name' => 'Dr. Grace Adebayo', 'reg_no' => 'ADM001', 'user_type' => 'admin', 'email' => 'admin@school.com', 'password' => Hash::make('password123'), 'date_of_birth' => '1975-05-20', 'address' => 'Lagos', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('staff')->insert(['id' => 1, 'phone_no' => '08011112222', 'account_no' => '0000000001', 'form_teacher' => false, 'subject' => json_encode(['All']), 'user_id' => 1, 'staff_role_id' => 1, 'dues_id' => 3, 'created_at' => now(), 'updated_at' => now()]);

        // Mathematics Teacher (Form Teacher of SS1 Science)
        DB::table('users')->insert(['id' => 100, 'name' => 'Mr. Chukwuemeka Okonkwo', 'reg_no' => 'STF001', 'user_type' => 'staff', 'email' => 'teacher@example.com', 'password' => Hash::make('password123'), 'date_of_birth' => '1985-03-15', 'address' => 'Victoria Island, Lagos', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('staff')->insert(['id' => 2, 'phone_no' => '08012345678', 'account_no' => '0123456789', 'form_teacher' => true, 'subject' => json_encode(['Mathematics']), 'user_id' => 100, 'staff_role_id' => 2, 'dues_id' => 3, 'created_at' => now(), 'updated_at' => now()]);

        // Biology Teacher (Not form teacher)
        DB::table('users')->insert(['id' => 101, 'name' => 'Mrs. Fatima Bello', 'reg_no' => 'STF002', 'user_type' => 'staff', 'email' => 'biology.teacher@school.com', 'password' => Hash::make('password123'), 'date_of_birth' => '1988-08-10', 'address' => 'Surulere, Lagos', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('staff')->insert(['id' => 3, 'phone_no' => '08098765432', 'account_no' => '0987654321', 'form_teacher' => false, 'subject' => json_encode(['Biology']), 'user_id' => 101, 'staff_role_id' => 2, 'dues_id' => 3, 'created_at' => now(), 'updated_at' => now()]);
    }

    private function seedClassesAndSubjects()
    {
        // Classes
        DB::table('class_types')->insert([
            ['id' => 1, 'staff_id' => 2, 'class_name' => 'SS1 Science', 'number_of_students' => '30', 'class_type_name' => 'Senior Secondary', 'subject' => json_encode(['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Civic']), 'created_at' => now()],
            ['id' => 2, 'staff_id' => 1, 'class_name' => 'SS1 Commercial', 'number_of_students' => '25', 'class_type_name' => 'Senior Secondary', 'subject' => json_encode(['Accounting', 'Commerce', 'Government', 'Mathematics', 'English']), 'created_at' => now()],
        ]);

        // Subjects
        DB::table('subjects')->insert([
            ['id' => 1, 'staff_id' => 2, 'title' => 'Mathematics', 'description' => 'SS1 Mathematics', 'scheme_of_work' => 'Algebra, Geometry', 'class_list' => json_encode([1]), 'created_at' => now()],
            ['id' => 2, 'staff_id' => 3, 'title' => 'Biology', 'description' => 'SS1 Biology', 'scheme_of_work' => 'Cell Biology, Ecology', 'class_list' => json_encode([1]), 'created_at' => now()],
            ['id' => 3, 'staff_id' => 1, 'title' => 'Accounting', 'description' => 'SS1 Accounting', 'scheme_of_work' => 'Ledger, Trial Balance', 'class_list' => json_encode([2]), 'created_at' => now()],
        ]);
    }

    private function seedStudentsAndGuardians()
    {
        $students = [
            ['name' => 'Aisha Mohammed', 'email' => 'aisha.mohammed@student.com', 'class' => 1, 'guardian_name' => 'Alhaji Mohammed Yusuf', 'guardian_email' => 'guardian.aisha@parent.com'],
            ['name' => 'David Okafor', 'email' => 'david.okafor@student.com', 'class' => 1, 'guardian_name' => 'Mrs. Ngozi Okafor', 'guardian_email' => 'guardian.david@parent.com'],
            ['name' => 'Chioma Eze', 'email' => 'chioma.eze@student.com', 'class' => 1, 'guardian_name' => 'Mr. Chinedu Eze', 'guardian_email' => 'guardian.chioma@parent.com'],
            ['name' => 'Tunde Adeyemi', 'email' => 'tunde.adeyemi@student.com', 'class' => 2, 'guardian_name' => 'Mrs. Funmi Adeyemi', 'guardian_email' => 'guardian.tunde@parent.com'],
        ];

        foreach ($students as $i => $s) {
            $userId = 200 + $i;
            $guardianUserId = 300 + $i;

            // Guardian User
            DB::table('users')->insert([
                'id' => $guardianUserId,
                'name' => $s['guardian_name'],
                'reg_no' => 'GRD' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'user_type' => 'guardian',
                'email' => $s['guardian_email'],
                'password' => Hash::make('password123'),
                'date_of_birth' => '1975-01-01',
                'address' => 'Lagos',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Guardian Record
            DB::table('guardians')->insert([
                'user_id' => $guardianUserId,
                'occupation' => 'Business',
                'alt_phone_no' => '080' . rand(10000000, 99999999),
                'office_address' => 'Ikeja',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Student User
            DB::table('users')->insert([
                'id' => $userId,
                'name' => $s['name'],
                'reg_no' => 'STU' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'user_type' => 'student',
                'email' => $s['email'],
                'password' => Hash::make('password123'),
                'date_of_birth' => '2008-0' . (5 + $i) . '-12',
                'address' => 'Lagos',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Student Record
            DB::table('students')->insert([
                'user_id' => $userId,
                'guardian_id' => $guardianUserId - 299, // maps to guardian id
                'class_type_id' => $s['class'],
                'role' => 'Student',
                'academic_average' => '0',
                'academic_session_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedAssignmentsAndRecords()
    {
        DB::table('assignments')->insert([
            ['subject_id' => 1, 'class_type_id' => 1, 'academic_session_id' => 1, 'term_id' => 1, 'title' => 'Quadratic Equations Assignment', 'assignment_status' => 'assignment1', 'content' => 'Solve textbook page 50', 'due_date' => '2026-01-20'],
            ['subject_id' => 2, 'class_type_id' => 1, 'academic_session_id' => 1, 'term_id' => 1, 'title' => 'Cell Structure Diagram', 'assignment_status' => 'assignment2', 'content' => 'Draw and label animal cell', 'due_date' => '2026-01-22'],
        ]);

        // Sample submission
        DB::table('assignment_records')->insert([
            'term' => 'First Term',
            'score' => '18',
            'assignment_id' => 1,
            'student_id' => 200, // Aisha
            'session_id' => 1,
            'created_at' => now(),
        ]);
    }

    private function seedTimetablesAndExamTables()
    {
        DB::table('timetables')->insert([
            ['class_type_id' => 1, 'subject_id' => 1, 'staff_id' => 2, 'term_id' => 1, 'academic_session_id' => 1, 'day_of_the_week' => json_encode(['Monday', 'Wednesday']), 'time_range' => '08:00-09:40', 'subject_title' => 'Mathematics'],
            ['class_type_id' => 1, 'subject_id' => 2, 'staff_id' => 3, 'term_id' => 1, 'academic_session_id' => 1, 'day_of_the_week' => json_encode(['Tuesday']), 'time_range' => '10:00-11:40', 'subject_title' => 'Biology'],
        ]);

        DB::table('exam_tables')->insert([
            ['class_type_id' => 1, 'subject_id' => 1, 'staff_id' => 2, 'academic_session_id' => 1, 'term_id' => 1, 'invigilator' => json_encode(['Mr. Okonkwo']), 'time_range' => '2026-03-15 09:00-11:00'],
        ]);
    }

    /*private function seedResults()
    {
        DB::table('results')->insert([
            'student_id' => 200,
            'subject_id' => 1,
            'class_type_id' => 1,
            'term_id' => 1,
            'academic_session_id' => 1,
            'level' => 'SS1',
            'grade_scale_id' => 1,
            'test1' => '18',
            'test2' => '19',
            'assignment1' => '9',
            'assignment2' => '10',
            'total' => '56',
            'exam' => '82',
            'created_at' => now(),
        ]);
    }*/

    private function seedResults()
    {
        // Target student: Aisha Mohammed (student_id = 200, in SS1 Science, class_type_id = 1)
        $studentId = 1;
        $classTypeId = 1;

        // Subjects in SS1 Science
        $subjects = [
            1 => 'Mathematics',  // subject_id 1
            2 => 'Biology',      // subject_id 2
            // Add more subjects if you create them
            // Example: 4 => 'English', 5 => 'Physics'
        ];

        // Academic Sessions
        $sessions = [
            1 => '2025/2026',  // Current
            2 => '2024/2025',  // Previous
        ];

        // Terms
        $terms = [1 => 'First Term', 2 => 'Second Term', 3 => 'Third Term'];

        // Sample score patterns (to show trends)
        $scorePatterns = [
            // 2024/2025 (Previous Year) - Average performance
            '2024/2025' => [
                'First Term'  => ['test1' => 15, 'test2' => 16, 'assignment1' => 7, 'assignment2' => 8,  'exam' => 65],
                'Second Term' => ['test1' => 17, 'test2' => 18, 'assignment1' => 8, 'assignment2' => 9,  'exam' => 72],
                'Third Term'  => ['test1' => 18, 'test2' => 19, 'assignment1' => 9, 'assignment2' => 10, 'exam' => 78],
            ],
            // 2025/2026 (Current Year) - Showing improvement
            '2025/2026' => [
                'First Term'  => ['test1' => 18, 'test2' => 19, 'assignment1' => 9,  'assignment2' => 10, 'exam' => 82],
                'Second Term' => ['test1' => 20, 'test2' => 20, 'assignment1' => 10, 'assignment2' => 10, 'exam' => 88],
                'Third Term'  => ['test1' => 19, 'test2' => 20, 'assignment1' => 10, 'assignment2' => 10, 'exam' => 90],
            ],
        ];

        $results = [];

        foreach ($sessions as $sessionId => $sessionYear) {
            foreach ($terms as $termId => $termName) {
                foreach ($subjects as $subjectId => $subjectName) {
                    $pattern = $scorePatterns[$sessionYear][$termName] ?? null;

                    if (!$pattern) continue; // Skip if no data defined

                    // Random small variation for realism
                    $variation = rand(-2, 2);

                    $results[] = [
                        'student_id'          => $studentId,
                        'subject_id'          => $subjectId,
                        'class_type_id'       => $classTypeId,
                        'term_id'             => $termId,
                        'academic_session_id' => $sessionId,
                        'level'               => 'SS1',
                        'grade_scale_id'      => $this->determineGradeScale(
                            $pattern['test1'] + $pattern['test2'] + $pattern['assignment1'] + $pattern['assignment2'] + $pattern['exam'] + $variation
                        ),
                        'test1'               => max(0, $pattern['test1'] + $variation),
                        'test2'               => max(0, $pattern['test2'] + $variation),
                        'assignment1'         => max(0, $pattern['assignment1']),
                        'assignment2'         => max(0, $pattern['assignment2']),
                        'total'               => ($pattern['test1'] + $pattern['test2'] + $pattern['assignment1'] + $pattern['assignment2']) + ($variation * 2),
                        'exam'                => max(0, $pattern['exam'] + $variation),
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ];
                }
            }
        }

        // Insert all at once (faster and cleaner)
        DB::table('results')->insert($results);

        $this->command->info("Seeded " . count($results) . " result records for Student ID {$studentId} across 2 sessions and 3 terms.");
    }

// Helper to assign grade based on total score
    private function determineGradeScale($totalScore)
    {
        if ($totalScore >= 70) return 1; // A
        if ($totalScore >= 60) return 2; // B
        if ($totalScore >= 50) return 3; // C
        if ($totalScore >= 45) return 4; // D
        return 5; // F
    }

    private function seedPaymentsAndSalary()
    {
        // School Fees
        DB::table('school_fees')->insert([
            ['student_id' => 200, 'dues_id' => 1, 'transaction_type' => 'debit', 'amount' => '250000', 'name' => 'First Term Tuition', 'academic_session_id' => 1, 'term_id' => 1, 'transaction_id' => 'FEE-2026-001'],
            ['student_id' => 200, 'dues_id' => 1, 'transaction_type' => 'credit', 'amount' => '200000', 'name' => 'Partial Payment', 'academic_session_id' => 1, 'term_id' => 1, 'transaction_id' => 'PAY-2026-001'],
        ]);

        // Staff Salary
        DB::table('salary_payments')->insert([
            ['staff_id' => 2, 'dues_id' => 3, 'transaction_type' => 'credit', 'amount' => '180000', 'name' => 'January 2026 Salary', 'transaction_id' => 'SAL-2026-01-002'],
        ]);
    }

    private function seedStaffAttendance()
    {
        $days = ['2026-01-06', '2026-01-07', '2026-01-08', '2026-01-09', '2026-01-10'];
        foreach ($days as $day) {
            DB::table('staff_attendances')->insert([
                'staff_id' => 2,
                'term_id' => 1,
                'academic_session_id' => 1,
                'attendance' => '1',
                'created_at' => $day,
                'updated_at' => $day,
            ]);
        }
    }

    private function seedNoticesAndPTSAs()
    {
        DB::table('notices')->insert([
            ['title' => 'Mid-Term Break', 'message' => 'School resumes on January 20, 2026', 'target_audience' => json_encode(['all']), 'created_at' => now()],
            ['title' => 'PTA Meeting', 'message' => 'PTA meeting scheduled for January 25', 'target_audience' => json_encode(['parents']), 'created_at' => now()],
        ]);
    }
}
