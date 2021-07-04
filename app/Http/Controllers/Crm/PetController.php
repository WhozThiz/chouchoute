<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Http\Resources\Crm\PetResource;
use App\Laravue\Models\Crm\Pet;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;
use Illuminate\Validation\Validator;

class PetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pets = Pet::with('lead')->orderBy('name')->get();
        return response()->json(new JsonResponse($pets));
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
        $pet = Pet::create([
            'name' => $params['petname'],
            'breed' => $params['breed'],
            'coat' => $params['coat'],
            'gender' => $params['gender'],
            'color' => $params['color'],
            'birthdate' => $params['birthdate'],
            'neutered' => $params['neutered'],
            'registration' => $params['registration'],
            'lead_id' => $params['lead_id'],
        ]);

        return new PetResource($pet);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        $info = Pet::where('id', $pet->id)->with('lead')->get()->first();
        return response()->json(new JsonResponse($info));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Crm\Pet  $pet
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        if ($pet === null) {
            return response()->json(['error' => 'Pet not Found'], 404);
        }

        /*
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            */
            $params = $request->all();
            $pet->name = $params['name'];
            $pet->breed = $params['breed'];
            $pet->coat = $params['coat'];
            $pet->gender = $params['gender'];
            $pet->color = $params['color'];
            $pet->birthdate = $params['birthdate'];
            $pet->neutered = $params['neutered'];
            $pet->registration = $params['registration'];
            $pet->save();
        //}

        return new PetResource($pet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Crm\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        try {
            $pet->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    
        return response()->json(null, 204);
    }

    /**
     * Count the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function countpets()
    {
        $total = Pet::count();
        return response()->json($total);
    }

}
