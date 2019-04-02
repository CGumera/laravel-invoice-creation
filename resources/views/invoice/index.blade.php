@extends('layouts.main')

@section('content')
    <div class="container p-3">
        <h2>View Invoice</h2>
        <div class="row mt-4">
            <div class="col-md-3">
                <label><strong>Customer Name</strong></label>
                <p>{{ $invoice->customer_name }}</p>
            </div>
            <div class="col-md-9">
                <label><strong>Address</strong></label>
                <p>{{ $invoice->address }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label><strong>Invoice Date</strong></label>
                <p>{{ $invoice->invoice_date }}</p>
            </div>
            <div class="col-md-3">
                <label><strong>Invoice Number</strong></label>
                <p>{{ $invoice->invoice_number }}</p>
            </div>
            <div class="col-md-3">
                <label><strong>Due Date</h5></strong></label>
                <p>{{ $invoice->due_date }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <strong>Note</strong>
                <p>{{ $invoice->note }}</p>
            </div>
        </div>
        <h5 class="mt-4">Products</h5>
        <div class="row mt-2">
            <div class="col-md-12">
                <table class="table table-hover" id="tbl_products">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->products()->get() as $invoice_product)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{ $invoice_product->with('product')
                                    ->where('product_id',$invoice_product->product_id)
                                    ->first()->product->name }}
                                </td>
                                <td class="text-center">{{ $invoice_product->quantity }}</td>
                                <td class="text-center">{{ $invoice_product->unit_price }}</td>
                                <td class="text-center">{{ $invoice_product->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <h5>Payment Type</h5>
        <div class="row mt-2">
            <div class="col-md-6">
                <table class="table table-hover" id="tbl_payment_type">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Payment Type</th>
                            <th class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->payment_types()->get() as $invoice_payment_type)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $invoice_payment_type->with('payment_type')
                                ->where('payment_type_id', $invoice_payment_type->payment_type_id)
                                ->first()->payment_type->name }}
                            </td>
                            <td class="text-center">{{ $invoice_payment_type->amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-md-4">
                <table class="table" id="tbl_products_total">
                    <tbody>
                        <tr>
                            <th>Sub Total</th>
                            <td>{{ $invoice->sub_total }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>{{ $invoice->tax_percent }}%</td>
                        </tr>
                        <tr>
                            <th>Tax Amount</th>
                            <td>{{ $invoice->tax_amount }}</td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td>{{ $invoice->grand_total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection