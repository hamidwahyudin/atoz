@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <form>
                        <div class="form-group row">
                            <div class="col-sm-12">
                            Your Order Number
                            <br>
                            {{ $order->order_no }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                            Total
                            <br>
                            {{ $order->total }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                @if ($order->product == 'Prepaid Balance')
                                Your Mobile Phone Number {{ $order->shipping_address }} will be topped up for {{ $order->price }} after you pay
                                @else
                                {{ $order->product }} that cost {{ $order->price }} will be shipped to {{ $order->shipping_address }} after you pay
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                            <a href="{{ route('checkoutpayment', ['inv' => $order->order_no ]) }}" class="btn btn-primary">Pay Here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
