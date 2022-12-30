<?php

use App\Repository\UserRepository;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->repository->create([
                'first_name' => 'FirstName' . $i,
                'last_name' => 'LastName' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => 'pass',
                'phone' => rand(100, 999) . "-" . rand(100, 999) . "-" . rand(100, 999),
                'email_token' => Str::random(32),
            ]);
        }
    }
}
