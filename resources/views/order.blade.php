@extends('layouts.master')

@section('content')
<!-- Header section
    ================================================== -->
    <section id="header-custom">
      <div class="container bottom-line">
        <div class="row">

          <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
            <div class="header-thumb">
                <h1 class="wow" data-wow-delay="0s">Order Now</h1>
                <h3 class="wow" data-wow-delay="0s">Feeling hungry, let's place the order</h3>
            </div>
        </div>

    </div>
</div>
</section>


<!-- Book Now section
    ================================================== -->
    <section id="order">
      <div class="container">
        <div class="row">
          <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 order wow fadeIn" data-wow-delay="0s">
            <div class="order-form">

            {{ Form::open(['route' => 'processOrder', 'method' => 'post']) }} 
                {{ Form::hidden('orderTypeId', $typeId) }}
                {{ Form::select('sabji', ['1' => 'Aloo (30)', '2' => 'Bhendi (40)', '3' => 'Tomato (30)', '4' => 'Palak Paneer (50)'], 123, ['class' => 'form-control','placeholder' => 'Pick a Sabji...'])}}
                {{ Form::select('chapati', ['1' => 1, '2' => 2, '3' => 3, '4' => 4], 123, ['class' => 'form-control','placeholder' => 'Pick Chapati Count...'])}}

                <div class="checkbox">
                  <label style="font-size: 1.5em">
                    {{ Form::checkbox('milk', 'milk', true) }}
                    <span class="cr">
                      <i class="cr-icon fa fa-check"></i>
                  </span>
                  <span>
                      Butter Milk (
                      <i class="fa fa-inr"></i>10)
                  </span>
              </label>

              <label style="font-size: 1.5em">
                {{ Form::checkbox('rice', 'rice', true) }}
                <span class="cr">
                  <i class="cr-icon fa fa-check"></i>
              </span>
              <span>
                  Rice (
                  <i class="fa fa-inr"></i>20)
              </span>
          </label>

          <label style="font-size: 1.5em">
            {{ Form::checkbox('dal', 'dal', true) }}
            <span class="cr">
              <i class="cr-icon fa fa-check"></i>
          </span>
          <span>
              Dal (
              <i class="fa fa-rupee"></i>20)
          </span>
      </label>
  </div>

  <div class="order-submit">
      {{ Form::submit('Place Your Order', ['class' => 'form-control submit']) }}
  </div>
  {{ Form::close() }}
</div>

</div>

</div>
</div>
</section>

@endsection