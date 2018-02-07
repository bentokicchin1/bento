@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row" style="margin-bottom:15px">
                <div class="col-md-8 col-sm-8">
                    <h1>Select address</h1>
                    <div class="web-form">
                        <div class="form-group">
                            {{ Form::open(['route' => 'processOrder', 'method' => 'post']) }} 
                            @foreach($addressList as $address)
                            <div class="col-md-4 col-sm-4">
                                <div class="radio">
                                    {{ Form::radio('addressId', $address['id']) }}
                                </div>
                                <h3> {{ $address['name'] }}</h3>
                                <p>{{ $address['location'].', '.$address['area'].', '.$address['city'].', '.$address['state'].', '.$address['pincode']}} </p>
                            </div>
                            @endforeach
                            <div class="web-submit">
                                {{ Form::submit('Confirm Order', ['class' => 'form-control submit']) }}
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div> 
                </div>
                <div class="col-md-4 col-sm-4">
                        <h1>Order Summary</h1>
                        <table class="table">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderData['items'] as $item => $itemValue)
                            
                            @if($item != 'others')
                                <tr>
                                    <td>{{ $itemValue['name'] }}</td>
                                    <td>{{ $itemValue['qty'] }}</td>
                                    <td>{{ round($itemValue['total_price']) }}</td>
                                </tr>
                            @else
                                @foreach($itemValue as $otherItem)
                                    <tr>
                                        <td>{{ $otherItem['name'] }}</td>
                                        <td>{{ $otherItem['qty'] }}</td>
                                        <td>{{ round($otherItem['total_price']) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            
                            @endforeach
                        </tbody>
                        <thead>
                                <tr>
                                <th>Total</th>
                                <th></th>
                                <th>{{ round($orderData['orderTotalAmount']) }}</th>
                                </tr>
                            </thead>
                        </table>
                </div>
        </div>
    </div>
</section>

@endsection
