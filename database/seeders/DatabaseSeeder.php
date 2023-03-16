<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
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

        UserModel::factory()->createMany([
            [
                'username' => 'admin123',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
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
                'username' => 'teacher123',
                'password' => password_hash('teacher123', PASSWORD_BCRYPT),
                'email' => 'teacher@gmail.com',
                'name' => 'Giảng viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1,
                'role' => 'teacher'
            ],
            [
                'department_id' => 2,
                'username' => 'student123',
                'password' => password_hash('student123', PASSWORD_BCRYPT),
                'email' => 'student@gmail.com',
                'name' => 'Sinh viên 1',
                'address' => 'Hà Nội',
                'phone_number' => '0123456789',
                'sex' => 1,
                'status' => 1,
                'role' => 'student'
            ],
        ]);
    }
}
