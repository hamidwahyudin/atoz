@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <form action="">
                                <input type="text" class="form-control" name="search" value="{{ $search_query }}">
                            </form>
                        </div>
                    </div>
                    <br>
                    <table class="table">
                        <tr>
                            <td>Order No</td>
                            <td>Description</td>
                            <td>Total</td>
                            <td>Information</td>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_no }}</td>
                            <td>
                            @if('Prepaid Balance' == $order->product)
                            {{ $order->price }} for {{ $order->shipping_address }}
                            @else
                            {{ $order->product }} that cost {{ $order->price }}
                            @endif
                            </td>
                            <td>{{ $order->total }}</td>
                            <td>
                            @if('Unpaid' == $order->status)
                            <a class="btn btn-primary" href="{{ route('checkoutpayment', ['inv' => $order->order_no]) }}">Pay</a>
                            @elseif('Prepaid Balance' == $order->product)
                                @if('Paid' == $order->status)
                                Success
                                @else
                                {{ $order->status }}
                                @endif
                            @elseif('' != $order->shipping_code)
                            Shipping Code : {{ $order->shipping_code }}
                            @else
                            {{ $order->status }}
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
