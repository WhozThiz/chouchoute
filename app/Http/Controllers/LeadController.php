<?php

namespace App\Http\Controllers;

use App\Http\Resources\Crm\LeadResource;
use App\Laravue\Models\Crm\Lead;
use App\Http\Requests\Crm\LeadRequest;
use Illuminate\Http\Request;
use Validator;

class LeadController extends Controller
{

    /**
     * Display a listing of the user resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function index()
    {

        return LeadResource::collection(Lead::all());
        /**
        $leads = Lead::where('status', 'Lead')->orderBy('name', 'asc')->paginate(20);
		$total = Lead::where('status', 'Lead')->count();

		$data = [];

		foreach ($leads as $item) {
			$row = [
                'id' => $item->id,
                'name' => $item->name,
                'address' => $item->address,
                'neighborhood' => $item->neighborhood,
                'city' => $item->city,
                'state' => $item->content,
                'zipcode' => $item->zipcode,
                'homephone' => $item->homephone,
                'mobile' => $item->mobile,
                'email' => $item->email,
                'registration_id' => $item->registration_id,
                'tax_id' => $item->tax_id,
                'status' => $item->status,
            ];

            $data[] = $row;
		}

        return response()->json(new JsonResponse(['items' => $data, 'total' => $total]));
        */

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
    public function store(LeadRequest $request)
    {

        $validator = $request->validated();
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $lead = Lead::create([
                'name' => $params['name'],
                'address' => $params['logradouro'], 
                'neighborhood' => $params['bairro'],
                'city' => $params['localidade'],
                'state' => $params['uf'],
                'zipcode' => $params['cep'],
                'homephone' => $params['homephone'],
                'mobile' => $params['mobile'],
                'email' => $params['email'],
                'tax_id' => $params['tax_id'],
                'registration_id' => $params['registration_id'],
            ]);
            
            return new LeadResource($lead);
        }
        /**
        $lead = $request->isMethod('put') ? Lead::findOrFail($request->lead_id) : new Lead;
        $lead->id = $request->input('lead_id');
        $lead->name = $request->input('name');
		$lead->address = $request->input('address');
		$lead->neighborhood = $request->input('neighborhood');
		$lead->city = $request->input('city');
		$lead->state = $request->input('state');
		$lead->zip = $request->input('zip');
		$lead->homephone = $request->input('homephone');
		$lead->mobile = $request->input('mobile');
		$lead->email = $request->input('email');
		$lead->registration_id = $request->input('registration_id');
        $lead->tax_id = $request->input('tax_id');

        if($lead->save()) {
            return new LeadResource($lead);
        }
        */

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Human  $human
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        /**
        // Get lead
        $lead = Lead::findOrFail($id);

        // Return single lead as a resource
        return new LeadResource($lead);
        */

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
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
    public function update(Request $request, Lead $lead)
    {
        if ($lead === null) {
            return response()->json(['error' => 'Lead not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $lead->name = $params['name'];
            $lead->address = $params['address'];
            $lead->neighborhood = $params['neighborhood'];
            $lead->city = $params['city'];
            $lead->state = $params['state'];
            $lead->zipcode = $params['zipcode'];
            $lead->homephone = $params['homephone'];
            $lead->mobile = $params['mobile'];
            $lead->email = $params['email'];
            $lead->tax_id = $params['tax_id'];
            $lead->registration_id = $params['registration_id'];
            $lead->save();
        }

        return new LeadResource($lead);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Crm\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {

        try {
            $lead->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    
        return response()->json(null, 204);
        /**
		// Get lead
        $lead = Lead::findOrFail($id);

        if($lead->delete()) {
            return new LeadResource($lead);
        }
        */

    }
}
