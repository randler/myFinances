<?php

namespace App\Repositories\Interfaces;

interface InvestmentsRepositoryInterface
{
    public function getMonthBalance(): float;
    public function getMonthEconomy(): float;
}
