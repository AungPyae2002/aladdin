<?php

namespace App\Http\Controllers\admin\twod;

use App\Http\Controllers\Controller;
use App\Models\TwoDSchedule;
use App\Models\TwoDType;
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
        $schedules = TwoDSchedule::latest()->paginate(10);
        return view('admin.twod.schedule.index',compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = TwoDType::all();
        return view('admin.twod.schedule.create',compact('types'));
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
            'twod_type' => 'required|exists:twod_types,id',
            'opening_time' => 'required|date_format:H:i,H:i:s',
            'multiply' => 'required|integer|min:0,max;100',
            'minimum_amount' => 'nullable|integer|',
            'maximum_amount' => 'nullable|integer|gt:minimum_amount',
        ]);

        $schedule = new TwoDSchedule();
        $schedule->twod_type_id = $request->twod_type;
        $schedule->opening_time = $request->opening_time;
        $schedule->multiply = $request->multiply;
        $schedule->minimum_amount = $request->minimum_amount;
        $schedule->maximum_amount = $request->maximum_amount;
        $schedule->is_auto = ($request->is_auto == "1");
        $schedule->save();
        return redirect()->route('admin.twod_schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TwoDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(TwoDSchedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TwoDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(TwoDSchedule $schedule)
    {
        $types = TwoDType::all();
        return view('admin.twod.schedule.edit', compact('types','schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TwoDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TwoDSchedule $schedule)
    {
        $request->validate([
            'twod_type' => 'required|exists:twod_types,id',
            'opening_time' => 'required|date_format:H:i:s,H:i',
            'multiply' => 'required|integer|min:0,max;100',
            'minimum_amount' => 'nullable|integer|',
            'maximum_amount' => 'nullable|integer|gt:minimum_amount',
        ]);

        $schedule->twod_type_id = $request->twod_type;
        $schedule->opening_time = $request->opening_time;
        $schedule->multiply = $request->multiply;
        $schedule->minimum_amount = $request->minimum_amount;
        $schedule->maximum_amount = $request->maximum_amount;
        $schedule->is_auto = ($request->is_auto == "1");
        $schedule->update();
        return redirect()->route('admin.twod_schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TwoDSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TwoDSchedule $schedule)
    {
        $schedule->delete();
        return back();
    }
}
