<?php

namespace App\Http\Controllers;

use App\PaymentType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymenttypes = PaymentType::latest()->get();
        return view('admin.paymenttype.index', compact('paymenttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.paymenttype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3 | unique:payment_types',
        ];

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paymenttype = new PaymentType();
        $paymenttype->name = $request->input('name');

        $paymenttype->save();

        Toastr::success('Payment Type successfully created', 'Success');
        return redirect()->route('admin.paymenttype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentType $paymenttype)
    {
        return view('admin.paymenttype.show', compact('paymenttype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymenttype)
    {
        return view('admin.paymenttype.edit', compact('paymenttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymenttype)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3',
        ];

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paymenttype->name = $request->input('name');

        $paymenttype->save();

        Toastr::success('Payment Type successfully updated', 'Success');
        return redirect()->route('admin.paymenttype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymenttype)
    {
        $paymenttype->delete();
        Toastr::success('Payment Type successfully deleted', 'Success');
        return redirect()->route('admin.paymenttype.index');
    }
}
