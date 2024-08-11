<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FinanceAssetsFindRequest;
use App\Http\Requests\Api\FinanceAssetsStoreRequest;
use App\Http\Requests\Api\FinanceAssetsUpdateRequest;
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

    public function store(FinanceAssetsStoreRequest $request, FinanceAssetsRepositories $financeAssetsRepositories)
    {
        try {
            $financeAssets = $financeAssetsRepositories->store($request->all());
            return response()->json([
                'message' => 'Finance created',
                'finance' => $financeAssets
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(FinanceAssetsUpdateRequest $request, FinanceAssetsRepositories $financeAssetsRepositories)
    {
        try {
            $financeAssets = $financeAssetsRepositories->update($request->all());
            return response()->json([
                'message' => 'Finance updated',
                'finance' => $financeAssets
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request, FinanceAssetsRepositories $financeAssetsRepositories)
    {
        try {
            $financeAssets = $financeAssetsRepositories->delete($request->get('id'));
            return response()->json([
                'message' => 'Finance deleted',
                'finance' => $financeAssets
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function find(FinanceAssetsFindRequest $request, FinanceAssetsRepositories $financeAssetsRepositories)
    {
        try {
            return response()->json([
                'message' => 'Finance found',
                'finance' => $financeAssetsRepositories->find($request->all())
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
