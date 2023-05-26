<?php

namespace DoubleThreeDigital\SimpleCommerce\Orders\Calculator;

use DoubleThreeDigital\SimpleCommerce\Contracts\Calculator as Contract;
use DoubleThreeDigital\SimpleCommerce\Contracts\Order;
use Illuminate\Support\Facades\Pipeline;

class Calculator implements Contract
{
    public static function calculate(Order $order): Order
    {
        return Pipeline::send($order)
            ->through([
                LineItemCalculator::class,
                LineItemTaxCalculator::class,
                CalculateItemsTotal::class,
                CouponCalculator::class,
                ShippingCalculator::class,
                CalculateGrandTotal::class,
            ])
            ->thenReturn();
    }
}
