<?php

namespace App\Http\Controllers\admin\twod;

use App\Http\Controllers\Controller;
use App\Models\TwoDSchedule;
use App\Models\TwoDSection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = TwoDSection::orderBy('opening_date_time','DESC')->paginate(TwoDSchedule::count() * 5)->groupBy(function($section){
            return Carbon::parse($section->opening_date_time)->format('Y-m-d');
        });

        return view('admin.twod.section.index',compact('sections'));

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
     * @param  \App\Models\TwoDSection  $twoDSection
     * @return \Illuminate\Http\Response
     */
    public function show(TwoDSection $twoDSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TwoDSection  $twoDSection
     * @return \Illuminate\Http\Response
     */
    public function edit(TwoDSection $section)
    {
        return view('admin.twod.section.edit',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TwoDSection  $twoDSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TwoDSection $section)
    {
        $request->validate([
            'multiply' => 'required|integer|min:1|max:99',
            'winning_number' => 'required|between:0,99',
            'minimum_amount' => 'required|integer|min:1,',
            'maximum_amount' => 'required|integer|gt:minimum_amount',
        ]);
        
        if($section->type->has_set_value ?? true){
            $request->validate([
                'set' => 'required|numeric',
                'value' => 'required|numeric',
            ]);
        }

        $section->multiply = $request->multiply;
        $section->set = $request->set;
        $section->value = $request->value;
        $section->winning_number = $request->winning_number;
        $section->minimum_amount = $request->minimum_amount;
        $section->maximum_amount = $request->maximum_amount;
        $section->update();

        return redirect()->route('admin.twod_section.index');
    }

    public function updateNumbersInfo(Request $request, TwoDSection $section){
        $request->validate([
            'maximum_amount.*' => 'required|integer'
        ]);

        $numbers = [];
        for ($i = 0; $i <= 99; $i++) {
            $number = str_pad($i, 2, '0', STR_PAD_LEFT);
            $numbers[$number] = [
                'minimum_amount' => $section->mininum_amount,
                'maximum_amount' => $request->maximum_amount[$i]
            ];
        }

        $section->numbers_info = json_encode($numbers);
        $section->update();
        return redirect()->route('admin.twod_section.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TwoDSection  $twoDSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(TwoDSection $section)
    {
        $section->delete();
        return redirect()->route('admin.twod_section.index');
    }
}
