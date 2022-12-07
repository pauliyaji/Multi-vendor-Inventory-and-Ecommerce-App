<?php

namespace App\Http\Controllers;

use App\Models\Orderdetail;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id){
        $order_receipt = Orderdetail::where('order_id', $id)->get();
        $invoice_no = Orderdetail::where('order_id', $id)->first();
        $transaction = Transaction::where('order_id', $id)->first();
        return view('invoices.show', compact('order_receipt',  'transaction','invoice_no'));
    }

    Public function receipts($id){
        $order_receipt = Orderdetail::where('order_id', $id)->get();
        $invoice_no = Orderdetail::where('order_id', $id)->first();
        $transaction = Transaction::where('order_id', $id)->first();
        return view('invoices.receipt', compact('order_receipt',  'transaction','invoice_no'));

    }
}
