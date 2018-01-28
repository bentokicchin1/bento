@if(Session::has('status'))

<div class="alert alert-success">
    <strong>{{  Session::get('status') }}</strong>
</div>
@endif