@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')

                <h1>Add new address</h1>

                <div class="web-form">
                    <div class="form-group">
                        @if(isset($addressData))
                        {{ Form::model($addressData, ['route' => ['address-add', $addressData['id']]]) }}
                        {{ Form::hidden('id', $addressData['id']) }}
                        @else
                        {{ Form::open(['route' => 'address-add', 'method' => 'post']) }}
                        @endif

                        {{ Form::select('order_type_id', $orderTypes, old('order_type_id'), ['required'=>true,'class' => 'form-control drpdown','placeholder' => 'Please Select Order Type' ])}}
                        {{ Form::text('name',old('name'),['required'=>true,'class' => 'form-control', 'placeholder' => 'Full Name (required)']) }}
                        {{ Form::select('city', $cityData, old('city'), ['required'=>true,'class' => 'form-control drpdown','placeholder' => 'Please Select Your City'])}}
                        {{ Form::select('area', $areaData, old('area'), ['required'=>true,'class' => 'form-control drpdown','placeholder' => 'Please Select Your Area' ])}}
                        {{ Form::select('sector', $areaLocationData, old('sector'), ['required'=>true,'class' => 'form-control drpdown','placeholder' => 'Please Select Your Sector' ])}}
                        {{ Form::text('location',old('location') , ['required'=>true,'class' => 'form-control', 'placeholder' => 'Office Name/Building Name (required)']) }}
                        {{ Form::text('state', 'Maharashtra' , ['required'=>true,'class' => 'form-control', 'placeholder' => 'State (required)', 'readonly']) }}
                        {{ Form::number('pincode',old('pincode'), ['required'=>true,'class' => 'form-control', 'placeholder' => 'Pincode (required)']) }}
                        <div class="web-submit">
                            {{ Form::submit('Save Address', ['class' => 'form-control submit']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
