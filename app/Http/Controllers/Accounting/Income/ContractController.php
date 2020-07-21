<?php

namespace App\Http\Controllers\Accounting\Income;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Accounting\Income\Contract;
use App\Http\Resources\Accounting\Income\ContractResource;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::with('account', 'lead', 'category')->get();
        return response()->json(new JsonResponse($contracts));
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
        $contract = Contract::create([
            'account_id' => $params['account_id'],
            'paid_at' => $params['paid_at'],
            'amount' => $params['amount'],
            'currency_code' => $params['currency_code'],
            'currency_rate' => '1',
            'lead_id' => $params['lead_id'],
            'description' => $params['description'],
            'category_id' => $params['category_id'],
            'payment_method' => $params['payment_method'],
            'reference' => $params['reference'],
            'attachment' => '',
        ]);

        return new ContractResource($contract);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Accounting\Income\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
