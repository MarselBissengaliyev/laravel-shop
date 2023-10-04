@if (session('message'))
<div class="alert alert-success mt-5" role="alert">
    <h2>{{ session('message') }}</h2>
</div>
@endif