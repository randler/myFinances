<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Expenses\ExpensesFindRequest;
use App\Http\Requests\Api\Expenses\ExpensesStoreRequest;
use App\Http\Requests\Api\Expenses\ExpensesUpdateRequest;
use App\Repositories\ExpensesRepositories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpensesController extends Controller
{
	public function listMonth(ExpensesRepositories $expensesRepositories)
    {
        return response()->json([
            'message' => 'Expenses list',
            'expenses' => $expensesRepositories->getCurrentMonthExpenses()->get()
        ]);
    }

	public function list(ExpensesRepositories $expensesRepositories)
    {
        return response()->json([
            'message' => 'Expenses list',
            'expenses' => $expensesRepositories->listAssets()
        ], Response::HTTP_OK);
    }

	public function store(ExpensesStoreRequest $request, ExpensesRepositories $expensesRepositories)
    {
        try {
            $expenses = $expensesRepositories->store($request->all());
            return response()->json([
                'message' => 'Expenses created',
                'expenses' => $expenses
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

	public function update(ExpensesUpdateRequest $request, ExpensesRepositories $expensesRepositories)
    {
        try {
            $expenses = $expensesRepositories->update($request->all());
            return response()->json([
                'message' => 'Expenses updated',
                'expenses' => $expenses
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

	public function delete(Request $request, ExpensesRepositories $expensesRepositories)
    {
        try {
            $expenses = $expensesRepositories->delete($request->get('id'));
            return response()->json([
                'message' => 'expenses deleted',
                'expenses' => $expenses
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

	public function find(ExpensesFindRequest $request, ExpensesRepositories $expensesRepositories)
    {
        try {
            return response()->json([
                'message' => 'expenses found',
                'expenses' => $expensesRepositories->find($request->all())
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}