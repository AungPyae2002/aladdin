<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getAllNotifications(Request $request){
        $notifications = NotificationResource::collection($request->user()->notifications)->groupBy(function($notification){
            return $notification->created_at->format('m-d-Y');
        });
        return response()->json([
            'data' => $notifications
        ]);
    }
}
