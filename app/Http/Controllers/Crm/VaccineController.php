<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Http\Resources\Crm\VaccineResource;
use App\Laravue\Models\Crm\Vaccine;
use Illuminate\Http\Request;

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
        $vaccines = Vaccine::with('category')->get();

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
    public function multistore(Request $request)
    {
        $pet_id = $request->pet_id;
        $vaccines = $request->vaccines;

        foreach($vaccines as $vaccine){
            Vaccine::create([
                'pet_id' => $pet_id,
                'vaccinedate' => $vaccine['vaccinedate'],
                'vaccine' => $vaccine['vaccine'],
                'vaccinebatch' => $vaccine['vaccinebatch'],
            ]);
        }
        return new VaccineResource($vaccine);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pet_id = $request->pet_id;
        
        $vaccines = $request->vaccines;

        if ($vaccines == null) {
            $params = $request->all();
            $vaccine = Vaccine::create([
            'pet_id' => $params['pet_id'],
            'vaccinedate' => $params['vaccinedate'],
            'vaccine' => $params['vaccine'],
            'vaccinebatch' => $params['vaccinebatch'],
            ]);
        } else {
            foreach($vaccines as $vaccine){
                Vaccine::create([
                    'pet_id' => $pet_id,
                    'vaccinedate' => $vaccine['vaccinedate'],
                    'vaccine' => $vaccine['vaccine'],
                    'vaccinebatch' => $vaccine['vaccinebatch'],
                ]);
            }
        }

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
        try {
            $vaccine->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    
        return response()->json(null, 204);
    }

    public function name($id) {
        $name = Vaccine::findOrFail($id);
        return $name;
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
        $vaccines = Vaccine::where($_REQUEST)->orderBy('vaccinedate', 'desc')->with('category')->get();

        // Return collection of vaccines as a resource
        return VaccineResource::collection($vaccines);
    }
}
