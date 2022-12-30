<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Repository\CompanyRepository;
use App\Scopes\SearchCompaniesByUser;
use App\User;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function createCompany(CompanyRequest $request, CompanyRepository $companyRepository)
    {
        try {
            $data = $request->validated();
            $data['user'] = Auth::user();
            $company = $companyRepository->create($data);
            return response()->json(new CompanyResource($company));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}
