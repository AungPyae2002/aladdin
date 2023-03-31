<?php

namespace App\Http\Controllers\admin\threed;

use App\Http\Controllers\Controller;
use App\Models\ThreeDSection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = ThreeDSection::orderBy('opening_date_time', 'DESC')->paginate(ThreeDSection::count() * 5)->groupBy(function ($section) {
            return Carbon::parse($section->opening_date_time)->format('F Y');
        });

        return view('admin.threed.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThreeDSection  $ThreeDSection
     * @return \Illuminate\Http\Response
     */
    public function show(ThreeDSection $ThreeDSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThreeDSection  $ThreeDSection
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreeDSection $section)
    {

        return view('admin.threed.section.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThreeDSection  $ThreeDSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreeDSection $section)
    {
        $request->validate([
            'ending_minute' => 'required|integer|min:0',
            'multiply' => 'required|integer|min:1|max:999',
            'winning_number' => 'required|between:0,99',
            'minimum_amount' => 'required|integer|min:1,',
            'maximum_amount' => 'required|integer|gt:minimum_amount',
        ]);

        $section->multiply = $request->multiply;
        $section->winning_number = $request->winning_number;
        $section->minimum_amount = $request->minimum_amount;
        $section->maximum_amount = $request->maximum_amount;
        $section->update();

        return redirect()->route('admin.threed_section.index');
    }

    public function updateNumbersInfo(Request $request, ThreeDSection $section)
    {
        $request->validate([
            'maximum_amount.*' => 'required|integer'
        ]);

        $numbers = [];
        for ($i = 0; $i <= 999; $i++) {
            $number = str_pad($i, 3, '0', STR_PAD_LEFT);
            $numbers[$number] = [
                'minimum_amount' => $section->mininum_amount,
                'maximum_amount' => $request->maximum_amount[$i]

            ];
        }

        $section->numbers_info = json_encode($numbers);
        $section->update();
        return redirect()->route('admin.threed_section.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThreeDSection  $ThreeDSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThreeDSection $section)
    {
        $section->delete();
        return redirect()->route('admin.threed_section.index');
    }
}
