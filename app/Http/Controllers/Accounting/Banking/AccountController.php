<?php

namespace App\Http\Controllers\Accounting\Banking;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Accounting\Banking\Account;
use App\Http\Resources\Accounting\Banking\AccountResource;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::all();
        return response()->json(new JsonResponse($accounts));
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
     * Disable the specified resource.
     *
     * @param  Account $account
     *
     * @return Response
     */
    public function disable(Account $account)
    {
        /*
        $response = $this->ajaxDispatch(new Account::update($account, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => $account->name]);
        }

        return response()->json($response);
        */
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
        $account = Account::create([
            'name' => $params['name'],
            'number' => $params['number'],
            'currency' => $params['currency'],
            'opening_balance' => $params['opening_balance'],
            'bank_name' => $params['bank_name'],
            'bank_phone' => $params['bank_phone'],
            'bank_address' => $params['bank_address'],
            'enabled' => $params['enabled'],
        ]);

        return new AccountResource($account);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Banking\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Accounting\Banking\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Accounting\Banking\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {

        if ($account === null) {
            return response()->json(['error' => 'Account not Found'], 404);
        } else {
            $params = $request->all();
            $account->name = $params['name'];
            $account->number = $params['number'];
            $account->opening_balance = $params['opening_balance'];
            $account->bank_name = $params['bank_name'];
            $account->bank_phone = $params['bank_phone'];
            $account->bank_address = $params['bank_address'];
            $account->enabled = $params['enabled'];
            $account->save();
        }

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Accounting\Banking\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        try {
            $account->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    
        return response()->json(null, 204);
    }
}
