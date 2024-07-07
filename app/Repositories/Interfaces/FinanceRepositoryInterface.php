<?php

namespace App\Repositories\Interfaces;

interface FinanceRepositoryInterface
{
    public function getMonthBalance(): float;
    public function getMonthEconomy(): float;
}
