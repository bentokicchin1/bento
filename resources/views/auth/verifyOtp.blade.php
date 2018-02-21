@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')
                
                <h1>Verify Your OTP - {{ $otp }}</h1>
                
                <div class="web-form">
                    <div class="form-group">
                        {{ Form::open(['route' => 'login', 'method' => 'post']) }} 
                        {{ Form::number('otp',old('otp'), ['class' => 'form-control', 'placeholder' => 'Enter OTP', 'required']) }}
                        {{ Form::submit('Submit', ['class' => 'form-control web-submit']) }}
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection