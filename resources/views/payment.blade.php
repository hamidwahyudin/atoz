@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    @if (session('error_status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error_status') }}
                        </div>
                    @endif
                    @if (session('success_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success_status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                <form method="post" action="{{ route('checkoutdopayment') }}">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="ordernumber" class="col-sm-4 col-form-label">Order Number</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" name="ordernumber" id="ordernumber" value="{{ $invoice }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="buttonsumbit" class="col-sm-4 col-form-label">&nbsp;</label>
                        <div class="col-sm-8">
                            <button class="btn btn-primary">Pay</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
