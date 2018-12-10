<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function create(Request $request){
        return view('incident.create')->with([
            'vehicles'=>\App\Vehicle::all(),
            'laws' => \App\Law::all()
        ]);
    }
    public function save(Request $request){
        $validatedData = $request->validate([
            'details' => 'required',
            'title' => 'required',
            'vehicle_id' => 'required',
            'place' => 'required',
            'long' => 'required',
            'lati' => 'required',
            'law_id' => 'required',
            'vehicle_no' => 'required|unique:drivers'
        ]);
        $driver = \App\Driver::where('vehicle_no',$vehicle_no)->first();
        $incident = new \App\Incident;
        $incident->details = $request->details;
        $incident->title = $request->title;
        $incident->place = $request->place;
        $incident->long = $request->long;
        $incident->lati = $request->lati;
        $incident->law_id = $request->law_id;
        $incident->vehicle_no = $request->vehicle_no;

        $driver->incidents()->save($incident);
        return redirect('/incidents');
    }
    public function read(Request $request){
        $incidents = \App\Incident::paginate(15);
        return view('incident.read')->with(['incidents'=>$incidents]);
    }
    public function view(Request $request,Incident $incident){
        return view('incident.view')->with(['incident'=>$incident]);
    }
    public function edit(Request $request,Incident $incident){
        return view('incident.edit')->with(['incident'=>$incident]);
    }
    public function update(Request $request,Incident $incident){
        $validatedData = $request->validate([
            'details' => 'required',
            'title' => 'required',
            'vehicle_id' => 'required',
            'place' => 'required',
            'long' => 'required',
            'lati' => 'required',
            'law_id' => 'required',
            'vehicle_no' => 'required|unique:drivers'
        ]);
        $driver = \App\Driver::where('vehicle_no',$vehicle_no)->first();
        
        $incident->details = $request->details;
        $incident->title = $request->title;
        $incident->place = $request->place;
        $incident->long = $request->long;
        $incident->lati = $request->lati;
        $incident->law_id = $request->law_id;
        $incident->vehicle_no = $request->vehicle_no;

        $driver->incidents()->save($incident);
        return redirect('/incidents');
    }
    public function delete(Request $request,Incident $incident){
        $incident->delete();
        return redirect()->back();
    }
}
