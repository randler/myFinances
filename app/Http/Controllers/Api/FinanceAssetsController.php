<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FinanceAssetsRepositories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FinanceAssetsController extends Controller
{

    public function listMonth(FinanceAssetsRepositories $financeAssetsRepositories)
    {
        return response()->json([
            'message' => 'Finance list',
            'finance' => $financeAssetsRepositories->getCurrentMonthBalance()->get()
        ]);
    }

    public function list(FinanceAssetsRepositories $financeAssetsRepositories)
    {
        return response()->json([
            'message' => 'Finance list',
            'finance' => $financeAssetsRepositories->listAssets()
        ], Response::HTTP_OK);
    }
}
