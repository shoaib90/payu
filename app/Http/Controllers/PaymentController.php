<?php

namespace App\Http\Controllers;

use Tzsk\Payu\Concerns\Attributes;
use Tzsk\Payu\Concerns\Customer;
use Tzsk\Payu\Concerns\Transaction;
use Tzsk\Pay\Models\PayuTransaction;
use Tzsk\Payu\Facades\Payu;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment() {
        $customer = Customer::make()
            ->firstName('John Doe')
            ->email('john@example.com');

        $attributes = Attributes::make()
            ->udf1('anything');

        $transaction = Transaction::make()
            ->charge(100)
            ->for('Product')
            ->with($attributes)
            ->to($customer);

        return Payu::initiate($transaction)->redirect(env('APP_URL').'payment/status');
    }

    public function status() {
        $transaction = Payu::capture();
        echo $transaction->status;
    }
}
