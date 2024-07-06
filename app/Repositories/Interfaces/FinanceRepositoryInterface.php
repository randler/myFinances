<?php

namespace App\Repositories\Interfaces;

interface FinanceRepositoryInterface
{
    public function getMonthBalance(): string;
    public function getMonthEconomy(): string;
    public function getMonthExpenses(): string;
    public function getMonthRemainingExpenses(): string;
}
