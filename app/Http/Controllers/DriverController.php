<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\User;

class DriverController extends Controller
{
    public function create(Request $request){
        return view('driver.create')->with(['vehicles'=>\App\Vehicle::all()]);
    }
    public function save(Request $request){
    	 $validatedData = $request->validate([
        'name' => 'required|max:191',
        'driving_lisence' => 'required|size:12',
        'phone' => 'required|size:11',
        'address' => 'required',
        'email' => 'required',
        'owner_name'=>'required',
        'owner_phone'=>'required|size:11',
        'owner_address'=>'required',
        'owner_email'=>'required',
        'vehicle_id'=>'required',
        'password'=>'required|min:6',
        'image' => 'required',

    ]);

   $image=$request->file('image');
   $name=time().'.'.$image->getOriginalClientExtension();
   $image->resize(100,100);
   $image->save(public_path('img'));

   $code = 1;
   while($code < 100000 && $code > 999999 && \App\Driver::where('vehicle_no',$code)->exists()){
   $code = (time()*37)%1000000;
   }

   $user=new \App\User;
   $user->name=$request->name;
   $user->phone=$request->phone;
   $user->email=$request->email;
   $user->address=$request->address;
   $user->password=\Hash::make($request->password);
   $user->image=$name;

   //driver filled information

   $driver=new \App\Driver;
   $driver->driving_lisence=$request->driving_lisence;
   $driver->vehicle_no=$code;
   $driver->owner_name=$request->owner_name;
   $driver->owner_address=$request->owner_address;
   $driver->owner_phone=$request->owner_phone;
   $driver->owner_email=$request->owner_email;
   $driver->vehicle_id=$request->vehicle_id;

   $user->driver()->save($driver);

   return redirect('/drivers');


    }
    public function read(Request $request){

    	$drivers=\App\Driver::paginate(15);
    	return view('driver.read')->with(['drivers'=>$drivers]);	
    }
    public function view(Request $request,Driver $driver){
    	return view('driver.view')->with(['driver'=>$driver]);
    }
    public function edit(Request $request,Driver $driver){
    	return view('driver.edit')->with(['driver'=>$driver,'vehicles'=>\App\Vehicle::all()]);	
    }
    public function update(Request $request,Driver $driver){
    	$user=\App\User::where('userable_id',$driver->id)->first(); 

    	 $validatedData = $request->validate([
        'name' => 'required|max:191',
        'driving_lisence' => 'required|size:12',
        'phone' => 'required|size:11',
        'address' => 'required',
        'email' => 'required',
        'owner_name'=>'required',
        'owner_phone'=>'required|size:11',
        'owner_address'=>'required',
        'owner_email'=>'required',
        'vehicle_id'=>'required',
        'password'=>'required|min:6',

    ]);

    if ($user->password != \Hash::make($request->password) && \Auth::user()->password != \Hash::make($request->password)) {
    	$request->session()->flash('password','password doesn\'t match');
    	return redirect()->back();
    }

   if ($request->hasFile()) {
    $image=$request->file('image');
    $name=time().'.'.$image->getOriginalClientExtension();
    $image->resize(100,100);
    $image->save(public_path('img'));
   }
   else{
   	$name=$user->image;
   }

   $user->name=$request->name;
   $user->phone=$request->phone;
   $user->email=$request->email;
   $user->address=$request->address;
   $user->password=\Hash::make($request->password);
   $user->image=$name;

   //driver filled information

   
   $driver->driving_lisence=$request->driving_lisence;
   $driver->owner_name=$request->owner_name;
   $driver->owner_address=$request->owner_address;
   $driver->owner_phone=$request->owner_phone;
   $driver->owner_email=$request->owner_email;
   $driver->vehicle_id=$request->vehicle_id;

   $user->driver()->save($driver);

   return redirect('/drivers');
    }
    public function delete(Request $request,Driver $driver){
    	$driver->delete();
    	return redirect()->back();
    }
}