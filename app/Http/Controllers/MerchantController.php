<?php

namespace App\Http\Controllers;

use App\Merchant;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchants = Merchant::latest()->get();
        return view('admin.merchant.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merchant.create');
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
            'name' => 'required | min:3 | unique:merchants',
        ];

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $merchant = new Merchant();
        $merchant->name = $request->input('name');
        $merchant->account_no = $request->input('account_no');
        $merchant->contact_name = $request->input('contact_name');
        $merchant->phone = $request->input('phone');
        $merchant->email = $request->input('email');

        $merchant->save();

        Toastr::success('Merchants successfully created', 'Success');
        return redirect()->route('admin.merchant.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        return view('admin.merchant.show', compact('merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchant $merchant)
    {
        return view('admin.merchant.edit', compact('merchant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchant $merchant)
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

        $merchant->name = $request->input('name');
        $merchant->account_no = $request->input('account_no');
        $merchant->contact_name = $request->input('contact_name');
        $merchant->phone = $request->input('phone');
        $merchant->email = $request->input('email');
        $merchant->save();

        Toastr::success('Merchants successfully updated', 'Success');
        return redirect()->route('admin.merchant.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchant $merchant)
    {
        $merchant->delete();
        Toastr::success('Merchants successfully deleted', 'Success');
        return redirect()->route('admin.merchant.index');
    }
}
