<?php

namespace App\Http\Controllers;

use App\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }
    public function indexReceivables()
    {
        $customers = Customer::where('balance','>','0')->get();
        return view('admin.customer.index_ar', compact('customers'));
    }

    public function getDatatable()
    {

      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      // $delURL = url('/') . '/admin/customer/destroy/';
      // $ediURL = url('/') . '/admin/customer/';
      // if( purchase_headers.finalized = 1, concat($delURL,purchase_headers.id) ,"")
      $customers = Customer::latest()->get();


        return Datatables::of($customers)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               'showUrl'    => route('admin.customer.show', [ $record->id] ),
               // 'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
               'deleteUrl' => route('admin.customer.destroy', [ $record->id]),
               'editUrl' => route('admin.customer.edit', [ $record->id])
           ]);
         })->make(true);





    }

    public function getDropdownSelect()
    {
      $search = $_GET['q'];
      $customers =   DB::table('customers' )
          ->select('name','email','shop_name','id','phone','city','balance')
          ->where('name', 'LIKE', '%'.$search.'%')
          ->get();
          return json_encode($customers);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
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
            'name' => 'required | min:3',
            'email' => 'required| email | unique:customers',
            'phone' => 'required | unique:customers',
            'address' => 'required',
            'city' => 'required',
            'photo' =>  'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('photo');
        $slug =  Str::slug($request->input('name'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('customer_upload')->exists('customer'))
            {
                Storage::disk('customer_upload')->makeDirectory('customer');
            }
            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('customer_upload')->put($imageName, $postImage);
        } else
        {
            $imageName = 'default.png';
        }

        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');
        $customer->city = $request->input('city');
        $customer->shop_name = $request->input('shop_name');
        // $customer->account_holder = $request->input('account_holder');
        // $customer->account_number = $request->input('account_number');
        // $customer->bank_name = $request->input('bank_name');
        // $customer->bank_branch = $request->input('bank_branch');
        $customer->photo = $imageName;
        $customer->save();

        Toastr::success('Customer Successfully Created', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3',
            'email' => 'required| email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'photo'   => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('photo');
        $slug =  Str::slug($request->input('name'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('customer_upload')->exists('customer'))
            {
                Storage::disk('customer_upload')->makeDirectory('customer');
            }

            // delete old photo
            if (Storage::disk('customer_upload')->exists( $customer->photo))
            {
                Storage::disk('customer_upload')->delete( $customer->photo);
            }

            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('customer_upload')->put($imageName, $postImage);
        } else
        {
            $imageName = $customer->photo;
        }

        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');
        $customer->city = $request->input('city');
        $customer->shop_name = $request->input('shop_name');
        $customer->account_holder = $request->input('account_holder');
        $customer->account_number = $request->input('account_number');
        $customer->bank_name = $request->input('bank_name');
        $customer->bank_branch = $request->input('bank_branch');
        $customer->photo = $imageName;
        $customer->save();

        Toastr::success('Customer Successfully Updated', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $customer = Customer::find($id);
      if (Storage::disk('customer_upload')->exists( $customer->photo))
      {
          Storage::disk('customer_upload')->delete( $customer->photo);
      }
        $customer->delete();
        Toastr::success('Customer Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }
}
