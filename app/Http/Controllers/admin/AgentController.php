<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Agent::orderBy('id','DESC')->paginate(10);
        return view('admin.agent.index',compact('agents'));
        
    }

    public function showPendings(){
        $agents = Agent::pending()->paginate(10);
        return view('admin.agent.pendings',compact('agents'));
    }

    public function showBuyingPendings()
    {
        $agents = Agent::buyingPending()->paginate(10);
        return view('admin.agent.pending.buy', compact('agents'));
    }

    public function showSellingPendings()
    {
        $agents = Agent::sellingPending()->paginate(10);
        return view('admin.agent.pending.sell', compact('agents'));
    }


    public function showPending(Agent $agent)
    {
        return view('admin.agent.pending', compact('agent'));
    }

    public function approve(Agent $agent){
        if(!$agent->approved){

            $agent->approved_at = Carbon::now();
            $agent->approved = 1;
            $password = Str::random(8);
            $agent->display_password = $password;
            $agent->password = Hash::make($password);
        }elseif($agent->current_mode_approved == 0){
            $agent->current_mode_approved = 1;
        }

        $agent->update();


        return redirect()->route('admin.agent.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agent.create');
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
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:agents|string|max:255',
            'password' => 'required|string|min:8|max:255',
            'commision_percent' => 'required|between:1,100'
        ]);

        $agent = new Agent;
        $agent->name = $request->name;
        $agent->phone = $request->phone;
        $agent->password = Hash::make($request->password);
        $agent->commision_percent = $request->commision_percent;
        $agent->save();


        return redirect()->route('admin.agent.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agent $agent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
