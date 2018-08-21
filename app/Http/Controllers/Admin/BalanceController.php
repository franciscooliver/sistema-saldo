<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MoneyValidationFormRequest;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public  function index(){

        //dd();
        $balance = Auth::user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public  function depositStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);

        $response = $balance->deposit($request->input('recarga'));

        if($response['success']){
            return redirect()
                            ->route('admin.balance')
                            ->with('success',$response['mensagem']);
        }else{
            return redirect()
                        ->back()
                        ->with('error','success',$response['mensagem']);
        }
    }

    public function sacar()
    {
        return view('admin.balance.sacar');
    }
}
