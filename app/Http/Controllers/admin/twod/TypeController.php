<?php

namespace App\Http\Controllers\admin\twod;

use App\Http\Controllers\Controller;
use App\Models\TwoDType;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = TwoDType::latest()->paginate(10);
        return view('admin.twod.type.index',compact('types'));
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
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $type = new TwoDType();
        $type->name = $request->name;
        $type->has_set_value = ($request->has_set_value == "1");
        $type->save();

        return redirect()->route('admin.twod_type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TwoDType  $twoDType
     * @return \Illuminate\Http\Response
     */
    public function show(TwoDType $twoDType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TwoDType  $twoDType
     * @return \Illuminate\Http\Response
     */
    public function edit(TwoDType $twoDType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TwoDType  $twoDType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TwoDType $twoDType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TwoDType  $twoDType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TwoDType $twoDType)
    {
        //
    }
}
