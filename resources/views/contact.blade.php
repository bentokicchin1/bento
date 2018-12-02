@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')

                <h1>Conatct-Us</h1>

                <div class="web-form">
                    <div class="form-group">
                        {{ Form::open(['route' => 'contact-us', 'method' => 'post']) }}
                        {{ Form::text('name',old('name') , ['class' => 'form-control', 'placeholder' => 'Name (required)']) }}
                        {{ Form::number('mobile_number',old('mobile_number'), ['class' => 'form-control', 'placeholder' => 'Mobile Number (required)']) }}
                        {{ Form::email('email',old('email'), ['class' => 'form-control', 'placeholder' => 'Email Address (required)']) }}
                        <textarea name="message" class="form-control" placeholder="Message" rows="4" required></textarea>
                        <div class="web-submit">
                            {{ Form::submit('Send a message', ['class' => 'form-control submit']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>

            <div class="col-md-4 col-sm-4">
                {{-- <div class="wow fadeInUp media" > --}}
                <div class="media-object pull-left">
                    <i class="fa fa-tablet"></i>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">Phone</h3>
                    <!-- <p>{{ config('constants.number') }}</p> -->
                    <p>9819304243</p>
                </div>
                {{-- </div> --}}
            </div>

            <div class="col-md-4 col-sm-4">
                <div class="media-object pull-left">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">Email</h3>
                    <p>{{ config('constants.email','') }}</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-4">
                <div class="media-object pull-left">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">Address</h3>
                    <p>{{ config('constants.address') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
