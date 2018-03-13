@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row content">

            <div class="col-md-3 col-sm-12 ">
                <ul class="ma-nav ">
                    <li id="profile" class="md-12 sm-2 ">
                        <a class="active" href="{{route('profile')}}">
                            <strong>My Profile</strong>
                            <span>Name, Phone, Password</span>
                        </a>
                    </li>
                    <li id="myorders" class="md-12 sm-2 ">
                        <a href="{{ route('orders')}}">
                            <strong>View My Orders</strong>
                            <span>Check Past Order Items</span>
                        </a>
                    </li>

                    <li id="address" class="md-12 sm-2 ">
                        <a href="{{route('address')}}">
                            <strong>My Address Book</strong>
                            <span>Add, Edit Addresses</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-sm-12">
                <div class="container-fluid">
                    <div class="row">
                        @include('layouts.success')
                        @include('layouts.errors')
                        <div class="block-content col-md-6 col-sm-12">
                            <div class="heading">Your Profile Information</div>
                            <div class="form-group">
                                {{ Form::open(['route' => 'update-info', 'method' => 'post']) }}
                                {{ Form::text('name',$userInfo->name , ['class' => 'form-control', 'placeholder' => 'Name (required)']) }}
                                {{ Form::number('mobile_number',$userInfo->mobile_number, ['class' => 'form-control', 'placeholder' => 'Mobile Number (required)']) }}
                                {{ Form::email('email',$userInfo->email, ['class' => 'form-control', 'placeholder' => 'Email Address (required)']) }}
                                <div class="form-group">
                                    {!! Form::label('daily', ' Billing Cycle',['class'=>'control-label']) !!}
                                    {!! Form::label('daily', 'Daily',['class'=>'radio-inline control-label']) !!}
                                    {{ Form::radio('billing_cycle', 'daily',$userInfo->billing_cycle=='daily',['class'=>'']) }}
                                    {!! Form::label('monthly', 'Monthly',['class'=> 'radio-inline control-label']) !!}
                                    {{ Form::radio('billing_cycle', 'monthly',$userInfo->billing_cycle=='monthly',['class'=>'']) }}
                                </div>
                                {{ Form::submit('Save Info', ['class' => 'form-control web-submit']) }}

                                {{ Form::close() }}
                            </div>
                        </div>

                        <div class="block-content col-md-6 col-sm-12">
                            <div class="heading">Change Your Password</div>
                            <div class="form-group">
                                {{ Form::open(['route' => 'change-password', 'method' => 'post']) }}
                                {{ Form::password('current_password', ['class' => 'form-control', 'placeholder' => 'Current Password (required)']) }}
                                {{ Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'New Password (required)']) }}
                                {{ Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password (required)']) }}
                                {{ Form::submit('Change Password', ['class' => 'form-control web-submit']) }}
                                {{ Form::close() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
