@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container body-content">
        <div class="row">
                <div class="col-md-8 col-sm-8">
                    <h1>Select address</h1>
                    @include('layouts.success')
                    @include('layouts.errors')
                    <div class="web-form">
                        <div class="form-group">
                            {{ Form::open(['route' => 'subscriptionProcessOrder', 'method' => 'post']) }} 
                            
                            @foreach($addressList as $address)
                            <?php
                            if($address['default'] == 1){
                                $status = 'checked';
                            }else{
                                $status = '';
                            }
                            ?>
                            <div class="col-md-6 col-sm-6" style="margin-bottom:20px">
                                <div class="radio">
                                    <input name="addressId" type="radio" value="{{$address['id']}}" style="height:20px;" {{ $status }}>
                                </div>
                                <div class='address-name'> {{ $address['name'] }}</div>
                                <div class="address-location">{{ $address['location'].', '.$address['area'].', '.$address['city'].', '.$address['state'].', '.$address['pincode']}} </div>
                                <div class="address-type">{{ $address['address_type'] }}</div>
                            </div>
                            @endforeach
                            <div class="col-md-4 col-sm-4" style="margin-bottom:20px">                               
                                <label class="address-new"><a href="{{ route('address-add')}}">Add New Address</a></label>
                            </div>
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
                    @foreach($orderData as $day => $orderDetail)
                    <thead>
                    <tr>
                        <th><h4>{{$day}}</h4></th><th></th><th></th>
                    </tr>
                    </thead>
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetail['items'] as $item => $itemValue)
                        
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
                        <th>{{ round($orderDetail['orderTotalAmount']) }}</th>
                        </tr>
                    </thead>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
