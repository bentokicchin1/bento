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
                            <span>Name, Phone</span>
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

                    <li id="address" class="md-12 sm-2 ">
                        <a href="{{route('address')}}">
                            <strong>Change Password</strong>
                            <span>Password</span>
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
                                {{ Form::text('mobile_number',$userInfo->mobile_number, ['class' => 'form-control', 'placeholder' => 'Mobile Number','readonly'=>'true']) }}
                                <table>
                                  <tr>
                                    <!-- <div class="form-group"> -->
                                    <td>
                                      {!! Form::label('daily', ' Billing Cycle',['class'=>'control-label','data-toggle'=>'tooltip','title'=>'Select frequency of tiffin.']) !!}
                                    </td>
                                    <td>
                                      {!! Form::label('daily', 'Daily',['class'=>'radio-inline control-label','data-toggle'=>'tooltip','title'=>'Order daily']) !!}
                                    </td>
                                    <td>
                                      {{ Form::radio('billing_cycle', 'daily',$userInfo->billing_cycle=='daily',['class'=>'radio-btn','data-toggle'=>'tooltip','title'=>'Order daily']) }}
                                    </td>
                                    <td>
                                      {!! Form::label('monthly', 'Monthly',['class'=> 'radio-inline control-label','data-toggle'=>'tooltip','title'=>'Subscribe for a month']) !!}
                                    </td>
                                    <td>
                                      {{ Form::radio('billing_cycle', 'monthly',$userInfo->billing_cycle=='monthly',['class'=>'radio-btn','data-toggle'=>'tooltip','title'=>'Subscribe for a month']) }}
                                    </td>
                                  </tr>
                                  <!-- </div> -->


                                  </tr>
                                @php
                                  $showDiv = ($userInfo->billing_cycle=='monthly' || $userInfo->billing_cycle=='') ? 'display:block;' : 'display:none;';
                                @endphp
                                <!-- <div class="monthly_preference" style="{{$showDiv}}"> -->
                                    <!-- <div class="form-group"> -->
                                      <tr>
                                        <td>
                                        {!! Form::label('veg', ' Food Preference',['class'=>'control-label', 'data-toggle'=>'tooltip','title'=>"Select preferred food type, If you can't get time to personalise your tiffin."]) !!}
                                      </td>
                                      <td>
                                        {!! Form::label('veg', 'Veg',['class'=> 'radio-inline control-label']) !!}
                                      </td>
                                      <td>
                                        {{ Form::radio('food_preference', 'veg',$userInfo->food_preference=='veg',['class'=>'radio-btn']) }}
                                      </td>
                                      <td>
                                        {!! Form::label('nonveg', 'Non-Veg',['class'=> 'radio-inline control-label']) !!}
                                      </td>
                                      <td>
                                        {{ Form::radio('food_preference', 'nonveg',$userInfo->food_preference=='nonveg',['class'=>'radio-btn']) }}
                                      </td>
                                    </tr>
                                    <tr>
                                    <!-- </div>
                                    <div class="form-group"> -->
                                      <td>
                                        {!! Form::label('daily', ' Tiffin Quantity Preference',['class'=>'control-label','data-toggle'=>'tooltip','title'=>"Select preffered food quantity, If you can't get time to personalise your tiffin."]) !!}
                                      </td>
                                      <td>
                                        {!! Form::label('full', 'Full',['class'=> 'radio-inline control-label','data-html'=>"true",'data-toggle'=>'tooltip','title'=>"Sabji <br> 3 Chapati <br> Dal <br> Rice"]) !!}
                                      </td>
                                      <td>
                                        {{ Form::radio('tiffin_quantity', 'full',$userInfo->tiffin_quantity=='full',['class'=>'radio-btn','data-html'=>"true",'data-toggle'=>'tooltip','title'=>"Sabji <br> 3 Chapati <br> Dal <br> Rice"]) }}
                                      </td>
                                      <td>
                                        {!! Form::label('half', 'Half',['class'=> 'radio-inline control-label','data-html'=>"true",'data-toggle'=>'tooltip','title'=>"Sabji <br> 3 Chapati"]) !!}
                                      </td>
                                      <td>
                                        {{ Form::radio('tiffin_quantity', 'half',$userInfo->tiffin_quantity=='half',['class'=>'radio-btn','data-html'=>"true",'data-toggle'=>'tooltip','title'=>"Sabji <br> 3 * Chapati"]) }}
                                      </td>
                                    </tr>
                                    <!-- </div> -->
                                <!-- </div> -->
                              </table>
                                {{ Form::submit('Save Info', ['class' => 'form-control web-submit']) }}
                                {{ Form::close() }}
                            </div>
                        </div>

                        <!-- <div class="block-content col-md-6 col-sm-12">
                            <div class="heading">Change Your Password</div>
                            <div class="form-group">
                                {{ Form::open(['route' => 'change-password', 'method' => 'post']) }}
                                {{ Form::password('current_password', ['class' => 'form-control', 'placeholder' => 'Current Password (required)']) }}
                                {{ Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'New Password (required)']) }}
                                {{ Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password (required)']) }}
                                {{ Form::submit('Change Password', ['class' => 'form-control web-submit']) }}
                                {{ Form::close() }}
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
