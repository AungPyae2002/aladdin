<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TwoDBettingLogResource;
use App\Http\Resources\TwoDSectionResource;
use App\Models\Customer;
use App\Models\TwoDBettingLog;
use App\Models\TwoDSection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TwoDController extends Controller
{
    public function getSections(){
        $sections = TwoDSectionResource::collection(TwoDSection::whereDate('opening_date_time',Carbon::today())->orderBy('twod_type_id','ASC')->get())->groupBy(function($section){
            return $section->type->name;
        });

        return response()->json([
            'data' => $sections,
            'success' => true
        ]);
    }

    public function getSection(TwoDSection $section){
        return response()->json([
            'data' => new TwoDSectionResource($section),
            'success' => true
        ]);
    }

    public function bet(Request $request,TwoDSection $section){
        if($section->ended || $section->ending){
            return response()->json([
                'success' => false,
                'message' => 'This section is ended!'
            ],403);
        }

        $total_bet_amount = 0;
        foreach($request->bet_data as $data){
            $number = $data["number"];
            $amount = (int)$data["amount"];
            $total_bet_amount += $amount;
            if ($section->getMaximumAmount($number) < ($section->getTotalAmount($number) + $amount)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Limit exceeded for number (' . $number . ')'
                ], 403);
            }
        }



        if ($total_bet_amount > $section->maximum_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid amount!'
            ], 403);
        }

        if($total_bet_amount > $request->user()->balance){
            return response()->json([
                'success' => false,
                'message' => 'Insufficient Balance!'
            ], 403);
        }


        foreach ($request->bet_data as $data) {
            $number = $data["number"];
            $amount = (int)$data["amount"];
            if ($section->getMaximumAmount($number) >= ($section->getTotalAmount($number) + $amount)) {
                $bet_log = new TwoDBettingLog();
                $bet_log->customer_id = $request->user()->id;
                $bet_log->twod_section_id = $section->id;
                $bet_log->bet_number = $number;
                $bet_log->amount = $amount;
                $bet_log->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Betting Successful!'
        ]);
    }

    public function getBettingLog(Request $request,$page = 1){
        $end_date = Carbon::today();
        $start_date = Carbon::today()->subDays((10 * $page));
        $period = CarbonPeriod::create($start_date, $end_date);

        $betting_log = [];
        foreach ($period as $date) {
            $total_amount = TwoDBettingLog::whereDate('created_at', $date)->sum('amount');
            if ($total_amount > 0) {
                $betting_log[] = [
                    "date" => $date->format('Y-m-d'),
                    "total_amount" => $total_amount
                ];
            }
        }

        return response()->json([
            'data' => $betting_log,
            'success' => true,
        ]);
    }

    public function getBettingLogByDate(Request $request,$date){
        return response()->json([
            'data' => TwoDBettingLogResource::collection(TwoDBettingLog::whereDate('created_at', $date)->get()),
            'success' => true
        ]);
    }
}
