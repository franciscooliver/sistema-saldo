<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value) : Array {

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value,2,'.','');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd')
        ]);

        if($deposit && $historic)
        {

            DB::commit();
            return [
                'success' => true,
                'mensagem'=>'Sucesso ao realizar recarga'
            ];
        }else{

            DB::rollBack();
            return [
                'success' => false,
                'mensagem'=>'Falha ao tentar ralizar a recarga'
            ];
        }
    }

    //metodo de saque
    public function saque(float $value): Array
    {

        if($this->amount < $value)
        {
            return [
                'success' => false,
                'message' => "Saldo insuficiente"
            ];
        }

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value,2,'.','');
        $saque = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'O',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Ymd')
        ]);

        if($saque && $historic)
        {

            DB::commit();
            return [
                'success' => true,
                'mensagem'=>'Sucesso ao realizar retirada no valor de : '.number_format($value,2,'.','')
            ];
        }else{

            DB::rollBack();

            return [
                'success' => false,
                'mensagem'=>'Falha ao tentar ralizar a retirada'
            ];
        }
    }

    public  function transfer(float $value,User $sender): Array
    {
        if($this->amount < $value)
        {
            return [
                'success' => false,
                'message' => "Saldo insuficiente"
            ];
        }

        DB::beginTransaction();

        /****************************************************************
         *   atualiza o próprio saldo
         ***************************************************************/

        $sender_balance = $sender->balance()->firstOrCreate([]);
        $totalBeforeSender = $sender_balance->amount ? $sender_balance->amount : 0;
        $sender_balance->amount += number_format($value,2,'.','');
        $transferSender = $sender_balance->save();//salva o valor

        $historicSender = $sender->historics()->create([
            'type'                 => 'T',
            'amount'               => $value,
            'total_before'         => $totalBeforeSender,
            'total_after'          => $sender_balance->amount,
            'date'                 => date('Ymd'),
            'user_id_transaction'  => auth()->user()->id
        ]);

        /****************************************************************
         *   atualiza o saldo do recebedor
         ***************************************************************/

        $totalBefore = $this->amount ? $this->amount : 0;//saldo anterior
        $this->amount -= number_format($value,2,'.','');//retira o valor da tranferencia do meu saldo atual
        $transfer = $this->save();//salva o valor

        $historic = auth()->user()->historics()->create([
            'type'                 => 'T',
            'amount'               => $value,
            'total_before'         => $totalBefore,
            'total_after'          => $this->amount,
            'date'                 => date('Ymd'),
            'user_id_transaction'  => $sender->id
        ]);


        if($transfer && $historic && $transferSender && $historicSender)
        {

            DB::commit();
            return [
                'success' => true,
                'mensagem'=>'OK!!! valor de '.number_format($value,2,',','').' transferido com sucesso para: 
                '.$sender->name
            ];
        }

        DB::rollBack();
        return [
            'success' => false,
            'mensagem'=>'Falha na transferência'
        ];

    }
}
