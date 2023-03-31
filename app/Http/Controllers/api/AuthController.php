<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Traits\FileUpload;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Ui\Presets\React;

class AuthController extends Controller
{

    use FileUpload;

    public function getUserInfo(Request $request){
        return response()->json([
            'data' => $request->user(),
            'success' => true
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = Customer::where('phone', $request->phone)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        // $customer = new CustomerResource($user);
        $user['token']= $user->createToken('auth')->plainTextToken;

        return response()->json([
            'data' => $user,
            // 'token' => $user->createToken('auth')->plainTextToken,
            'success' => true
        ]);
    }

    public function register(Request $request){
        $request->validate([
            'phone' => 'required|string|max:255|unique:customers,phone',
            'name'  => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
            'image' => 'nullable|image|mimies:jpg,png,jpeg,svg'
        ]);

        $customer = new Customer();
        $customer->phone = $request->phone;
        $customer->name = $request->name;
        $customer->password = Hash::make($request->password);
        if($request->hasFile('image')){
            $customer->image = $this->uploadFile($request->image,'customers');
        }
        $customer->save();
        // $customer = new CustomerResource($customer);
        $customer['token'] = $customer->createToken('auth')->plainTextToken;
        return response()->json([
            'data' => $customer,
            'success' => true
        ]);
    }

    public function updateProfile(Request $request){
        $request->validate([
            'phone' => 'required|string|max:255|',
            'name' => 'required|string|max:255|',
        ]);

        $user = $request->user();
        $user->phone = $request->phone;
        $user->name = $request->name;
        if($request->hasFile('image')){
            $user->image = $this->updateFile($request->image,'customers',$user->iamge);
        }
        $user->update();
        return response()->json([
            'message' => 'Success',
            'success' => true
        ]);

    }
}
