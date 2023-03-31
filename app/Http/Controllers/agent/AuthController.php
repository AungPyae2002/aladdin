<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Traits\FileUpload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use FileUpload;
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:agents,phone|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'nrc_front' => 'nullable|image|mimes:jpg,png,jpeg',
            'nrc_back' => 'nullable|image|mimes:jpg,png,jpeg',
            'contact' => 'required|string|max:255',
        ]);

        try{
            $agent = new Agent();
            $agent->name = $request->name;
            $agent->phone = $request->phone;
            $agent->contact = $request->contact;
            $agent->has_level2_account = $request->has_level_2 == true;
            if($request->hasFile('image')){
                $agent->image = $this->uploadFile($request->image,'agents');
            }

            if($request->hasFile('nrc_front')){
                $agent->nrc_front = $this->uploadFile($request->nrc_front,'kyc');
            }

            if ($request->hasFile('nrc_back')) {
                $agent->nrc_back = $this->uploadFile($request->nrc_back, 'kyc');
            }
            $agent->save();
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ],403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration submitted successfully!'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = Agent::where('phone', $request->phone)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        $agent = new AgentResource($user);
        return response()->json([
            'data' => $agent,
            'token' => $user->createToken('auth')->plainTextToken,
            'success' => true
        ]);
    }
    
}
