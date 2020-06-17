<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Http\Resources\Crm\VaccineResource;
use App\Laravue\Models\Crm\Vaccine;
use Illuminate\Http\Request;
use Validator;

class VaccineController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get vaccines
        $vaccines = Vaccine::all();

        // Return collection of vaccines as a resource
        return VaccineResource::collection($vaccines);
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
        $params = $request->all();
        $vaccine = Vaccine::create([
            'pet_id' => $params['pet_id'],
            'vaccinedate' => $params['vaccinedate'],
            'vaccine' => $params['vaccine'],
            'vaccinebatch' => $params['vaccinebatch'],
        ]);
        return new VaccineResource($vaccine);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccine $vaccine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaccine $vaccine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Crm\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vaccine $vaccine)
    {
        $params = $request->all();
        $vaccine->pet_id = $params['pet_id'];
        $vaccine->vaccinedate = $params['vaccinedate'];
        $vaccine->vaccine = $params['vaccine'];
        $vaccine->vaccinebatch = $params['vaccinebatch'];
        $vaccine->save();

        return new VaccineResource($vaccine);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Crm\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccine $vaccine)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Laravue\Models\Crm\Vaccine  $vaccine
     * @return \Illuminate\Http\Response
     */
    public function vaccines(Request $request)
    {
        // Get vaccines
        $vaccines = Vaccine::where($_REQUEST)->get();

        // Return collection of vaccines as a resource
        return VaccineResource::collection($vaccines);
    }
}
