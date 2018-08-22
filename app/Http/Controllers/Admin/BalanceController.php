<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MoneyValidationFormRequest;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

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

        $response = $balance->deposit($request->input('value'));

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

    public function saqueStore(MoneyValidationFormRequest $request)
    {

        $balance = auth()->user()->balance()->firstOrCreate([]);

        $response = $balance->saque($request->value);

        if($response['success']){
            return redirect()
                ->route('admin.balance')
                ->with('success',$response['mensagem']);
        }else{
            return redirect()
                ->back()
                ->with('error',"Saldo insuficiente");
        }
    }

    public function transfer(){
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        $user_recuperado = $user->getSender($request->input("sender"));
        if(!$user_recuperado)
            return redirect()
                    ->back()
                    ->with("error","Usuário informado não encontrado");

        if($user_recuperado->id === \auth()->id())
            return redirect()
                    ->back()
                    ->with("error","Erro!!! Usuário informado não pode ser o mesmo logado");

        $balance = \auth()->user()->balance;

        return view('admin.balance.transfer-confirm', compact('user_recuperado','balance'));
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {
       //echo json_encode($request->all());

        if(!$sender = $user->find($request->sender_id))
            return redirect()
                ->route('balance.transfer')
                ->with('success',"Destinatário não encontrado");

            $balance = auth()->user()->balance()->firstOrCreate([]);

        $response = $balance->transfer($request->input('value'), $sender);

        if($response['success']){
            return redirect()
                ->route('admin.balance')
                ->with('success',$response['mensagem']);
        }else{
            return redirect()
                ->back()
                ->with('error',"Saldo insuficiente");
        }
    }
}
