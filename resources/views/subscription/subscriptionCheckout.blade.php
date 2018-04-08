@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container body-content">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <h1>Order Summary</h1>
                @foreach($orderData as $day => $orderDetail)
                    <div class="col-md-6 col-sm-12" style="min-height:360px">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <h4><b>{{$day}}</b></h4>
                                    </th>
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
                                    <th colspan="2">Total</th>
                                    <th>{{ round($orderDetail['orderTotalAmount']) }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4 col-sm-4">
                <h1>Delivery address</h1>
                @include('layouts.success')
                @include('layouts.errors')
                <div class="web-form">
                    <div class="form-group m-b-20">
                        {{ Form::open(['route' => 'subscriptionProcessOrder', 'method' => 'post']) }}
                        {{ Form::hidden('addressId',$addressStored['id']) }}
                        <div class="address">
                            <div class='address-name'> {{ $addressStored['name'] }}  </div><div class="address-type"> {{ ucfirst($addressStored['orderType']['name']) }}</div>
                            <div class="address-location">{{ $addressStored['location'].', '.$addressStored['areaLocation']['name'].', '.$addressStored['areaData']['name'].', '.$addressStored['cityData']['name'].', '.$addressStored['state'].', '.$addressStored['pincode']}} </div>
                        </div>
                    </div>
                      {{ Form::submit('Confirm Order', ['class' => 'form-control submit']) }}
                      {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
