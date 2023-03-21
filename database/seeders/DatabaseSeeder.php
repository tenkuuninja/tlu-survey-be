<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Classs;
use App\Models\Department;
use App\Models\GradeLevel;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Type;
use App\Models\User;
use App\Models\UserModel;
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

        Department::factory()->createMany([
            ['code' => 'CNTT', 'name' => 'Công nghệ thông tin'],
            ['code' => 'KTPM', 'name' => 'Kỹ thuật phần mềm'],
            ['code' => 'HTTT', 'name' => 'Hệ thống thông tin'],
            ['code' => 'ATTT', 'name' => 'An toàn thông tin'],
        ]);

        GradeLevel::factory()->createMany([
            ['code' => 'K59', 'name' => 'K59', 'year' => 2017],
            ['code' => 'K60', 'name' => 'K60', 'year' => 2018],
            ['code' => 'K61', 'name' => 'K61', 'year' => 2019],
            ['code' => 'K62', 'name' => 'K62', 'year' => 2020],
            ['code' => 'K63', 'name' => 'K63', 'year' => 2021],
            ['code' => 'K64', 'name' => 'K64', 'year' => 2022],
            ['code' => 'K65', 'name' => 'K65', 'year' => 2025],
        ]);

        UserModel::factory()->createMany([
            [
                'username' => 'admin123',
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'email' => 'admin@gmail.com',
                'name' => 'Quảng trị viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1,
                'role' => 'admin'
            ],
            [
                'department_id' => 2,
                'code' => 'gv01',
                'username' => 'teacher123',
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'email' => 'gv01@e.tlu.edu.vn',
                'citizen_id' => '00243533342',
                'name' => 'Giảng viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1,
                'role' => 'teacher'
            ],
            [
                'department_id' => 2,
                'code' => 'gv02',
                'username' => 'giangvien02',
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'email' => 'gv02@e.tlu.edu.vn',
                'citizen_id' => '00243533342',
                'name' => 'Giảng viên 2',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1,
                'role' => 'teacher'
            ],
            [
                'department_id' => 2,
                'code' => '2051060000',
                'username' => 'sinhvien01',
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'email' => '2051060000@e.tlu.edu.vn',
                'citizen_id' => '00243533343',
                'name' => 'Sinh viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1,
                'role' => 'student'
            ],
            [
                'department_id' => 2,
                'code' => '2051060001',
                'username' => 'sinhvien02',
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'email' => '2051060001@e.tlu.edu.vn',
                'citizen_id' => '00243533343',
                'name' => 'Sinh viên 2',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 2,
                'status' => 3,
                'role' => 'student'
            ],
        ]);

        
        Subject::factory()->createMany([
            [
                'department_id' => 2,
                'code' => 'QLDA',
                'credit_number' => 3,
                'name' => 'Quản lý dự án phần mềm',
                'description' => ''
            ],
            [
                'department_id' => 2,
                'code' => 'TRR',
                'credit_number' => 3,
                'name' => 'Toán rời rạc',
                'description' => ''
            ],
            [
                'department_id' => 1,
                'code' => 'CNW',
                'credit_number' => 3,
                'name' => 'Công nghệ wed',
                'description' => ''
            ],
            [
                'department_id' => 1,
                'code' => 'QTM',
                'credit_number' => 3,
                'name' => 'Quản trị mạng',
                'description' => ''
            ],
        ]);
        
        Classs::factory()->createMany([
            [
                'subject_id' => 1,
                'grade_level_id' => 4,
                'teacher_id' => 1,
                'code' => "TRR_K62_01",
                'name' => 'Toán rời rạc lớp abc',
                'status' => 1,
            ],
            [
                'subject_id' => 2,
                'grade_level_id' => 3,
                'teacher_id' => 3,
                'code' => "TRR_K61_01",
                'name' => 'Toán rời rạc lớp xyz',
                'status' => 1,
            ],
            [
                'subject_id' => 1,
                'grade_level_id' => 5,
                'teacher_id' => 1,
                'code' => "TRR_K63_01",
                'name' => 'Công nghệ web lớp abc',
                'status' => 1,
            ],
            [
                'subject_id' => 3,
                'grade_level_id' => 4,
                'teacher_id' => 1,
                'code' => "QTM_K62_01",
                'name' => 'Quản trị mạng lớp abc',
                'status' => 1,
            ],
            [
                'subject_id' => 1,
                'grade_level_id' => 3,
                'teacher_id' => 1,
                'code' => "TRR_K63_02",
                'name' => 'Công nghệ web lớp abc 2',
                'status' => 1,
            ],
            [
                'subject_id' => 1,
                'grade_level_id' => 4,
                'teacher_id' => 1,
                'code' => "TRR_K62_01",
                'name' => 'Toán rời rạc lớp abc',
                'status' => 1,
            ],
        ]);

        StudentClass::factory()->createMany([
            [
                'student_id' => 4,
                'class_id' => 1,
            ],
            [
                'student_id' => 5,
                'class_id' => 1,
            ],
            [
                'student_id' => 4,
                'class_id' => 2,
            ],
            [
                'student_id' => 5,
                'class_id' => 3,
            ],
        ]);
    }
}
