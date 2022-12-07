<?php

namespace App\Http\Controllers;

use App\Models\Approvalstatus;
use App\Models\Barcode;
use App\Models\Factorystore;
use App\Models\Rawmaterial;
use App\Models\Storereport;
use App\Models\Storetrx;
use App\Models\Trxtype;
use Illuminate\Http\Request;
use Keygen\Keygen;

class StoretrxsController extends Controller
{
    public function index()
    {
        $data = Storetrx::all();
        return view('storetrxs.index', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$rawmaterials = Rawmaterial::all();
       // $factorystores = Factorystore::all();
        //$storetrxs = Storereport::all();
        $barcodes = Barcode::all();
        $approvalstatuses = Approvalstatus::all();
        $trxtypes = Trxtype::all();
        $rawmaterials = Rawmaterial::all();

        return view ('storetrxs.create',['barcodes'=>$barcodes,
            'approvalstatuses'=>$approvalstatuses, 'trxtypes'=>$trxtypes, 'rawmaterials'=>$rawmaterials]);
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
            'rawmaterial_id'=>'required',
            'trxtype_id' => 'required',
            'approvalstatus_id' => 'required',
            'barcode_id'=>'required',
        ]);

        $trx_no = Keygen::numeric(5)->generate();


        $oldprice = Factorystore::where('rawmaterial_id', $request->rawmaterial_id)->get();

        $currentprice = Rawmaterial::where('id', $request->rawmaterial_id)->first();


        $unitprice = $currentprice->unit_price;

        $rawmat = $currentprice->name;

       // dd($request->all());
        $data = new Storetrx();
        $data->rawmaterial_id = $request->rawmaterial_id;
        //$data->total_qty = $oldprice->sum('qty');
        $data->qty = $request->qty;
        $data->unit_price = $unitprice;
        $data->total_price = $unitprice * $request->qty;
        $data->date_of_trx = $request->date_of_trx;
        $data->trx_no = $trx_no;
        $data->barcode_id = $request->barcode_id;
        $data->trxtype_id = $request->trxtype_id;
        $data->approvalstatus_id = $request->approvalstatus_id;
        $data->remarks = $request->remarks;
        $data->save();

        //updating the store inventory by adding, by returning, or by rejecting
        $storereport = Storereport::where('rawmaterial', $data->rawmaterial)->first();
      //  dd($storereport);
        if($storereport){
            if($data->trxtype_id == 1){
                $oldqty = $storereport->qty;
                $newqty = $oldqty - $data->qty;
                $oldtotalprice = $storereport->total_price;
                $newtotalprice = $oldtotalprice - $data->total_price;
                $storereport->total_qty = $oldprice->sum('qty');
                $storereport->qty = $newqty;
                $storereport->total_price = $newtotalprice;
                $storereport->update();
            }else if($data->trxtype_id == 2){
                $oldqty = $storereport->qty;
                $newqty = $oldqty + $data->qty;
                $oldtotalprice = $storereport->total_price;
                $newtotalprice = $oldtotalprice + $data->total_price;
                $storereport->qty = $newqty;
                $storereport->total_price = $newtotalprice;
                $storereport->update();
            }

        }else{
                $storereport = new Storereport();
                $storereport->rawmaterial =  $data->rawmaterial_id;
                $storereport->total_qty = $oldprice->sum('qty');
                $storereport->qty = $oldprice->sum('qty') - $data->qty;
                $storereport->total_price = $oldprice->sum('total_price') - $data->total_price;
                $storereport->re_order = $currentprice->re_order;
                $storereport->save();

        }


        return redirect()->route('storetrxs.index')->with('success', 'Record added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Storetrx::find($id);
        return view('storetrxs.show', ['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rawmaterials = Rawmaterial::all();
        $barcodes = Barcode::all();
        $approvalstatuses = Approvalstatus::all();
        $trxtypes = Trxtype::all();
        $data = Storetrx::find($id);

        return view ('storetrxs.edit',['data'=>$data, 'rawmaterials'=>$rawmaterials, 'barcodes'=>$barcodes,
            'approvalstatuses'=>$approvalstatuses, 'trxtypes'=>$trxtypes]);
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
        if($request->trxtype_id == '2'){
            $trx_no = Keygen::numeric(5)->generate();

            $data = new Storetrx();
            $data->rawmaterial = $request->rawmaterial_id;
            $data->qty = $request->qty;
            $data->unit_price = $request->unit_price;
            $data->total_price = $request->total_price;
            $data->date_of_trx = $request->date_of_trx;
            $data->trx_no = $trx_no;
            $data->barcode_id = $request->barcode_id;
            $data->trxtype_id = $request->trxtype_id;
            $data->approvalstatus_id = $request->approvalstatus_id;
            $data->remarks = $request->remarks;
            $data->save();


            return redirect()->route('storetrxs.index')->with('success', 'Record added successfully');

        }
        $data = Storetrx::find($id);
        $data->rawmaterial_id = $request->rawmaterial_id;
        $data->qty = $request->qty;
        $data->unit_price = $request->unit_price;
        $data->total_price = $request->total_price;
        $data->date_of_trx = $request->date_of_trx;
        $data->barcode_id = $request->barcode_id;
        $data->trxtype_id = $request->trxtype_id;
        $data->approvalstatus_id = $request->approvalstatus_id;
        $data->remarks = $request->remarks;
        $data->update();

        return redirect()->route('storetrxs.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Storetrx::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
