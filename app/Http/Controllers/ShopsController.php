<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Shopstatus;
use App\Models\User;
use Illuminate\Http\Request;
use Keygen\Keygen;

class ShopsController extends Controller
{
    public function index(){
        $data = Shop::all();
        return view('shops.index', compact('data'));
    }

    public function create(){
     // A new shop is created at the point of updating a new user
    }

    public function show($id){
        $data = Shop::find($id);
        return view('shops.show', compact('data'));

    }

    public function edit($id){
        $data = Shop::find($id);
        $statuses = Shopstatus::all();
        $users = User::all();
        return view('shops.edit', compact('data', 'statuses', 'users'));
    }

    public function update(Request $request, $id){
        $data = Shop::find($id);
        $data->status = $request->status_id;
        $data->update();

        return redirect()->route('shops.index')->with('success', 'Record successfully updated');
    }
}
