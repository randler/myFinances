<?php

namespace App\Repositories\Interfaces;

interface ExpensesRepositoryInterface
{
    public function getMonthExpenses(): float;
    public function getMonthExpensesPaid(): float;
    public function getMonthExpensesToPaid(): float;
}
