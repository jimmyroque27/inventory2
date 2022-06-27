<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FullCalenderController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function() {

    Route::get('home', [HomeController::class, 'index'])->name('home');
});

// Admin Group
Route::group(['as'=>'admin.', 'prefix' => 'admin', 'middleware' => 'auth' ], function(){

    // Route::get('events', [FullCalenderController::class, 'index']);
    Route::get('events', 'FullCalenderController@index')->name('events');
    Route::post('events/action', [FullCalenderController::class, 'action']);


    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');

    Route::resource('employee', 'EmployeeController');

    Route::resource('customer', 'CustomerController');
    Route::get('admin/customer/dropdownselect', 'CustomerController@getDropdownSelect')->name('customer.dropdownselect');
    Route::get('admin/customer/datatable', 'CustomerController@getDatatable')->name('customer.datatable');
    Route::get('customer/destroy/{id}', 'CustomerController@destroy')->name('customer.destroy');
    Route::get('receivables', 'CustomerController@indexReceivables')->name('customer.receivables');

    Route::resource('attendance', 'AttendanceController');
    Route::put('attendance/{attendance?}', 'AttendanceController@att_update')->name('attendance.att_update');

    Route::resource('supplier', 'SupplierController');
    Route::get('admin/supplier/dropdownselect', 'SupplierController@getDropdownSelect')->name('supplier.dropdownselect');
    Route::get('admin/supplier/datatable', 'SupplierController@getDatatable')->name('supplier.datatable');
    Route::get('payables', 'SupplierController@indexPayables')->name('supplier.index_ap');
    Route::get('supplier/destroy/{id}', 'SupplierController@destroy')->name('supplier.destroy');

    Route::resource('purchase', 'PurchaseController');
    Route::get('admin/purchase/datatable', 'PurchaseController@getDatatable')->name('purchase.datatable');
    Route::get('admin/purchase/productdatatable/{id}', 'PurchaseController@getProductDatatable')->name('purchase.productdatatable');
    Route::post('admin/purchase/store_product', 'PurchaseController@storeProduct')->name('purchase.storeProduct');
    Route::post('admin/purchase/{id}/store_note/', 'PurchaseController@storeNote')->name('purchase.storeNote');
    Route::get('admin/purchase/{id}/finalized/', 'PurchaseController@updateFinalized')->name('purchase.finalized');
    Route::post('admin/purchase/{id}/update}', 'PurchaseController@update')->name('purchase.update');
    Route::get('purchase/destroy/{id}', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::post('admin/purchase/updateProduct}', 'PurchaseController@updateProduct')->name('purchase.updateProduct');
    Route::get('purchase/destroy/product/{id}', 'PurchaseController@destroyProduct')->name('purchase.product.destroy');
    Route::get('purchase/dropdownselect/{id}', 'PurchaseController@getDropdownSelect')->name('purchase.dropdownselect');



    Route::resource('advanced_salary', 'AdvancedSalaryController');
    Route::resource('salary', 'SalaryController');


    Route::resource('category', 'CategoryController');
    Route::resource('paymenttype', 'PaymentTypeController');
    Route::resource('merchant', 'MerchantController');
    Route::resource('product', 'ProductController');
    Route::get('admin/product/datatable', 'ProductController@getDatatable')->name('product.datatable');
    Route::get('admin/product/dropdownselect', 'ProductController@getDropdownSelect')->name('product.dropdownselect');

    Route::get('admin/product/variantdropdownselect', 'ProductVariantController@getDropdownSelect')->name('product.variantdropdownselect');
    Route::get('admin/product/{id}/variantdatatable', 'ProductController@getVariantDatatable')->name('product.variantdatatable');

    // Route::resource('product/variant', 'ProductVariantController');
    Route::get('product/{id}/variant/create', 'ProductVariantController@create')->name('product.variant.create');
    Route::get('product/variant/edit/{id}', 'ProductVariantController@edit')->name('product.variant.edit');
    Route::get('product/variant/delete/{id}', 'ProductVariantController@destroy')->name('product.variant.destroy');
    Route::post('product/variant/store', 'ProductVariantController@store')->name('product.variant.store');
    Route::put('product/variant/update/{id}', 'ProductVariantController@update')->name('product.variant.update');

    Route::get('size', 'SizeController@index')->name('product.size.index');
    Route::get('size/create', 'SizeController@create')->name('product.size.create');
    Route::post('size/store', 'SizeController@store')->name('product.size.store');
    Route::get('size/edit/{id}', 'SizeController@edit')->name('product.size.edit');
    Route::delete('size/delete/{id}', 'SizeController@destroy')->name('product.size.destroy');
    Route::put('size/update/{id}', 'SizeController@update')->name('product.size.update');

    Route::get('color', 'ColorController@index')->name('product.color.index');
    Route::get('color/create', 'ColorController@create')->name('product.color.create');
    Route::post('color/store', 'ColorController@store')->name('product.color.store');
    Route::get('color/edit/{id}', 'ColorController@edit')->name('product.color.edit');
    Route::delete('color/delete/{id}', 'ColorController@destroy')->name('product.color.destroy');
    Route::put('color/update/{id}', 'ColorController@update')->name('product.color.update');



    Route::resource('expense', 'ExpenseController');
    Route::get('expense-today', 'ExpenseController@today_expense')->name('expense.today');
    Route::get('expense-month/{month?}', 'ExpenseController@month_expense')->name('expense.month');
    Route::get('expense-yearly/{year?}', 'ExpenseController@yearly_expense')->name('expense.yearly');

    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting/{id}', 'SettingController@update')->name('setting.update');

    Route::resource('pos', 'PosController');

    Route::get('order/show/{id}', 'OrderController@show')->name('order.show');
    Route::get('order/pending', 'OrderController@pending_order')->name('order.pending');
    Route::get('order/approved', 'OrderController@approved_order')->name('order.approved');
    Route::get('order/confirm/{id}', 'OrderController@order_confirm')->name('order.confirm');
    Route::delete('order/delete/{id}', 'OrderController@destroy')->name('order.destroy');
    Route::get('order/download/{id}', 'OrderController@download')->name('order.download');
    Route::get('order/dropdownselect/{id}', 'OrderController@getDropdownSelect')->name('order.dropdownselect');

    Route::resource('receipt', 'ReceiptController');
    Route::get('admin/receipt/datatable', 'ReceiptController@getDatatable')->name('receipt.datatable');
    Route::post('receipt/update', 'ReceiptController@update')->name('receipt.update');
    Route::get('receipt/destroy/{id}', 'ReceiptController@destroy')->name('receipt.destroy');
    Route::get('receipt/show/{id}', 'ReceiptController@show')->name('receipt.show');
    Route::get('receipt/print/{id}', 'ReceiptController@print')->name('receipt.print');
    Route::get('admin/receipt/{id}/finalized/', 'ReceiptController@updateFinalized')->name('receipt.finalized');
    Route::get('receipt/{id}/datatable/details', 'ReceiptController@getDetailsDatatable')->name('receipt.detailsdatatable');
    Route::get('receipt/{id}/datatable/invoice', 'ReceiptController@getInvoiceDatatable')->name('receipt.invoicedatatable');
    Route::post('receipt/{id}/detail/store', 'ReceiptController@storeDetail')->name('receipt.storedetail');
    Route::get('receipt/detail/destroy/{id}', 'ReceiptController@destroyDetail')->name('receipt.destroydetail');
    Route::post('/receipt/detail/update', 'ReceiptController@updateDetail')->name('receipt.detail.update');
    Route::post('receipt/{id}/invoice/store', 'ReceiptController@storeInvoice')->name('receipt.storeinvoice');
    Route::post('/receipt/{id}/invoice/update', 'ReceiptController@updateInvoice')->name('receipt.invoice.update');
    Route::get('receipt/invoice/destroy/{id}', 'ReceiptController@destroyInvoice')->name('receipt.invoice.destroy');


    Route::resource('payment', 'PaymentController');
    Route::get('admin/payment/datatable', 'PaymentController@getDatatable')->name('payment.datatable');
    Route::post('payment/update', 'PaymentController@update')->name('payment.update');
    Route::get('payment/destroy/{id}', 'PaymentController@destroy')->name('payment.destroy');
    Route::get('payment/show/{id}', 'PaymentController@show')->name('payment.show');
    Route::get('admin/payment/{id}/finalized/', 'PaymentController@updateFinalized')->name('payment.finalized');
    Route::get('payment/{id}/datatable/details', 'PaymentController@getDetailsDatatable')->name('payment.detailsdatatable');
    Route::get('payment/{id}/datatable/purchase', 'PaymentController@getPurchaseDatatable')->name('payment.purchasedatatable');
    Route::post('payment/{id}/detail/store', 'PaymentController@storeDetail')->name('payment.storedetail');
    Route::get('payment/detail/destroy/{id}', 'PaymentController@destroyDetail')->name('payment.destroydetail');
    Route::post('/payment/detail/update', 'PaymentController@updateDetail')->name('payment.detail.update');
    Route::post('payment/{id}/purchase/store', 'PaymentController@storePurchase')->name('payment.storepurchase');
    Route::post('/payment/{id}/purchase/update', 'PaymentController@updatePurchase')->name('payment.purchase.update');
    Route::get('payment/purchase/destroy/{id}', 'PaymentController@destroyPurchase')->name('payment.purchase.destroy');

    Route::get('sales/today', 'OrderController@todaySales')->name('sales.today');
    Route::get('sales/datatable', 'OrderController@getDatatable')->name('order.datatable');
    Route::get('sales/todaydetailed/{id}', 'OrderController@todaySalesDetailed')->name('sales.todaydetailed');
    Route::get('sales/datatabledetailed', 'OrderController@getDatatableDetailed')->name('order.datatabledetailed');

    Route::get('sales-monthly/{month?}', 'OrderController@monthly_sales')->name('sales.monthly');
    Route::get('sales/datatablemonth', 'OrderController@getDatatableMonth')->name('order.datatablemonth');
    Route::get('sales/month/detailed/{id}', 'OrderController@monthSalesDetailed')->name('sales.monthly.detailed');
    Route::get('sales/datatablemonthdetailed', 'OrderController@getDatatableMonthDetailed')->name('order.datatablemonthdetailed');

    Route::get('sales-total','OrderController@total_sales')->name('sales.total');
    Route::get('sales/datatableyear', 'OrderController@getDatatableYear')->name('order.datatableyear');
    Route::get('sales-total/detailed/{id}','OrderController@totalSalesDetailed')->name('sales.total.detailed');
    Route::get('sales-total/datatableyeardetailed', 'OrderController@getDatatableYearDetailed')->name('order.datatableyeardetailed');

    Route::get('sales-summary/customer','OrderController@salesSummaryCustomer')->name('sales.summary.customer');
    Route::get('sales-summary/customer/datatable', 'OrderController@getDatatableCustomer')->name('order.datatablecustomer');
    Route::get('sales-summary/product','OrderController@salesSummaryProduct')->name('sales.summary.product');
    Route::get('sales-summary/product/datatable', 'OrderController@getDatatableProduct')->name('order.datatableproduct');
    Route::get('sales-summary/product/qty','OrderController@salesSummaryProductQty')->name('sales.summary.product.qty');
    Route::get('sales-summary/product/qty/datatable', 'OrderController@getDatatableProductQty')->name('order.datatableproduct.qty');

    // receiving

    Route::get('receiving/today', 'ReceivingController@todayPurchases')->name('receiving.today');
    Route::get('receiving/datatable', 'ReceivingController@getDatatable')->name('order.datatable');
    Route::get('receiving/todaydetailed/{id}', 'ReceivingController@todayPurchasesDetailed')->name('receiving.todaydetailed');
    Route::get('receiving/datatabledetailed', 'ReceivingController@getDatatableDetailed')->name('order.datatabledetailed');

    Route::get('receiving-monthly/{month?}', 'ReceivingController@monthly_receiving')->name('receiving.monthly');
    Route::get('receiving/datatablemonth', 'ReceivingController@getDatatableMonth')->name('order.datatablemonth');
    Route::get('receiving/month/detailed/{id}', 'ReceivingController@monthPurchasesDetailed')->name('receiving.monthly.detailed');
    Route::get('receiving/datatablemonthdetailed', 'ReceivingController@getDatatableMonthDetailed')->name('order.datatablemonthdetailed');

    Route::get('receiving-total','ReceivingController@total_receiving')->name('receiving.total');
    Route::get('receiving/datatableyear', 'ReceivingController@getDatatableYear')->name('order.datatableyear');
    Route::get('receiving-total/detailed/{id}','ReceivingController@totalPurchasesDetailed')->name('receiving.total.detailed');
    Route::get('receiving-total/datatableyeardetailed', 'ReceivingController@getDatatableYearDetailed')->name('order.datatableyeardetailed');

    Route::get('receiving-summary/supplier','ReceivingController@receivingSummarySupplier')->name('receiving.summary.supplier');
    Route::get('receiving-summary/supplier/datatable', 'ReceivingController@getDatatableSupplier')->name('order.datatablesupplier');
    Route::get('receiving-summary/product','ReceivingController@receivingSummaryProduct')->name('receiving.summary.product');
    Route::get('receiving-summary/product/datatable', 'ReceivingController@getDatatableProduct')->name('order.datatableproduct');
    Route::get('receiving-summary/product/qty','ReceivingController@receivingSummaryProductQty')->name('receiving.summary.product.qty');
    Route::get('receiving-summary/product/qty/datatable', 'ReceivingController@getDatatableProductQty')->name('order.datatableproduct.qty');


      // Route::get('sales-monthly/{month?}', 'OrderController@monthly_sales')->name('sales.monthly');
    // Route::get('sales-total','OrderController@total_sales')->name('sales.total');

    Route::resource('cart', 'CartController');

    Route::post('invoice', 'InvoiceController@create')->name('invoice.create');
    Route::get('print/{customer_id}', 'InvoiceController@print')->name('invoice.print');
    Route::get('order-print/{order_id}', 'InvoiceController@order_print')->name('invoice.order_print');
    Route::post('invoice-final', 'InvoiceController@final_invoice')->name('invoice.final_invoice');

});
