<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class customersController extends Controller
{
    public function index()
    {
        $data = Customer::all();

        return view ('customers.index', ['data'=>$data]);

        // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('customers.create');
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
            'name'=>'required',
            'phone'=>'required',

        ]);
        $data = Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'New recored entered successfully');
    }

    public function add(Request $request)
    {
        Customer::Create(
            [
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

        return response()->json([
            'success'=>200,
            'message'=>'Customer added successfully.']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::find($id);
        return view('customers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::find($id);
        return view ('customers.edit', ['data'=>$data]);
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
        $data = Customer::find($id);
        if($data){
            $data->name = $request->name;
            $data->addreess = $request->addreess;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->update();
            return redirect()->route('customers.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('customers.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Customer::find($id);
        $data->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Method deleted successfully');
    }
}
