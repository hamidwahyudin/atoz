@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                <form method="post" action="{{ route('checkoutprepaidbalance') }}">
                    @method('post')
                    @csrf
                    <div class="form-group row">
                        <label for="mobilephone" class="col-sm-4 col-form-label">Mobile Phone Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control{{ $errors->has('mobilephone') ? ' is-invalid' : '' }}" name="mobilephone" id="mobilephone" value="{{ old('mobilephone') }}">
                            @if ($errors->has('mobilephone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobilephone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="prepaidvalue" class="col-sm-4 col-form-label">Value</label>
                        <div class="col-sm-8">
                            <select class="form-control{{ $errors->has('mobilephone') ? ' is-invalid' : '' }}" name="prepaidvalue" id="prepaidvalue">
                                <option value=""></option>
                                <option value="10000">10.000</option>
                                <option value="50000">50.000</option>
                                <option value="100000">100.000</option>
                            </select>
                            @if ($errors->has('prepaidvalue'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('prepaidvalue') }}</strong>
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
