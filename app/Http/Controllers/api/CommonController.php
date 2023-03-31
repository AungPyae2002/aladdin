<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingDayResource;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SlideResource;
use App\Models\ClosingDay;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getSlides(){
        $slides = Slide::active()->orderBy('sort')->get();
        return response()->json([
            'data' => SlideResource::collection($slides),
            'title' => Setting::where('key','home_banner_text')->pluck('value')->first()
        ]);
    }

    public function getServices()
    {
        $services = Service::active()->get();
        return response()->json([
            'data' => ServiceResource::collection($services)
        ]);
    }

    public function getClosingDays(){
        $closingDays = ClosingDay::active()->get();
        return response()->json([
            'data' => ClosingDayResource::collection($closingDays)
        ]);
    }

    public function getPaymentMethods(){
        $payments = PaymentMethod::get();
        return response()->json([
            'data' => PaymentMethodResource::collection($payments)
        ]);
    }
}
