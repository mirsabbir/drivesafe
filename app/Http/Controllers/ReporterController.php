<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporter;

class ReporterController extends Controller
{
    public function create(Request $request){
        return view('reporter.create');
    }
    public function save(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'phone' => 'required|size:11',
            'address' => 'required|max:191',
            'place_name' => 'required',
            'email' => 'required',
            'long' => 'required',
            'lati' => 'required',
            'password' => 'required|min:6',
            'image' => 'required'
        ]);

        $image = $request->file('image');
        $name = time().'.'.$image->getOriginalClientExtension();
        $image->resize(100, 100);
        $image->save(public_path('img'));

        $user = new \App\User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->password = \Hash::make($request->password);
        $user->image = $name;


        $reporter = new \App\Reporter;
        $reporter->long = $request->long;
        $reporter->lati = $request->lati;
        $reporter->place_name = $request->place_name;

        $user->reporter()->save($reporter);

        return redirect('/reporters');
    
    }
    public function read(Request $request){
        $reporters = \App\Reporter::paginate(15);
        return view('reporter.read')->with(['reporters'=>$reporters]);
    }
    public function view(Request $request,Reporter $reporter){
        return view('reporter.view')->with(['reporter'=>$reporter]);
    }
    public function edit(Request $request,Reporter $reporter){
        return view('reporter.edit')->with(['reporter'=>$reporter]);
    }
    public function update(Request $request,Reporter $reporter){
        
        $user = \App\User::where('userable_id',$reporter->id)->first();
        
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'phone' => 'required|size:11',
            'address' => 'required|max:191',
            'place_name' => 'required',
            'email' => 'required',
            'long' => 'required',
            'lati' => 'required',
            'password' => 'required',
        ]);
        if($user->password!=\Hash::make($request->password) && \Auth::user()->password!=\Hash::make($request->password)){
            $request->session()->flash('password','password didn\'t match');
            return redirect()->back();
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getOriginalClientExtension();
            $image->resize(100, 100);
            $image->save(public_path('img'));
        } else {
            $name = $user->image;
        }
        
        $user = \App\User::where('userable_id',$reporter->id)->first();
        
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        
        $user->image = $name;


        
        $reporter->long = $request->long;
        $reporter->lati = $request->lati;
        $reporter->place_name = $request->place_name;

        $user->reporter()->save($reporter);

        return redirect('/reporters');
    }
    public function delete(Request $request,Reporter $reporter){
        $repoter->delete();
        return redirect()->back();
    }
}
