<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(
            [
                'email'=>'admin',
                'password'=> 'secret', //Cifrado de la contraseña abc123
                'rule_id'=>'1',
            ]);
    }
}
