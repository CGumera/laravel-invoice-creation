<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Product;
use App\InvoiceProduct;
use App\InvoicePaymentType;
use App\PaymentType;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('dashboard')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $payment_types = PaymentType::all();
        $data = [
            'products' => $products,
            'payment_types' => $payment_types
        ];
        return view('invoice.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate form inputs
        $this->validateRequest($request);
        
        //save invoice details
        $invoice = new Invoice();
        $this->saveInvoiceDetails($request, $invoice);
        
        //save invoice products and payment types
        $this->saveInvoiceProductsAndPaymentTypes($request, $invoice->id);
        
        return redirect('/')->with('success','Invoice was created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('invoice.index')->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::all();
        $payment_types = PaymentType::all();
        $invoice = Invoice::find($id);
        $data = [
            'products' => $products,
            'payment_types' => $payment_types,
            'invoice' => $invoice
        ];

        return view('invoice.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate form inputs
        $this->validateRequest($request, $id);
        
        //save invoice details
        $invoice = Invoice::find($id);
        $this->saveInvoiceDetails($request, $invoice);
        
        //delete invoice products and payment types
        InvoiceProduct::where('invoice_id', $id)->delete();
        InvoicePaymentType::where('invoice_id', $id)->delete();

        //save new invoice products and payment types
        $this->saveInvoiceProductsAndPaymentTypes($request, $id);

        return redirect('/')->with('success','Invoice was updated successfully!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::find($id)->delete();
        return redirect('/')->with('success','Invoice was deleted successfully!');;
    }

    /**
     * Store invoice details.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Invoice $invoice
     */
    public function saveInvoiceDetails(Request $request, Invoice $invoice) {
        $invoice->customer_name = $request->input('customer_name');
        $invoice->address = $request->input('address');
        $invoice->invoice_date = $request->input('invoice_date');
        $invoice->invoice_number = $request->input('invoice_number');
        $invoice->due_date = $request->input('due_date');
        $invoice->note = $request->input('note');
        $invoice->sub_total = $request->input('sub_total');
        $invoice->tax_percent = $request->input('tax_percent') / 100;
        $invoice->tax_amount = $request->input('tax_amount');
        $invoice->grand_total = $request->input('grand_total');
        $invoice->save();
    }

    /**
     * Store invoice products and payment types.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     */
    public function saveInvoiceProductsAndPaymentTypes(Request $request, $id) {
        //save invoice products
        for ($i = 0; $i < count($request->product); $i++) {
            if (!empty($request->product[$i]) && $request->quantity[$i] > 0 && $request->unit_price[$i] > 0) {
                $invoice_product = new InvoiceProduct();
                $invoice_product->invoice_id = $id;
                $invoice_product->product_id = $request->product[$i];
                $invoice_product->quantity = $request->quantity[$i];
                $invoice_product->unit_price = $request->unit_price[$i];
                $invoice_product->total_price = $request->total_price[$i];
                $invoice_product->save();
            }
        };

        //save invoice payment types
        for ($i = 0; $i < count($request->payment_type); $i++) {
            if (!empty($request->payment_type[$i]) && $request->amount[$i] > 0) {
                $invoice_payment_type = new InvoicePaymentType();
                $invoice_payment_type->invoice_id = $id;
                $invoice_payment_type->payment_type_id = $request->payment_type[$i];
                $invoice_payment_type->amount = $request->amount[$i];
                $invoice_payment_type->save();
            }
        };
    }

    /**
     * Validate request inputs.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return $request validation
     */
    public function validateRequest(Request $request, $id = '') {
        return $request->validate([
            'customer_name' => 'required',
            'address' => 'required',
            'invoice_date' => 'required|date',
            'invoice_number' => 'required|unique:invoices,invoice_number,'.$id,
            'due_date' => 'required|date',
            'note' => 'required',
            'product.*'  => 'required|string|distinct',
            'quantity.*'  => 'required|integer',
            'unit_price.*'  => 'required|numeric',
            'sub_total' => 'required|numeric',
            'tax_percent' => 'required|numeric',
            'tax_amount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'payment_type.*'  => 'required|string',
            'amount.*'  => 'required|numeric',
        ]);
    }
}
