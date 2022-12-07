<?php

namespace App\Http\Controllers;

use App\Models\Factorystore;
use App\Models\Paymentmethod;
use App\Models\Paymentstatus;
use App\Models\Rawmaterial;
use App\Models\Storereport;
use App\Models\Supplier;
use App\Models\Unitofmeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FactorystoresController extends Controller
{
    public function index()
    {
        $data = Factorystore::all();
        $total_supply = Factorystore::sum('total_price');
        $total_amountpaid = Factorystore::sum('amount_paid');
        $total_balance = Factorystore::sum('balance');

        return view('factorystores.index', ['data'=>$data, 'total_supply'=>$total_supply,
            'total_amountpaid'=>$total_amountpaid, 'total_balance'=>$total_balance]);
    }

    public function restock($id){
        $data = Rawmaterial::find($id); $units = Unitofmeasure::all();
        $units = Unitofmeasure::all();
        $paymentmethods = Paymentmethod::all();
        $paymentstatuses = Paymentstatus::all();
        $suppliers = Supplier::all();
        return view('factorystores.restocking', compact('data', 'paymentmethods',
        'paymentstatuses', 'suppliers', 'units'));
    }

    public function create()
    {
        $units = Unitofmeasure::all();
        $paymentmethods = Paymentmethod::all();
        $paymentstatuses = Paymentstatus::all();
        $suppliers = Supplier::all();
        $rawmaterials = Rawmaterial::all();
        return view ('factorystores.create',['units'=>$units, 'paymentmethods'=>$paymentmethods,
            'paymentstatuses'=>$paymentstatuses, 'suppliers'=>$suppliers, 'rawmaterials'=>$rawmaterials]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rawmaterial_id' => 'required',
            'units_id' => 'required',
            'paymentmethod_id' => 'required',
            'qty' => 'required',
            'date_of_supply'=> 'required',
            'supplier_id'=>'required',
            'amount_paid'=>'required',
          //  'message' => ['required', 'string', 'max:255']
        ]);

        $data = new Factorystore();
        $data->rawmaterial_id = $request->rawmaterial_id;
        $data->units_id = $request->units_id;
        $data->supplier_id = $request->supplier_id;
        $data->paymentmethod_id = $request->paymentmethod_id;
        $data->qty = $request->qty;
        $data->date_of_supply = $request->date_of_supply;
        $data->remarks = $request->remarks;
        $data->unit_price = $request->unit_price;
        $data->total_price = $request->total_price;
        $data->amount_paid = $request->amount_paid;
        $data->balance = $request->balance;
        if($request->amount_paid == $request->total_price){
            $data->paymentstatus_id = '1';
        }else if($request->amount_paid == 0){
            $data->paymentstatus_id = '2';
        }else {
            $data->paymentstatus_id = '3';
        }
        $data->user_id = Auth::user()->id;

        $data->save();

        $item = Rawmaterial::where('id', $data->rawmaterial_id)->first();
        $currentitem = $item->id;
        $re_order = $item->re_order;
        Session::put('order_level', $re_order);
        //dd($re_order);
        $storereport = Storereport::where('rawmaterial', $currentitem)->first();
        if($storereport != null){
            $oldqty = $storereport->qty;
            $newqty = $oldqty + $data->qty;
            $oldtotalprice = $storereport->total_price;
            $newtotalprice = $oldtotalprice + $data->total_price;
            $storereport->rawmaterial = $item->id;
            $storereport->qty = $newqty;
            $storereport->total_price = $newtotalprice;
            $storereport->re_order = $re_order;
            $storereport->update();
        }else{
            $newrec = new Storereport();
            $newrec->rawmaterial = $item->id;
            $newrec->qty = $data->qty;
            $newrec->total_price = $data->total_price;

            $orderLevel = Session::get('order_level');
            $newrec->re_order = $orderLevel;
            $newrec->save();
        }
        return redirect()->route('factorystores.index')->with('success', 'Record added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Factorystore::find($id);
        return view('factorystores.show', ['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Factorystore::find($id);
        $units = Unitofmeasure::all();
        $paymentmethods = Paymentmethod::all();
        $paymentstatus = Paymentstatus::all();
        $suppliers = Supplier::all();
        $rawmaterials = Rawmaterial::all();
        return view ('factorystores.edit', ['data'=>$data, 'units'=>$units, 'paymentmethods'=>$paymentmethods,
            'paymentstatus'=>$paymentstatus, 'suppliers'=>$suppliers, 'rawmaterials'=>$rawmaterials]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = Factorystore::find($id);
        $data->rawmaterial_id = $request->rawmaterial_id;
        $data->units_id = $request->units_id;
        $data->supplier_id = $request->supplier_id;
        $data->paymentmethod_id = $request->paymentmethod_id;
        //$data->qty = $request->qty;
        $data->date_of_supply = $request->date_of_supply;
        $data->remarks = $request->remarks;
        $data->unit_price = $request->unit_price;
        $data->total_price = $request->total_price;
        $data->amount_paid = $request->amount_paid;
        $data->balance = $request->balance;
        if($request->amount_paid == $request->total_price){
            $data->paymentstatus_id = '1';
        }else if($request->amount_paid == 0){
            $data->paymentstatus_id = '2';
        }else {
            $data->paymentstatus_id = '3';
        }
        $data->user_id = Auth::user()->id;

        $data->update();

        return redirect()->route('factorystores.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Factorystore::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
