<?php

namespace App\Http\Controllers;

use App\Models\Unitofmeasure;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Unitofmeasure::all();

        return view ('units.index', ['data'=>$data]);

        // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('units.create');
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
            'unit'=>'required',
        ]);

        $data = Unitofmeasure::create($request->all());
        return redirect()->route('units.index')->with('success', 'New recored entered successfully');
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
        $data = Unitofmeasure::find($id);
        return view ('units.edit', ['data'=>$data]);
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
        $data = Unitofmeasure::find($id);
        if($data){
            $data->unit = $request->unit;
            $data->update();
            return redirect()->route('units.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('units.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Unitofmeasure::find($id);
        $data->delete();

        return redirect()->route('units.index')
            ->with('success', 'Method deleted successfully');
    }
}
