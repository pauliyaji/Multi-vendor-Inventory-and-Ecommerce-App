<?php

namespace App\Http\Controllers;

use App\Models\Dps;
use App\Models\Sccu;
use App\Models\Shop;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Keygen\Keygen;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $states = State::all();
        return view('users.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
          'name' => 'required',
          'email' => 'required:unique',
          'phone' => 'required',
          'password' => 'required',
          'state_id' => 'required',

        ]);

        if($request->hasFile('photo')){
            $filenamewithExt = $request->file('photo')->getClientOriginalName();
            $imgPath = $request->file('photo')->storeAs('public/imgs', $filenamewithExt);
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->photo = $filenamewithExt;
            $user->state_id = $request->state_id;
            $user->address = $request->address;
            $user->nok_name = $request->nok_name;
            $user->nok_phone = $request->nok_phone;
            $user->cv = $request->cv;
            $user->salary = $request->salary;
            $user->date_of_engagement = $request->date_of_engagement;
            $user->health_info = $request->health_info;
            $user->coverage_area = $request->coverage_area;
            $user->save();
        }
        else{
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->state_id = $request->state_id;
            $user->address = $request->address;
            $user->nok_name = $request->nok_name;
            $user->nok_phone = $request->nok_phone;
            $user->cv = $request->cv;
            $user->salary = $request->salary;
            $user->date_of_engagement = $request->date_of_engagement;
            $user->health_info = $request->health_info;
            $user->coverage_area = $request->coverage_area;


            $user->save();
        }
        return redirect()->back()->with('success', 'User added successfully');
    }

    public function show($id)
    {
        $data = User::find($id);
        return view('users.show', compact('data'));
    }

    public function edit(User $user)
    {

        $states = State::all();
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get(),
            'states' => $states,

        ]);
    }

    public function update(Request $request, $id)
    {

        if($request->hasFile('photo')){

            $filenamewithExt = $request->file('photo')->getClientOriginalName();
            $imgPath = $request->file('photo')->storeAs('public/imgs', $filenamewithExt);
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->state_id = $request->state_id;
            $user->address = $request->address;
            $user->nok_name = $request->nok_name;
            $user->nok_phone = $request->nok_phone;
            $user->cv = $request->cv;
            $user->salary = $request->salary;
            $user->date_of_engagement = $request->date_of_engagement;
            $user->health_info = $request->health_info;
            $user->coverage_area = $request->coverage_area;

            if($request->password){
                $user->password = $request->password;
            }
            $user->photo = $filenamewithExt;
            $user->save();
            $user->syncRoles($request->get('role'));

            $myroles = $request->get('role');
            $shop = Shop::where('user_id', $user->id)->first();
            if($myroles == 4 and $shop == null){
                $newshop = new Shop();
                $newshop->shop_no = Keygen::numeric(5)->generate();
                $newshop->user_id = $user->id;
                $newshop->phone = $user->phone;
                $newshop->date_of_engagement = $user->date_of_engagement;
                $newshop->coverage_area = $user->coverage_area;
                $newshop->save();
            }
        }
        else{

            $user = User::find($id);
            $user->name = $request->name;
            if($request->password){
                $user->password = $request->password;
            }
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->state_id = $request->state_id;
            $user->address = $request->address;
            $user->nok_name = $request->nok_name;
            $user->nok_phone = $request->nok_phone;
            $user->cv = $request->cv;
            $user->salary = $request->salary;
            $user->date_of_engagement = $request->date_of_engagement;
            $user->health_info = $request->health_info;
            $user->coverage_area = $request->coverage_area;

            $user->save();
            $user->syncRoles($request->get('role'));

            $myroles = $request->get('role');
            $shop = Shop::where('user_id', $user->id)->first();
            if($myroles == 4 and $shop == null){
                $newshop = new Shop();
                $newshop->shop_no = Keygen::numeric(5)->generate();
                $newshop->user_id = $user->id;
                $newshop->phone = $user->phone;
                $newshop->date_of_engagement = $user->date_of_engagement;
                $newshop->coverage_area = $user->coverage_area;
                $newshop->status = 2;
                $newshop->save();
            }
        }
       // $data = $id;
        return redirect()->back()->with('success', 'User updated successfully');

    }

    public function destroy()
    {
        //
    }
}
