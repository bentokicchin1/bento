@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row" style="margin-bottom:15px">
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
            <div class="col-md-8 col-sm-8">
                <h1>Delivery address</h1>
                @include('layouts.success')
                @include('layouts.errors')
                <div class="web-form">
                  @if(!empty($addressStored))
                    <div class="form-group">
                        {{ Form::open(['route' => 'processOrder', 'method' => 'post']) }}
                        <div class="col-md-6 col-sm-6" style="margin-bottom:20px">
                            {{ Form::hidden('addressId',$addressStored['id']) }}
                            <div class="address">
                                <div class='address-name'> {{ $addressStored['name'] }}  </div><div class="address-type"> {{ ucfirst($addressStored['orderType']['name']) }}</div>
                                <div class="address-location">{{ $addressStored['location'].', '.$addressStored['areaLocation']['name'].', '.$addressStored['areaData']['name'].', '.$addressStored['cityData']['name'].', '.$addressStored['state'].', '.$addressStored['pincode']}} </div>
                            </div>
                        </div>
                        <div class="web-submit">
                            {{ Form::submit('Confirm Order', ['class' => 'form-control submit']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                  @else
                    <div class="form-group m-b-20">
                      <a href="{{ route('address-add')}}"><label class="address-new">Add Delivery Address</label></a>
                    </div>
                  @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
