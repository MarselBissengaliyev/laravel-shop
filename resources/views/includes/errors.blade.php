@if (count($errors->all()) > 0)
<div class="alert alert-warning mt-5" role="alert">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif