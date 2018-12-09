@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- <div class="card-header">Dashboard</div> -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            Hello, 
                            @if (Auth::user()->name)
                                {{ Auth::user()->name }}
                            @else
                                {{ Auth::user()->email }}
                            @endif
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('prepaidbalance') }}" class="btn btn-primary btn-sm">Need a prepaid Balance?</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('product') }}" class="btn btn-primary btn-sm">Want to buy something?</a>
                        </div>
                    </div>
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->

                    <!-- You are logged in! -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
