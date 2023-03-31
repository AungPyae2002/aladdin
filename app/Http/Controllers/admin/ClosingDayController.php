<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClosingDay;
use Illuminate\Http\Request;

class ClosingDayController extends Controller
{
    public function index()
    {
        $closingDays = ClosingDay::paginate(10);
        return view('admin.closing.index', compact('closingDays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.closing.create');
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
            'date' => 'required|date|date_format:Y-m-d',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $closingDay = new ClosingDay;
        $closingDay->date = $request->date;
        $closingDay->title = $request->title;
        $closingDay->description = $request->description;
        $closingDay->save();
        return redirect()->route('admin.closing-day.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClosingDay  $closingDay
     * @return \Illuminate\Http\Response
     */
    public function show(ClosingDay $closingDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClosingDay  $closingDay
     * @return \Illuminate\Http\Response
     */
    public function edit(ClosingDay $closingDay)
    {
        return view('admin.closing.edit', compact('closingDay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClosingDay  $closingDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClosingDay $closingDay)
    {
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $closingDay->date = $request->date;
        $closingDay->title = $request->title;
        $closingDay->description = $request->description;
        $closingDay->update();
        return redirect()->route('admin.closing-day.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClosingDay  $closingDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClosingDay $closingDay)
    {
        $closingDay->delete();
        return redirect()->route('admin.closing-day.index');
    }
}
