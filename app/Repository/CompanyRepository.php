<?php

namespace App\Repository;

use App\Company;
use App\Http\Resources\CompanyResource;
use App\Repository\Traits\HasJsonResource;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;

class CompanyRepository extends Repository
{
    use HasJsonResource;

    protected $entityClass    = Company::class;
    protected $jsonResource   = CompanyResource::class;

    public function create(array $data): Company
    {
        /** @var Company $company */
        $company = parent::create($data);
        $company->users()->attach($data['user']);
        return $company;
    }

}
