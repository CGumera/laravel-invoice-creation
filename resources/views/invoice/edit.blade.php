@extends('layouts.main')

@section('content')
    <div class="container p-3">
    <h2>Edit Invoice</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('/invoice/' . $data['invoice']->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" value="{{ $data['invoice']->customer_name }}">
            </div>
            <div class="form-group col-md-8">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ $data['invoice']->address }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="invoice_date">Invoice Date</label>
                <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="{{ $data['invoice']->invoice_date }}">
            </div>
            <div class="form-group col-md-4">
                <label for="invoice_number">Invoice Number</label>
                <input type="number" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number" value="{{ $data['invoice']->invoice_number }}">
            </div>
            <div class="form-group col-md-4">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $data['invoice']->due_date }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="note">Note</label>
                <textarea class="form-control" id="note" name="note" rows="3">{{ $data['invoice']->note }}</textarea>
            </div>
        </div>
        <h5 class="mt-3">Products</h5>
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
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['invoice']->products()->get() as $invoice_product)
                            <tr id="prod-{{ $loop->iteration }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <select name="product[]" id="product-{{ $loop->iteration }}" class="form-control">
                                        <option value="">-- Select Product --</option>
                                        @foreach ($data['products'] as $product)
                                            <option value="{{ $product->id }}" 
                                                @if ($product->id === $invoice_product->product_id) selected @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="quantity[]" id="quantity-{{ $loop->iteration }}" placeholder='0' class="form-control quantity" step="0" min="0" value="{{ $invoice_product->quantity }}"/></td>
                                <td><input type="number" name="unit_price[]" id="unit_price-{{ $loop->iteration }}" placeholder='0.00' class="form-control unit_price" step="0.01" min="0" value="{{ $invoice_product->unit_price }}"/></td>
                                <td><input type="number" name="total_price[]" id="total_price-{{ $loop->iteration }}" placeholder='0.00' class="form-control total_price" value="{{ $invoice_product->total_price }}" readonly/></td>
                                <td><input type="button" id='delete_product-{{ $loop->iteration }}' class="btn btn-danger btn-delete @if ($loop->iteration == 1) d-none @endif" value="Delete"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            <div class="d-flex flex-row-reverse">
                <input type="button" id="add_product" class="btn btn-success" value="Add Product">
            </div>
            <div class="row justify-content-end" style="margin-top:20px">
            <div class="col-md-4">
                <table class="table table-hover" id="tbl_products_total">
                    <tbody>
                        <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" value="{{ $data['invoice']->sub_total }}" readonly/></td>
                        </tr>
                        <tr>
                            <th class="text-center">Tax</th>
                            <td class="text-center">
                                <div class="input-group mb-2 mb-sm-0">
                                    <input type="text" class="form-control" id="tax_percent" name="tax_percent" placeholder="0" value="{{ $data['invoice']->tax_percent }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">Tax Amount</th>
                            <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" value="{{ $data['invoice']->tax_amount }}" readonly/></td>
                        </tr>
                        <tr>
                            <th class="text-center">Grand Total</th>
                            <td class="text-center"><input type="number" name='grand_total' id="grand_total" placeholder='0.00' class="form-control" value="{{ $data['invoice']->grand_total }}" readonly/></td>
                        </tr>
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
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['invoice']->payment_types()->get() as $invoice_payment_type)
                        <tr id='ptype-{{ $loop->iteration }}'>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <select name="payment_type[]" id="payment_type-{{ $loop->iteration }}" class="form-control">
                                    <option value="">-- Select Payment Type --</option>
                                    @foreach ($data['payment_types'] as $payment_type)
                                        <option value="{{ $payment_type->id }}"
                                            @if ($payment_type->id === $invoice_payment_type->payment_type_id) selected @endif>
                                            {{ $payment_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="amount[]" id="amount-{{ $loop->iteration }}" placeholder="0.00" class="form-control amount" step="0.01" min="0" value="{{ $invoice_payment_type->amount }}"/></td>
                            <td><input type="button" id="delete_payment_type-{{ $loop->iteration }}" class="btn btn-danger btn-delete-ptype @if ($loop->iteration == 1) d-none @endif" value="Delete"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex flex-row-reverse col-md-6">
            <input type="button" id="add_payment_type" class="btn btn-success" value="Add Payment Type">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Invoice</button>
    </form>
    </div>
@endsection