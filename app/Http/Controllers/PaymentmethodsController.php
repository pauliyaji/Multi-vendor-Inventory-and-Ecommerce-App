<?php

namespace App\Http\Controllers;

use App\Models\Paymentmethod;
use Illuminate\Http\Request;

class PaymentmethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Paymentmethod::all();

            return view ('paymentmethods.index', ['data'=>$data]);

       // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('paymentmethods.create');
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
            'method'=>'required',
        ]);
        $data = Paymentmethod::create($request->all());
        return redirect()->route('paymentmethods.index')->with('success', 'New recored entered successfully');
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
        $data = Paymentmethod::find($id);
        return view ('paymentmethods.edit', ['data'=>$data]);
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
        $data = Paymentmethod::find($id);
        if($data){
            $data->method = $request->paymethod;
            $data->update();
            return redirect()->route('paymentmethods.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('paymentmethods.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Paymentmethod::find($id);
        $data->delete();

        return redirect()->route('paymentmethods.index')
            ->with('success', 'Method deleted successfully');
    }
}
