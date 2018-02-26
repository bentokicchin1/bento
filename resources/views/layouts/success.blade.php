@if(Session::has('status'))

<div class="alert alert-success">
    <strong>{{  Session::get('status') }}</strong>
</div>
@endif

@if (session('warning'))
    <div class="alert alert-warning">
      <strong>{{ session('warning') }}</strong>
    </div>
@endif