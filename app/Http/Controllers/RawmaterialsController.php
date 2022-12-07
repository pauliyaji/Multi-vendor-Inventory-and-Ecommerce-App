<?php

namespace App\Http\Controllers;

use App\Models\Rawmaterial;
use App\Models\Unitofmeasure;
use Illuminate\Http\Request;

class RawmaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Rawmaterial::all();
        return view('rawmaterials.index', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unitofmeasure::all();
        return view ('rawmaterials.create',['units'=>$units]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'unit_price'=> 'required',
            'unit_of_measure_id' => 'required',
            're_order'=>'required',
        ]);
        $data = Rawmaterial::create($request->all());
        return redirect()->route('rawmaterials.index')->with('success', 'Record added successfully');
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
        $data = Rawmaterial::find($id);
        $units = Unitofmeasure::all();

        return view ('rawmaterials.edit', ['data'=>$data, 'units'=>$units]);
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
        $data = Rawmaterial::find($id);
        $data->name = $request->name;
        $data->unit_price = $request->unit_price;
        $data->unit_of_measure_id = $request->unit_of_measure_id;
        $data->re_order = $request->re_order;
        $data->update();

        return redirect()->route('rawmaterials.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Rawmaterial::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
