<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Productiontrx;
use App\Models\Rawmaterial;
use App\Models\Storereport;
use App\Models\Storetrx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Keygen\Keygen;

class ProductiontrxsController extends Controller
{
    public function index()
    {
        $data = Storetrx::all()->sortBy('barcode_id');

        return view ('productions.index', ['data'=>$data]);
    }

    public function materials(Request $request){
       $ptn_no =  $request->ptn_id;
       $ptnid = Barcode::where('id', $ptn_no)->first();

       $data = Storetrx::where('barcode_id', $ptn_no)->get();

       $productions = Productiontrx::where('ptn_no', $ptnid->ptn_no)->first();

       if($productions == null ){
           return view('productions.add', compact('data'));
       }
       else{
           $data = Productiontrx::where('ptn_no', $ptn_no)->get();
           return redirect()->route('productions.show', $ptn_no);
       }
    }

    public function mats($id){
        $ptn_no =  $id;
        $ptnid = Barcode::where('id', $ptn_no)->first();

        $data = Storetrx::where('barcode_id', $ptn_no)->get();

        $productions = Productiontrx::where('ptn_no', $ptnid->ptn_no)->first();

        if($productions == null ){
            return view('productions.add', compact('data'));
        }
        else{
            $data = Productiontrx::where('ptn_no', $ptn_no)->get();
            return redirect()->route('productions.show', $ptn_no);
        }
    }
    public function list(){

        $data = Productiontrx::all();
        $ptn = Barcode::all();

        return view('productions.list', compact('data', 'ptn'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barcodes = Barcode::all();
       // $transactions = where;

        $storetrxs = Storereport::all();
        return view ('productions.create', ['barcodes'=>$barcodes, 'storetrxs'=>$storetrxs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());

        $this->validate($request, [
            'rawmaterial_id'=>'required',
            'barcode_id'=>'required',
            'qty_used'=>'required',
            'waste' => 'required',
        ]);
       // return response()->json($request->all());

        for($barcode_id=0; $barcode_id < count($request->barcode_id); $barcode_id++) {
            $trx_no = Keygen::numeric(5)->generate();
            $data = new Productiontrx();
            $data->rawmaterial_id = $request->rawmaterial_id[$barcode_id];
            $data->qty_collected = $request->qty_collected[$barcode_id];
            $data->ptn_no = $request->barcode_id[$barcode_id];
            $data->qty_used = $request->qty_used[$barcode_id];
            $data->waste = $request->waste[$barcode_id];
            $data->qty_returned = $request->qty_returned[$barcode_id];
            $data->trx_no = $trx_no[$barcode_id];
            $data->date_of_trx = $request->date_of_trx[$barcode_id];
            $data->user_id = Auth::user()->id;
            $data->remarks = $request->remarks[$barcode_id];
            $data->save();
        }
        return redirect()->route('productions.list')->with('success', 'New recored entered successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ptn_no =  $id;
        $ptnid = Barcode::where('id', $ptn_no)->first();
      //  $data = Storetrx::where('barcode_id', $ptn_no)->get();

        $productions = Productiontrx::where('ptn_no', $ptnid->ptn_no)->get();

        return view('productions.show', compact('productions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ptn_no =  $id;
        $ptnid = Barcode::where('id', $ptn_no)->first();
        $data = Storetrx::where('barcode_id', $ptn_no)->get();

        $productions = Productiontrx::where('ptn_no', $ptnid->ptn_no)->first();

        return view ('productions.edit', compact('productions'));
    }

    public function add($id){
        $record = Barcode::find($id);
        $data = Productiontrx::where('ptn_no', $record->ptn_no)->first();

        if($data == null){
            $rawmatscollected = Storetrx::where('barcode_id', $id)->where('trxtype_id', 1)->first();
            $returned = Storetrx::where('barcode_id', $id)->where('trxtype_id', 2)->first();
            // $rawmatsreturned = $returned->qty;
           // dd($rawmatscollected);
            if($rawmatscollected == null){
                return redirect()->back()->with('error', 'No raw material collected yet');
            }
            if($returned == null){
                $rawmatsreturned = 0;
                return view ('productions.create', compact('rawmatscollected', 'rawmatsreturned'));
            }else{
                $rawmatsreturned = $returned->qty;
                return view ('productions.create', compact('rawmatscollected', 'rawmatsreturned'));
            }
        }
        return redirect()->route('productions.index')->with('message', 'Please you can only update this record');
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
        $data = Productiontrx::find($id);
        if($data){
            $data->method = $request->paymethod;
            $data->update();
            return redirect()->route('productions.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('productions.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Productiontrx::find($id);
        $data->delete();

        return redirect()->route('productions.index')
            ->with('success', 'Method deleted successfully');
    }
}
