<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Traits\FileUpload;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = PaymentMethod::active()->paginate(10);
        return view('admin.setting.payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.payment.create');
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
            'name' => 'required|unique:payment_methods,name',
            'image' => 'required|image|mimes:jpg,png,jpeg,svg',
        ]);

        $payment = new PaymentMethod();
        $payment->name = $request->name;
        if($request->hasFile('image')){
            $payment->image = $this->uploadFile($request->image,'payments');
        }
        $payment->save();

        return redirect()->route('admin.payment_method.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $payment)
    {
        return view('admin.setting.payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $payment)
    {
        $request->validate([
            'name' => 'required|unique:payment_methods,name,'.$payment->id,
            'image' => 'nullable|image|mimes:jpg,png,jpeg,svg',
        ]);

        $payment->name = $request->name;
        if ($request->hasFile('image')) {
            $payment->image = $this->updateFile($request->image, 'payments',$payment->image);
        }
        $payment->update();
        return redirect()->route('admin.payment_method.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();
        return back();
    }
}
