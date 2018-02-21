@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')
                
                <h1>Log In</h1>

                <div class="web-form">
                    <div class="form-group">
                        {{ Form::open(['route' => 'login', 'method' => 'post']) }} 
                        {{ Form::number('mobile_number',old('mobile_number'), ['class' => 'form-control', 'placeholder' => 'Mobile Number', 'required']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) }}
                        <div class="checkbox">
                            <label style="font-size: 1em">
                                {{ Form::checkbox('remember', true, true) }}
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                <span>Remember Me</span>
                            </label>
                        </div>
                        {{ Form::submit('Get Me In', ['class' => 'form-control web-submit']) }}
                        {{ link_to_route('password.request', 'Forgot Your Password?',[],  ['class' => 'btn btn-link']) }}|
                        {{ link_to_route('register', 'Register as New user',[],  ['class' => 'btn btn-link']) }}
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection