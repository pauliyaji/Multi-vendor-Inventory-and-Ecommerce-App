<?php

namespace App\Http\Controllers;

use App\Models\Trxtype;
use Illuminate\Http\Request;

class TrxtypesController extends Controller
{
    public function index()
    {
        $data = Trxtype::all();

        return view ('trxtypes.index', ['data'=>$data]);

        // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('trxtypes.create');
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
            'type'=>'required',
        ]);
        $data = Trxtype::create($request->all());
        return redirect()->route('trxtypes.index')->with('success', 'New recored entered successfully');
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
        $data = Trxtype::find($id);
        return view ('trxtypes.edit', ['data'=>$data]);
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
        $data = Trxtype::find($id);
        if($data){
            $data->type = $request->type;
            $data->update();
            return redirect()->route('trxtypes.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('trxtypes.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Trxtype::find($id);
        $data->delete();

        return redirect()->route('trxtypes.index')
            ->with('success', 'Method deleted successfully');
    }
}
