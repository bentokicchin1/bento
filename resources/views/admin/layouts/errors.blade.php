@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <strong>{{ $error }}</strong><br>
        @endforeach
    </ul>
</div>
@endif
