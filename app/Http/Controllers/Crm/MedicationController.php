<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Crm\Medication;
use App\Http\Resources\Crm\MedicationResource;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get vaccines
        $medications = Medication::with('category')->get();

        // Return collection of vaccines as a resource
        return MedicationResource::collection($medications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Medication $medication
     * @return \Illuminate\Http\Response
     */
    public function show(Medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Medication $medication
     * @return \Illuminate\Http\Response
     */
    public function edit(Medication $medication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Crm\Medication $medication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medication $medication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Crm\Medication $medication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medication $medication)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Laravue\Models\Crm\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function medications(Request $request)
    {
        // Get vaccines
        $medications = Medication::where($_REQUEST)->orderBy('application', 'desc')->with('category')->get();

        // Return collection of vaccines as a resource
        return MedicationResource::collection($medications);
    }
}
