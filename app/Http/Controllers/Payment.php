<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nafezly\Payments\Classes\PaymobPayment;

class Payment extends Controller
{
    public function pay()
    {
        $payment = new PaymobPayment();

//pay function
        $payment->source = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TnpJeU9EWXdMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuRzZuU2VXX2tOajFSLXZDRjVlTldMS1FzbTJBNDllRmhWZ2VwTFlISTBkMmdXaDBXTmx1UEV6OWctOUc4U1hDNmNIaUNtdDBVeUdpZjlwRjBsQ0VvRkE=";
        return $payment;
    }
}
