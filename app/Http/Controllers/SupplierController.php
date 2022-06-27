<?php

namespace App\Http\Controllers;

use App\Supplier;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.supplier.index', compact('suppliers'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPayables()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.supplier.index_ap', compact('suppliers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getDatatable()
     {

       // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
       // $delURL = url('/') . '/admin/supplier/destroy/';
       // $ediURL = url('/') . '/admin/supplier/';
       // if( purchase_headers.finalized = 1, concat($delURL,purchase_headers.id) ,"")
       $suppliers = Supplier::latest()->get();


         return Datatables::of($suppliers)
          ->addColumn('actions', function($record){
            return view('includes._datatable_actions', [
                'showUrl'    => route('admin.supplier.show', [ $record->id] ),
                // 'deleteUrl'  => $record->delete_url,
                // 'editUrl'    => $record->edit_url,
                'deleteUrl' => route('admin.supplier.destroy', [ $record->id]),
                'editUrl' => route('admin.supplier.edit', [ $record->id])
            ]);
          })->make(true);





     }

     public function getDropdownSelect()
     {
       $search = $_GET['q'];
       $suppliers =   DB::table('suppliers' )
           ->select('name','email','shop_name','id','phone','city','balance')
           ->where('name', 'LIKE', '%'.$search.'%')
           ->get();
           return json_encode($suppliers);

     }

    public function create()
    {
        return view('admin.supplier.create');
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
            'email' => 'required| email | unique:suppliers',
            'phone' => 'required | unique:suppliers',
            'address' => 'required',
            'city' => 'required',
            'photo' => 'required | image',
            'type' => 'required | integer',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('photo');
        $slug =  Str::slug($request->input('name'));
        // if (isset($image))
        // {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('supplier_upload')->exists('supplier'))
            {
                Storage::disk('supplier_upload')->makeDirectory('supplier');
            }
            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('supplier_upload')->put($imageName, $postImage);
        // } else
        // {
        //     $imageName = 'default.png';
        // }

        $supplier = new Supplier();
        $supplier->name = $request->input('name');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->address = $request->input('address');
        $supplier->city = $request->input('city');
        $supplier->type = $request->input('type');
        $supplier->shop_name = $request->input('shop_name');
        // $supplier->account_holder = $request->input('account_holder');
        // $supplier->account_number = $request->input('account_number');
        // $supplier->bank_name = $request->input('bank_name');
        // $supplier->bank_branch = $request->input('bank_branch');
        $supplier->photo = $imageName;
        $supplier->save();

        Toastr::success('Supplier Successfully Created', 'Success!!!');
        return redirect()->route('admin.supplier.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('admin.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3',
            'email' => 'required| email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'photo' =>  'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'type' => 'required | integer',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('photo');
        $slug =  Str::slug($request->input('name'));
        // if (isset($image))
        // {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('supplier_upload')->exists('supplier'))
            {
                Storage::disk('supplier_upload')->makeDirectory('supplier');
            }

            // delete old photo
            if (Storage::disk('supplier_upload')->exists( $supplier->photo))
            {
                Storage::disk('supplier_upload')->delete( $supplier->photo);
            }

            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('supplier_upload')->put($imageName, $postImage);
        // } else
        // {
        //     $imageName = $supplier->photo;
        // }

        $supplier->name = $request->input('name');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->address = $request->input('address');
        $supplier->city = $request->input('city');
        $supplier->type = $request->input('type');
        $supplier->shop_name = $request->input('shop_name');
        // $supplier->account_holder = $request->input('account_holder');
        // $supplier->account_number = $request->input('account_number');
        // $supplier->bank_name = $request->input('bank_name');
        // $supplier->bank_branch = $request->input('bank_branch');
        $supplier->photo = $imageName;
        $supplier->save();

        Toastr::success('Supplier Successfully Updated', 'Success!!!');
        return redirect()->route('admin.supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        // delete old photo
        if (Storage::disk('supplier_upload')->exists( $supplier->photo))
        {
            Storage::disk('supplier_upload')->delete( $supplier->photo);
        }

        $supplier->delete();
        Toastr::success('Supplier Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.supplier.index');
    }
}
