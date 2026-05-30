<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email'=>'admin@tmc.edu.ph'], ['name'=>'System Administrator','password'=>Hash::make('Admin@TMC2024'),'role'=>'admin']);
        User::firstOrCreate(['email'=>'staff@tmc.edu.ph'], ['name'=>'Lost and Found Staff','password'=>Hash::make('Staff@TMC2024'),'role'=>'staff']);
        User::firstOrCreate(['email'=>'student@tmc.edu.ph'], ['name'=>'Sample Student','student_id'=>'TMC-2026-001','password'=>Hash::make('Student@TMC2024'),'role'=>'student']);
        collect([['Electronics','fa-laptop'],['Clothing','fa-shirt'],['Documents','fa-file-lines'],['Accessories','fa-glasses'],['Bags','fa-briefcase'],['Keys','fa-key'],['Others','fa-box']])->each(fn($item)=>Category::firstOrCreate(['name'=>$item[0]], ['icon'=>$item[1]]));
    }
}
