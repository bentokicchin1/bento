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
                        {{ Form::open(['route' => 'admin-password-email', 'method' => 'post']) }} 
                        {{ Form::text('email','', ['class' => 'form-control', 'placeholder' => 'Email Address']) }}
                        <div class="clearfix"></div>
                        <div class="web-submit">
                            {{ Form::submit('Send Password Reset Link', ['class' => 'form-control submit']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
