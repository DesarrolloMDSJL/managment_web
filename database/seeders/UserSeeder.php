<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();            
        $user->name= "Administrador";
        $user->lastname= "Administrador";
        $user->document= "12345678";       
        $user->password= 'micronics'; 
        $user->role="A";
        $user->save();
    }
}
