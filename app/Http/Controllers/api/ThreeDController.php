<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThreeDBettingLogResource;
use App\Http\Resources\ThreeDSectionResource;
use App\Models\ThreeDBettingLog;
use App\Models\ThreeDSection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThreeDController extends Controller
{
    public function checkSection(){
        $section = ThreeDSection::whereDate('opening_date_time', '>=', Carbon::today())->orderBy('opening_date_time')->first();
        if (!$section) {
            return response()->json([
                'data' => null
            ]);
        }

        if (Carbon::parse($section->opening_date_time)->isSameDay(Carbon::today()) && !Carbon::parse($section->opening_date_time)->subMinutes($section->ending_minute)->gt(Carbon::now())) {
            return response()->json([
                'data' => null
            ]);
        } else {
            return response()->json([
                'data' => $section->id
            ]);
        }
    }

    public function getHistory(){
        $sections = ThreeDSection::where('opening_date_time', '<', Carbon::now())->limit(10)->get();
        return response()->json([
            'data' => ThreeDSectionResource::collection($sections)
        ]);
    }

    public function getSection(ThreeDSection $section){
        return response()->json([
            'data' => new ThreeDSectionResource($section)
        ]);
    }

    public function bet(Request $request, ThreeDSection $section)
    {
        if ($section->ended || $section->ending) {
            return response()->json([
                'success' => false,
                'message' => 'This section is ended!'
            ], 403);
        }

        $total_bet_amount = 0;
        foreach ($request->bet_data as $data) {
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

        if ($total_bet_amount > $request->user()->balance) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient Balance!'
            ], 403);
        }


        foreach ($request->bet_data as $data) {
            $number = $data["number"];
            $amount = (int)$data["amount"];
            if ($section->getMaximumAmount($number) >= ($section->getTotalAmount($number) + $amount)) {
                $bet_log = new ThreeDBettingLog();
                $bet_log->customer_id = $request->user()->id;
                $bet_log->threed_section_id = $section->id;
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

    public function getBettingLog(Request $request, $page = 1)
    {
        $end_date = Carbon::today();
        $start_date = Carbon::today()->subDays((10 * $page));
        $period = CarbonPeriod::create($start_date,$end_date);

        $betting_log = [];
        foreach($period as $date){
            $total_amount = ThreeDBettingLog::whereDate('created_at',$date)->sum('amount');
            if($total_amount > 0){
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

    public function getBettingLogByDate(Request $request, $date)
    {
        return response()->json([
            'data' => ThreeDBettingLogResource::collection(ThreeDBettingLog::whereDate('created_at', $date)->get()),
            'success' => true
        ]);
    }

}
