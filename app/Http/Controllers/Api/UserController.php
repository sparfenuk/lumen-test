<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Auth\RecoverPasswordRequest;
use App\Http\Resources\CompanyResource;
use App\Repository\CompanyRepository;
use App\Scopes\SearchCompaniesByUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getCompanies(CompanyRepository $companyRepository)
    {
        $user = Auth::user();
        $companies = $companyRepository->scope(new SearchCompaniesByUser($user))->get();
        return response()->json(CompanyResource::collection($companies));
    }
}
