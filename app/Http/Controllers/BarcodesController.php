<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Product;
use App\Models\Productiontrx;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Keygen\Keygen;

class BarcodesController extends Controller
{
    public function index()
    {
        $data = Barcode::latest('id')->get();

        return view ('barcodes.index', ['data'=>$data]);

        // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view ('barcodes.create',['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date_of_production'=>'required',
            'product_id'=>'required',
        ]);
       // dd($request->all());
        $myDate = $request->date_of_production;
        $date = Carbon::parse($myDate);
        $weekNumber = $date->weekOfYear;
        if($weekNumber < 10){
            $week = "0". $weekNumber;
        }else{
            $week = $weekNumber;
        }

       // $dateyear = Carbon::createFromFormat('yy-d-m', $myDate)->format('y');
        $dateyear = Carbon::now()->format('Y');
        $year = substr($dateyear, -2);

       // $month = Carbon::createFromFormat('Y-m-d', $myDate)->format('m');

        $product = $request->product_id;
        if($product < 10){
            $product_no = "0". $product;
        }else{
            $product_no = $product;
        }
        $lid = Keygen::numeric(4)->generate();
        $ptn = $week.$year.$product_no.$lid;

        $data = new Barcode();
        $data->ptn_no = $ptn;
        $data->product_id = $product;
        $data->output_qty = $request->output_qty;
        $data->date_of_production = $request->date_of_production;
        $data->save();

        /* $ptn_rec = new Productiontrx();
        $ptn_rec->ptn_no = $data->ptn_no;
        $ptn_rec->save();*/

        return redirect()->route('barcodes.index')->with('success', 'New recored entered successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::all();
        $data = Barcode::find($id);
        return view ('barcodes.edit', ['data'=>$data, 'products'=>$products]);
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

        $myDate = $request->date_of_production;
        $date = Carbon::parse($myDate);
        $weekNumber = $date->weekOfYear;
        if($weekNumber < 10){
            $week = "0". $weekNumber;
        }else{
            $week = $weekNumber;
        }

        // $dateyear = Carbon::createFromFormat('yy-d-m', $myDate)->format('y');
        $dateyear = Carbon::now()->format('Y');
        $year = substr($dateyear, -2);

        // $month = Carbon::createFromFormat('Y-m-d', $myDate)->format('m');

        $product = $request->product_id;
        if($product < 10){
            $product_no = "0". $product;
        }else{
            $product_no = $product;
        }
        $lid = Keygen::numeric(4)->generate();
        $ptn = $week.$year.$product_no.$lid;

        $data = Barcode::find($id);
        $data->ptn_no = $ptn;
        $data->product_id = $product;
        $data->output_qty = $request->output_qty;
        $data->date_of_production = $request->date_of_production;
        $data->update();

        return redirect()->route('barcodes.index')->with('success', 'Records updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Barcode::find($id);
        $data->delete();

        return redirect()->route('barcodes.index')
            ->with('success', 'Method deleted successfully');
    }
}
