@extends('layouts.master')
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="<color-code>" bolt-logo="<image path>"></script>
<section id="web">
    <div class="container">
        <div class="row content">
  <!-- <body onload="submitPayuForm()"> -->
          <h2>PayU Form</h2>
          <br/>
          @if (!empty($payuDetails['formError']))
            <span style="color:red">Please fill all mandatory fields.</span>
            <br/>
            <br/>
          @endif
          <form method="post" action="<?php echo $payuDetails['action']; ?>" name="payuForm">
            {{ Form::hidden('_token',csrf_token()) }}
            {{ Form::hidden('key',$payuDetails['key']) }}
            {{ Form::hidden('hash',$payuDetails['hash']) }}
            {{ Form::hidden('txnid',$payuDetails['txnid']) }}
            <table>
              <tr>
                <td><b>Mandatory Parameters</b></td>
              </tr>
              <tr>
                <td>Amount: </td>
                <td>{{ Form::text('amount',$payuDetails['amount'] , ['class' => 'input-number', 'placeholder' => 'Amount']) }}</td>
                <td>First Name: </td>
                <td>{{ Form::text('firstname',$payuDetails['firstname'] , ['class' => '', 'placeholder' => 'Name']) }}</td>
              </tr>
              <tr>
                <td>Email: </td>
                <td>{{ Form::text('email',$payuDetails['email'] , ['class' => '', 'placeholder' => 'Email']) }}</td>
                <td>Phone: </td>
                <td>{{ Form::text('phone',$payuDetails['phone'] , ['class' => 'input-number', 'placeholder' => 'Mobile Number']) }}</td>
              </tr>
              <tr>
                <td>Product Info: </td>
                <td colspan="3">
                  {{ Form::textarea('productinfo',$payuDetails['productinfo'] , ['class' => '', 'placeholder' => 'Product Info','rows'=>2]) }}</td>
              </tr>
              <tr>
                <td>Success URL: </td>
                <td colspan="3">{{ Form::text('surl',$payuDetails['surl'] , ['class' => '', 'placeholder' => 'Success URL']) }}</td>
              </tr>
              <tr>
                <td>Failure URL: </td>
                <td colspan="3">{{ Form::text('furl',$payuDetails['furl'] , ['class' => '', 'placeholder' => 'Failure URL']) }}</td>
              </tr>
              <tr>
                <td colspan="3">{{ Form::hidden('service_provider',$payuDetails['service_provider'] , ['class' => '', 'placeholder' => 'Service Provider']) }}</td>
              </tr>
              <tr>
                <td colspan="3">{{ Form::hidden('udf1',$payuDetails['udf1'] , ['class' => '', 'placeholder' => 'Order Id']) }}</td>
              </tr>
              <tr>
                @if (!empty($payuDetails['hash']))
                  <td colspan="4"><input type="submit" value="Submit" /></td>
                @endif
              </tr>
            </table>
          </form>
      </div>
    </div>
</section>
  <script>
    var hash = '<?php echo $payuDetails['hash'] ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
@endsection
