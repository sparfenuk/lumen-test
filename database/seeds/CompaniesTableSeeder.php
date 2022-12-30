<?php

use App\Company;
use App\Repository\CompanyRepository;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    protected $repository;

    public function __construct(CompanyRepository $repository)
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
                'title' => "Company #{$i}",
                'phone' => rand(100, 999) . "-" . rand(100, 999) . "-" . rand(100, 999),
                'description' => "This is a sample company #{$i} ",
            ]);
        }
    }
}
