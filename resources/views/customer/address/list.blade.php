@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row" style="margin-bottom:15px">
        <h1>Select address</h1>
            @foreach($addressList as $address)
            <div class="col-md-3 col-sm-3" style="border:1px solid #eee; height:150px; margin-right:1px">
                <h3> {{ $address['name'] }}</h3>
                <p>{{ $address['location'].', '.$address['area'].', '.$address['city'].', '.$address['state'].', '.$address['pincode']}} </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
