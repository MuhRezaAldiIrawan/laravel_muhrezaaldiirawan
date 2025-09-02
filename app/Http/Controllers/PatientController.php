<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Hospital;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::all();
        // dd($hospitals);
        return view('patients.index', compact('hospitals'));
    }

    public function list(Request $request)
    {
        $query = Patient::with('hospital');

        if ($request->has('hospital_id') && $request->hospital_id != '') {
            $query->where('hospital_id', $request->hospital_id);
        }

        return response()->json($query->get());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $patient = Patient::create($request->all());
        return response()->json($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
        return response()->json($patient);
    }

    public function filter($hospital_id = null)
    {
        $query = Patient::with('hospital');

        if ($hospital_id) {
            $query->where('hospital_id', $hospital_id);
        }

        $patients = $query->get();

        return response()->json($patients);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return response()->json(['success' => true]);
    }
}
