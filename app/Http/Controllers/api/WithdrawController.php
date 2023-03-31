<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\CustomerTransaction;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    public function getAgents($amount = null)
    {
        $agents = Agent::where(function ($query) use ($amount) {
            $query->where('current_mode', 1)->where('current_mode_approved', 1);
            if ($amount) {
                $query->where('maximum_amount', '>=', $amount);
            };
        })->get();
        return response()->json([
            'data' => AgentResource::collection($agents)
        ]);
    }

    public function getAgentInfo($agent)
    {
        $agents = Agent::where(function ($query) {
            $query->where('current_mode', 1)->where('current_mode_approved', 1);
        })->where('id',$agent)->first();
        return response()->json([
            'data' => new AgentResource($agents)
        ]);
    }

    public function submit(Request $request,$agent){
        $request->validate([
            'receiver_account_name' => 'required|string|max:255',
            'receiver_account_phone' => 'required|string|max:255',
            'amount' => 'required'
        ]);

        $customer = $request->user();
        $agent = Agent::where(function ($query) {
            $query->where('current_mode', 1)->where('current_mode_approved', 1);
        })->where('id', $agent)->first();

        if(!$agent){
            return response()->json([
                'message' => 'Invalid agent!'
            ],403);
        }

        $transaction = new CustomerTransaction();
        $transaction->transaction_id = Str::uuid();
        $transaction->customer_id = $customer->id;
        $transaction->type = CustomerTransaction::OUT;
        $transaction->status = 1;
        $transaction->amount = $request->amount;
        $transaction->receiver_account_name = $request->receiver_account_name;
        $transaction->receiver_account_phone = $request->receiver_account_phone;
        $transaction->payment_id = $request->payment_method;
        $transaction->type = '-';
        $transaction->save();
        $agent->customerTransactions()->save($transaction);

        return response()->json([
            'message' => 'Preparing to transfer!'
        ]);
    }
}
