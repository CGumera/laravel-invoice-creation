@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <h1>Invoices</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="/invoice/create" class="btn btn-success">Create Invoice</a>
            </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Invoice Number</th>
                    <th class="text-center">Invoice Amount</th>
                    <th class="text-center">Invoice Date</th>
                    <th class="text-center">Due Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($invoices) > 0)
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->customer_name }}</td>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->grand_total }}</td>
                        <td class="text-center">{{ $invoice->invoice_date }}</td>
                        <td class="text-center">{{ $invoice->due_date }}</td>
                        <td class="text-center">
                            <a href="/invoice/{{ $invoice->id }}" class="btn btn-sm btn-primary mr-2">View</a>
                            <a href="/invoice/{{ $invoice->id }}/edit" class="btn btn-sm  btn-secondary mr-2">Edit</a>
                            <form action="{{ url('/invoice/' . $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal">Delete</button>

                                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete-modal-label">Delete Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                        Are you sure you want delete the selected invoice?
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    </div>
                        <td colspan="6" class="text-center">
                            No Created Invoice
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection