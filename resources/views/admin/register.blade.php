@extends('layouts.master')

@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')

                <h1>Create an account</h1>

                <div class="web-form">
                    <div class="form-group">
                        {{ Form::open(['route' => 'admin-register', 'method' => 'post']) }} 
                        {{ Form::text('name',old('name') , ['class' => 'form-control', 'placeholder' => 'Name (required)']) }}
                        {{ Form::number('mobile_number',old('mobile_number'), ['class' => 'form-control', 'placeholder' => 'Mobile Number (required)']) }}
                        {{ Form::email('email',old('email'), ['class' => 'form-control', 'placeholder' => 'Email Address (required)']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password (required)']) }}
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password (required)']) }}

                        <div class="web-submit">
                            {{ Form::submit('Register', ['class' => 'form-control submit']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
