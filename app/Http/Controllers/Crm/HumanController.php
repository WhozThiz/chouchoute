<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Laravue\Models\Crm\Human;
use App\Http\Resources\Crm\HumanResource;
	

class HumanController extends Controller
{
	
    /**
     * Display a listing of the user resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function index()
    {
		
    	// Get humans
        $humans = Human::paginate(15);
		
        // Return collection of humans as a resource
        return HumanResource::collection($humans);
		
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
		
		$humans = Human::create($request->all());
		return $this->index();
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Human  $human
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
		// Get human
        $human = Human::findOrFail($id);
		
        // Return single human as a resource
        return new HumanResource($human);
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Human  $human
     * @return \Illuminate\Http\Response
     */
    public function edit(Human $human)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Crm\Human  $human
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Human $human)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Crm\Human  $human
     * @return \Illuminate\Http\Response
     */
    public function destroy(Human $human)
    {
        
		// Get article
        $human = Human::findOrFail($id);
		
        if($human->delete()) {
            return new HumanResource($human);
        } 
		
    }
}
