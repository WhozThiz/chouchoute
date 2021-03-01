<?php

namespace App\Http\Controllers\Accounting\Income;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Accounting\Income\Revenue;
use App\Http\Resources\Accounting\Income\RevenueResource;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $revenues = Revenue::all();
        return response()->json(new JsonResponse($revenues));
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
        $revenue = Revenue::create([
            'account_id' => $params['account_id'],
            'paid_at' => $params['paid_at'],
            'amount' => $params['amount'],
            'currency_code' => $params['currency_code'],
            'currency_rate' => $params['bank_name'],
            'lead_id' => $params['lead_id'],
            'description' => $params['description'],
            'category_id' => $params['category_id'],
            'payment_method' => $params['payment_method'],
            'reference' => $params['reference'],
            'attachment' => $params['attachment'],
        ]);

        return new RevenueResource($revenue);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Accounting\Income\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Revenue $revenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Revenue $revenue)
    {
        //
    }
}
