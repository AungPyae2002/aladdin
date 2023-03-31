<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\AgentTransaction;
use App\Models\CustomerTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    public function getAgents($amount = null){
        $agents = Agent::where(function($query) use($amount){
            $query->where('current_mode', 2)->where('current_mode_approved', 1);
            if($amount){
                $query->where('maximum_amount','>=',$amount);
            };
        })->get();
        return response()->json([
            'data' => AgentResource::collection($agents)
        ]);
    }

    public function getAgentInfo($agent)
    {
        $agents = Agent::where(function ($query) {
            $query->where('current_mode', 2)->where('current_mode_approved', 1);
        })->where('id', $agent)->first();
        return response()->json([
            'data' => new AgentResource($agents)
        ]);
    }

    public function submit(Request $request, $agent)
    {
        $request->validate([
            'payment_method' => 'required',
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required'
        ]);

        $customer = $request->user();
        $agent = Agent::where(function ($query) {
            $query->where('current_mode', 2)->where('current_mode_approved', 1);
        })->where('id', $agent)->first();

        if (!$agent) {
            return response()->json([
                'message' => 'Invalid agent!'
            ], 403);
        }

        $transaction = new CustomerTransaction();
        $transaction->transaction_id = Str::uuid();
        $transaction->customer_id = $customer->id;
        $transaction->type = CustomerTransaction::IN;
        $transaction->status = 1;
        $transaction->amount = $request->amount;
        $transaction->payment_transaction_id = $request->transaction_id;
        $transaction->payment_id = $request->payment_method;
        $transaction->save();
        $agent->customerTransactions()->save($transaction);

        return response()->json([
            'success' => true,
            'message' => 'Preparing to transfer!'
        ]);
    }
}
