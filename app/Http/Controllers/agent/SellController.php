<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use App\Http\Resources\agent\SellingResource;
use App\Models\CustomerTransaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SellController extends Controller
{
    public function getSellingList(Request $request)
    {
        $agent = $request->user();
        $due_list = $agent->customerTransactions()->pending()->deposit()->where('created_at', '<', Carbon::now()->subMinutes($agent->duration))->get();
        $pending_list = $agent->customerTransactions()->pending()->deposit()->where('created_at', '>=', Carbon::now()->subMinutes($agent->duration))->get();
        return response()->json([
            'data' => [
                'due_list' => SellingResource::collection($due_list),
                'pending_list' => SellingResource::collection($pending_list),
            ]
        ]);
    }

    public function getSellingTransactionDetail(Request $request, $id)
    {
        $transaction = CustomerTransaction::where('transaction_id', $id)->first();
        if (!$transaction) {
            return response()->json([
                'data' => 'Invalid transaction!'
            ], 403);
        }

        return response()->json([
            'data' => new SellingResource($transaction)
        ]);
    }

    public function confirmTransaction(Request $request, $id)
    {
        $transaction = CustomerTransaction::deposit()->where('transaction_id', $id)->first();
        if (!$transaction) {
            return response()->json([
                'data' => 'Invalid transaction!'
            ], 403);
        }

        try {
            $customer = $transaction->customer;
            $agent = $request->user();
            $customer->balances()->create([
                'amount' => $transaction->amount,
                'agent_id' => $agent->id,
            ]);
            $agent->substractBalance($transaction->amount);
            $transaction->status = 2;
            $transaction->update();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Unit ဝယ်ခြင်းအောင်မြင်သည်!'
        ]);
    }
}
