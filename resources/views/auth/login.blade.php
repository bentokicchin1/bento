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
                        {{ csrf_field() }}
                        {{ Form::text('email',null, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                        <div class="web-submit">
                            {{ Form::submit('Get Me In', ['class' => 'form-control submit']) }}
                            {{ link_to_route('password.request', 'Forgot Your Password?',[],  ['class' => 'btn btn-link']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection