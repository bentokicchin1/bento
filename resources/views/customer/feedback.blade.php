@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">

                @include('layouts.success')
                @include('layouts.errors')

                <h1>Feedback</h1>

                <div class="web-form">
                    <div class="form-group">
                        {{ Form::open(['route' => 'store-feedback', 'method' => 'post']) }} 
                        <textarea name="value" class="form-control" placeholder="Say something what do you like in us?" rows="6" required></textarea>
                        {{ Form::submit('Submit', ['class' => 'form-control web-submit']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection