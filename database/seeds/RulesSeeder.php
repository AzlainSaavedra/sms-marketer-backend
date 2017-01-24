<?php

use Illuminate\Database\Seeder;
use App\Rule;



class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rule::create(
            [
                'type'=>'admin',
                'name'=> 'Administrador', //Cifrado de la contraseña abc123
            ]);
        Rule::create(
            [
                'type'=>'operator',
                'name'=> 'Operador', //Cifrado de la contraseña abc123
            ]);
        Rule::create(
            [
                'type'=>'client',
                'name'=> 'Cliente', //Cifrado de la contraseña abc123
            ]);
    }
}
