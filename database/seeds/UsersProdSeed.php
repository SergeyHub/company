<?php

use Illuminate\Database\Seeder;
use App\Entity\User\User;

class UsersProdSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=140; $i<240; $i++) {
            $email = 'man'.$i.'@mybestgigolo.com';
            $password = 'mybestgigolo123';

            $user = new User();
            $user->name = 'Noname';
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->email_verified_at = now();
            $user->saveOrFail();

            echo $email . PHP_EOL;
            echo $password . PHP_EOL;
            echo PHP_EOL;
        }
    }
}
