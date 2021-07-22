<?php

namespace App\Http\Controllers\Accounting\Income;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Accounting\Income\Contract;
use App\Http\Resources\Accounting\Income\ContractResource;
use App\Laravue\Models\Accounting\Banking\Transaction;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;
use Carbon\Carbon;

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
        $contractperiod = $params['contractperiod'];

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
            'start_date' => $contractperiod['0'],
            'end_date' => $contractperiod['1'],
            'attachment' => '',
        ]);

        if ($params['recurrence'] === 'Daily') {
            $addRecurrence = 'addDays';
        } else if ($params['recurrence'] === 'Weekly') {
            $addRecurrence = 'addWeeks';
        } else if ($params['recurrence'] === 'Monthly') {
            $addRecurrence = 'addMonths';
        } else if ($params['recurrence'] === 'Yearly') {
            $addRecurrence = 'addYears';
        } else if ($params['recurrence'] === 'Custom') {
            if ($params['recurrence'] === 'Date') {
                $addRecurrence = 'addWeekdays';
            } else if ($params['recurrence'] === 'Weekday') {
                $addRecurrence = 'addWeeks';
            } else if ($params['recurrence'] === 'Week') {
                $addRecurrence = 'addMonths';
            } else if ($params['recurrence'] === 'Month') {
                $addRecurrence = 'addYears';
            }
        }

        if ($params['recurrence'] === 'Never') {
            Transaction::create([
                'account_id' => $params['account_id'],
                'type' => 'credit',
                'paid_at' => $params['paid_at'],
                'amount' => $params['amount'],
                'currency_code' => $params['currency_code'],
                'currency_rate' => '1',
                'lead_id' => $params['lead_id'],
                'description' => $params['description'],
                'category_id' => $params['category_id'],
                'payment_method' => $params['payment_method'],
                'reference' => $params['reference'],
                'parent_id' => $contract->id,
            ]);
        } else if ($params['recurrence'] !== 'Custom') {
            $installment = $params['amount']/$params['times'];
            $i = '0';
            for ($i; $i < $params['times']; $i++) {
                Transaction::create([
                    'account_id' => $params['account_id'],
                    'type' => 'credit',
                    'paid_at' => Carbon::parse($params['paid_at'])->$addRecurrence($i),
                    'amount' => $installment,
                    'currency_code' => $params['currency_code'],
                    'currency_rate' => '1',
                    'lead_id' => $params['lead_id'],
                    'description' => $params['description'],
                    'category_id' => $params['category_id'],
                    'payment_method' => $params['payment_method'],
                    'reference' => $params['reference'],
                    'parent_id' => $contract->id,
                ]);
            }
        }

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

    /**
     * Count the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Income\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function countcontracts()
    {
        $total = Contract::count();
        return response()->json($total);
    }
}
