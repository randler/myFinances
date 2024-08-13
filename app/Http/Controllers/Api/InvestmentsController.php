<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Investments\InvestmentsDeleteRequest;
use App\Http\Requests\Api\Investments\InvestmentsFindRequest;
use App\Http\Requests\Api\Investments\InvestmentsStoreRequest;
use App\Http\Requests\Api\Investments\InvestmentsUpdateRequest;
use App\Repositories\InvestmentsRepositories;
use Illuminate\Http\Response;

class InvestmentsController extends Controller
{
	public function listMonth(InvestmentsRepositories $investmentsRepositories)
    {
        return response()->json([
            'message' => 'Investments list',
            'finance' => $investmentsRepositories->getCurrentMonthBalance()->get()
        ]);
    }

	public function list(InvestmentsRepositories $investmentsRepositories)
    {
        return response()->json([
            'message' => 'Investments list',
            'invetements' => $investmentsRepositories->listAssets()
        ], Response::HTTP_OK);
    }

	public function store(InvestmentsStoreRequest $request, InvestmentsRepositories $investmentsRepositories)
    {
        try {
            $investments = $investmentsRepositories->store($request->all());
            return response()->json([
                'message' => 'Investements created',
                'investements' => $investments
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

	public function update(InvestmentsUpdateRequest $request, InvestmentsRepositories $investmentsRepositories)
    {
        try {
            $investments = $investmentsRepositories->update($request->all());
            return response()->json([
                'message' => 'Investments updated',
                'investments' => $investments
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

	public function delete(InvestmentsDeleteRequest $request, InvestmentsRepositories $investmentsRepositories)
    {
        try {
            $investments = $investmentsRepositories->delete($request->get('id'));
            return response()->json([
                'message' => 'Investments deleted',
                'investments' => $investments
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

	public function find(InvestmentsFindRequest $request, InvestmentsRepositories $investmentsRepositories)
    {
        try {
            return response()->json([
                'message' => 'Investments found',
                'investments' => $investmentsRepositories->find($request->all())
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}