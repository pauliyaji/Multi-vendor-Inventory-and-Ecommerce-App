<?php

namespace App\Http\Controllers;

use App\Models\Approvalstatus;
use Illuminate\Http\Request;

class ApprovalstatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Approvalstatus::all();

        return view ('approvalstatuses.index', ['data'=>$data]);

        // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('approvalstatuses.create');
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
            'status'=>'required',
        ]);
        $data = Approvalstatus::create($request->all());
        return redirect()->route('approvalstatuses.index')->with('success', 'New recored entered successfully');
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
        $data = Approvalstatus::find($id);
        return view ('approvalstatuses.edit', ['data'=>$data]);
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
        $data = Approvalstatus::find($id);
        if($data){
            $data->status = $request->status;
            $data->update();
            return redirect()->route('approvalstatuses.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('approvalstatuses.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Approvalstatus::find($id);
        $data->delete();

        return redirect()->route('approvalstatuses.index')
            ->with('success', 'Method deleted successfully');
    }
}
