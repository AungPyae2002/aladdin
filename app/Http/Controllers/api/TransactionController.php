<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getAllTransactions(Request $request){
        $transactions = TransactionResource::collection($request->user()->transactions()->simplePaginate(20)->items())->groupBy(function ($transaction) {
            return $transaction->created_at->format('F-Y');
        });
        return response()->json([
            'data' => $transactions
        ]);
    }
}
