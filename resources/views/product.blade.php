@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                <form method="post" action="{{ route('checkoutproduct') }}">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="product" class="col-sm-4 col-form-label">Product</label>
                        <div class="col-sm-8">
                            <textarea class="form-control{{ $errors->has('product') ? ' is-invalid' : '' }}" name="product" id="product" rows="5">{{ old('product') }}</textarea>
                            @if ($errors->has('product'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="shippingaddress" class="col-sm-4 col-form-label">Shipping Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control{{ $errors->has('shippingaddress') ? ' is-invalid' : '' }}" name="shippingaddress" id="shippingaddress" rows="5">{{ old('shippingaddress') }}</textarea>
                            @if ($errors->has('shippingaddress'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('shippingaddress') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-sm-4 col-form-label">Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" id="price" value="{{ old('price') }}">   
                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="buttonsumbit" class="col-sm-4 col-form-label">&nbsp;</label>
                        <div class="col-sm-8">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
