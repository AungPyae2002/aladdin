<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Ui\Presets\React;

class ApplyController extends Controller
{
    public function applyBuying(Request $request){
        $agent = $request->user();
        $request->validate([
            'minimum_amount' => 'required|numeric',
            'maximum_amount' => 'required|numeric',
            'duration' => 'required|integer|in:5,10,15',
            'payment_method' => 'required',
        ]);

        $paymentMethods = [];
        foreach ($request->payment_method as $payment) {
            if(PaymentMethod::where('id',$payment['id'])->first()){
                $paymentMethods[$payment['id']] = [
                    'receiver_account_name' => $payment['receiver_account_name'],
                    'receiver_account_phone' => $payment['receiver_account_phone'],
                ];
                continue;
            }

            throw ValidationException::withMessages([
                'payment_method' => ['Invalid payment method!'],
            ]);
        }


        $agent->current_mode = Agent::BUYING_MODE;
        $agent->current_mode_approved = 0;
        $agent->minimum_amount = $request->minimum_amount;
        $agent->maximum_amount = $request->maximum_amount;
        $agent->duration = $request->duration;
        $agent->update();
        $agent->paymentMethods()->sync($paymentMethods);

        return response()->json([
            'success' => true,
            'message' => 'Submission Successful!'
        ]);
    }

    public function applySelling(Request $request)
    {
        $agent = $request->user();
        $request->validate([
            'minimum_amount' => 'required|numeric',
            'maximum_amount' => 'required|numeric',
            'duration' => 'required|integer|in:5,10,15',
            'payment_method' => 'required',
        ]);

        $paymentMethods = [];
        foreach ($request->payment_method as $payment) {
            if (PaymentMethod::where('id', $payment['id'])->first()) {
                $paymentMethods[$payment['id']] = [
                    'receiver_account_name' => $payment['receiver_account_name'],
                    'receiver_account_phone' => $payment['receiver_account_phone'],
                ];
                continue;
            }

            throw ValidationException::withMessages([
                'payment_method' => ['Invalid payment method!'],
            ]);
        }


        $agent->current_mode = Agent::SELLING_MODE;
        $agent->current_mode_approved = 0;
        $agent->minimum_amount = $request->minimum_amount;
        $agent->maximum_amount = $request->maximum_amount;
        $agent->duration = $request->duration;
        $agent->update();
        $agent->paymentMethods()->sync($paymentMethods);

        return response()->json([
            'success' => true,
            'message' => 'Submission Successful!'
        ]);
    }
}
