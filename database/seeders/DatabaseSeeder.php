<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Department;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Type::factory()->createMany([
            [
                'code' => 'SINGLE_CHOICE',
                'name' => 'Trắc nghiệm'
            ],
            [
                'code' => 'CHECKBOX',
                'name' => 'Checkbox'
            ],
            [
                'code' => 'DROPDOWN',
                'name' => 'Thả xuống'
            ],
            [
                'code' => 'PARA',
                'name' => 'Văn bản'
            ],
        ]);

        SchoolYear::factory()->createMany([
            ['years' => 2017],
            ['years' => 2018],
            ['years' => 2019],
            ['years' => 2020],
            ['years' => 2021],
            ['years' => 2022],
            ['years' => 2023],
            ['years' => 2024],
            ['years' => 2025],
            ['years' => 2026],
            ['years' => 2027],
        ]);

        Department::factory()->createMany([
            ['code' => 'CNTT', 'name' => 'Công nghệ thông tin'],
            ['code' => 'KTPM', 'name' => 'Kỹ thuật phần mềm'],
            ['code' => 'HTTT', 'name' => 'Hệ thống thông tin'],
            ['code' => 'ATTT', 'name' => 'An toàn thông tin'],
        ]);

        Admin::factory()->createMany([
            [
                'username' => 'admin123',
                'password_hashed' => password_hash('admin123', PASSWORD_BCRYPT),
                'email' => 'admin@gmail.com',
                'name' => 'Quảng trị viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1
            ],
        ]);

        Teacher::factory()->createMany([
            [
                'department_id' => 2,
                'username' => 'teacher123',
                'password_hashed' => password_hash('teacher123', PASSWORD_BCRYPT),
                'email' => 'teacher@gmail.com',
                'name' => 'Giảng viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1
            ],
        ]);

        Student::factory()->createMany([
            [
                'department_id' => 2,
                'username' => 'student123',
                'password_hashed' => password_hash('student123', PASSWORD_BCRYPT),
                'email' => 'student@gmail.com',
                'name' => 'Sinh viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1
            ],
        ]);
        
        GradeLevel::factory()->createMany([
            [
                'code' => 'K62CNTT',
                'name' => 'K62CNTT',
                'school_year_id' => 3,
                'department_id' => 1,
            ],
            [
                'code' => 'K62KTPM',
                'name' => 'K62KTPM',
                'school_year_id' => 3,
                'department_id' => 2,
            ],
            [
                'code' => 'K62HTTT',
                'name' => 'K62HTTT',
                'school_year_id' => 3,
                'department_id' => 3,
            ],
            [
                'code' => 'K62ATTT',
                'name' => 'K62ATTT',
                'school_year_id' => 3,
                'department_id' => 4,
            ],
            [
                'code' => 'K63CNTT',
                'name' => 'K63CNTT',
                'school_year_id' => 4,
                'department_id' => 1,
            ],
            [
                'code' => 'K63KTPM',
                'name' => 'K63KTPM',
                'school_year_id' => 4,
                'department_id' => 2,
            ],
        ]);
    }
}
