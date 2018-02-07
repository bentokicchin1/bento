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
                        {{ Form::open(['route' => 'address-add', 'method' => 'post']) }} 
                        {{ Form::select('orderTypeId', $orderTypes, '', ['class' => 'form-control drpdown','placeholder' => 'Please Select Order Type' ])}}
                        {{ Form::select('addressTypes', ['Home' => 'Home', 'office' => 'Office'], '', ['class' => 'form-control drpdown','placeholder' => 'Please Select Address Type' ])}}
                        {{ Form::text('name',old('name') , ['class' => 'form-control', 'placeholder' => 'Full Name (required)']) }}
                        {{ Form::text('location',old('location') , ['class' => 'form-control', 'placeholder' => 'Location (required)']) }}
                        {{ Form::select('area', ['Koperkhairne' => 'Koperkhairne'], 'Koperkhairne', ['class' => 'form-control drpdown','placeholder' => 'Please Select Your Area' ])}}
                        {{ Form::select('city', ['Navi Mumbai' => 'Navi Mumbai'], 'Navi Mumbai', ['class' => 'form-control drpdown','placeholder' => 'Please Select Your City', 'readonly'])}}
                        {{ Form::text('state','Maharashtra' , ['class' => 'form-control', 'placeholder' => 'State (required)', 'readonly']) }}
                        {{ Form::number('pincode',old('pincode'), ['class' => 'form-control', 'placeholder' => 'Pincode (required)']) }}
                        <div class="checkbox">
                            <label style="font-size: 1.2em">
                                {{ Form::checkbox('setAsDefault', 1, true) }}
                                <span class="cr">
                                    <i class="cr-icon fa fa-check"></i>
                                </span>
                                <span>
                                    Set As Default
                                </span>
                            </label>
                        </div>
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