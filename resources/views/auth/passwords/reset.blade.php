@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')
                
                <h1>Reset Password</h1>

                <div class="web-form">
                    <div class="form-group">
                        {{ Form::open(['route' => 'password.request', 'method' => 'post']) }} 
                        {{ csrf_field() }}
                        {{ Form::hidden('token', $token) }}
                        {{ Form::email('email','', ['class' => 'form-control', 'placeholder' => 'Email Address (required)']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password (required)']) }}
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password (required)']) }}
                        <div class="web-submit">
                            {{ Form::submit('Reset Password', ['class' => 'form-control submit']) }}
                        </div>
                        {{ Form::close() }}
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

@endsection
