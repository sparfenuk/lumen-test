<?php

namespace App\Repository;

use App\Company;
use App\Http\Resources\UserResource;
use App\Repository\Traits\HasJsonResource;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends Repository
{
    use HasJsonResource;

    protected $entityClass = User::class;
    protected $jsonResource = UserResource::class;

    public function create(array $data)
    {
        $data['password'] = app('hash')->make($data['password']);
        $data['email_token'] = Str::random(32);
        return parent::create($data);
    }
}
