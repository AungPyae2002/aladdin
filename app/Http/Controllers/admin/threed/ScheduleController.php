<?php

namespace App\Http\Controllers\admin\threed;

use App\Http\Controllers\Controller;
use App\Models\ThreeDSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = ThreeDSchedule::latest()->paginate(10);
        return view('admin.threed.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.threed.schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'opening_date' => 'required|integer|between:1,28',
            'ending_minute' => 'required|integer|min:0',
            'opening_time' => 'required|date_format:H:i,H:i:s',
            'multiply' => 'required|integer|min:0,max;100',
            'minimum_amount' => 'nullable|integer|',
            'maximum_amount' => 'nullable|integer|gt:minimum_amount',
        ]);

        $schedule = new ThreeDSchedule();
        $schedule->opening_date = $request->opening_date;
        $schedule->opening_time = $request->opening_time;
        $schedule->multiply = $request->multiply;
        $schedule->minimum_amount = $request->minimum_amount;
        $schedule->maximum_amount = $request->maximum_amount;
        $schedule->ending_minute = $request->ending_minute;
        $schedule->is_auto = ($request->is_auto == "1");
        $schedule->save();
        return redirect()->route('admin.threed_schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThreeDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(ThreeDSchedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThreeDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreeDSchedule $schedule)
    {
        return view('admin.threed.schedule.edit', compact( 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThreeDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreeDSchedule $schedule)
    {
        $request->validate([
            'opening_date' => 'required|integer|between:1,28',
            'ending_minute' => 'required|integer|min:0',
            'opening_time' => 'required|date_format:H:i,H:i:s',
            'multiply' => 'required|integer|min:0,max;100',
            'minimum_amount' => 'nullable|integer|',
            'maximum_amount' => 'nullable|integer|gt:minimum_amount',
        ]);

        $schedule->opening_date = $request->opening_date;
        $schedule->opening_time = $request->opening_time;
        $schedule->multiply = $request->multiply;
        $schedule->minimum_amount = $request->minimum_amount;
        $schedule->maximum_amount = $request->maximum_amount;
        $schedule->ending_minute = $request->ending_minute;
        $schedule->is_auto = ($request->is_auto == "1");
        $schedule->update();
        return redirect()->route('admin.threed_schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThreeDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThreeDSchedule $schedule)
    {
        $schedule->delete();
        return back();
    }
}
