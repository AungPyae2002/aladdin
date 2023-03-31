<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Slide;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SlideController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = Slide::sort()->paginate(10);
        $home_banner_text = Setting::where('key','home_banner_text')->pluck('value')->first();
        return view('admin.slide.index', compact('slides', 'home_banner_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $image = null;
        if($request->hasFile('image')){
            $image = $this->uploadFile($request->image,'slide');
        }

        Slide::create([
            'name' => $request->name,
            'image' => $image,
            'name' => $request->name,
            'sort' => $request->sort ?? 0,
        ]);

        Session::flash('success', 'Slide created successfully!');
        return redirect()->route('admin.slide.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.slide.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $request->validate($this->rules());

        
        $slide->update([
            'name' => $request->name,
            'sort' => $request->sort ?? 0,
        ]);

        if ($request->hasFile('image')) {
            $image = $this->updateFile($request->image, 'slide',$slide->image);
            $slide->update([
                'image' => $image
            ]);
        }

        Session::flash('success', 'Slide updated successfully!');
        return redirect()->route('admin.slide.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();
        Session::flash('success', 'Slide deleted successfully!');
        return redirect()->route('admin.slide.index');
    }

    public function updateHomeBannerText(Request $request){
        Setting::where('key', 'home_banner_text')->update([
            'value' => $request->home_banner_text,
        ]);
        return back();
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'name' => 'nullable|string|max:255'
        ];
    }
}
