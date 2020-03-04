<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Crm\LeadResource;
use App\Laravue\Models\Crm\Lead;
use App\Laravue\Models\Crm\Contact;
use App\Laravue\JsonResponse;

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

    	$leads = Contact::where('status', 'Lead')->orderBy('name', 'asc')->paginate(20);
		$total = Contact::where('status', 'Lead')->count();

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
                'registration' => $item->registration,
                'ssn' => $item->ssn,
                'status' => $item->status,
            ];

            $data[] = $row;
		}

        return response()->json(new JsonResponse(['items' => $data, 'total' => $total]));

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
		$lead->registration = $request->input('registration');
        $lead->ssn = $request->input('ssn');

        if($lead->save()) {
            return new LeadResource($lead);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Human  $human
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

		// Get lead
        $lead = Lead::findOrFail($id);

        // Return single lead as a resource
        return new LeadResource($lead);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Crm\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {

		// Get lead
        $lead = Lead::findOrFail($id);

        if($lead->delete()) {
            return new LeadResource($lead);
        }

    }
}
