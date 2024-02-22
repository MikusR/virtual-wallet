<?php

namespace App\Rules;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


class HasEnoughBalance implements Rule, DataAwareRule
{
    protected $data = [];

    public function __construct()
    {
        //
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }


    public function passes($attribute, $value): bool
    {
        $balance = Wallet::where('id', $this->data['from'])
            ->withSum('transactions', 'amount')
            ->first()->transactions_sum_amount;
        return $value <= $balance;
    }


    public function message(): string
    {
        return 'Amount larger than balance!';
    }
}
