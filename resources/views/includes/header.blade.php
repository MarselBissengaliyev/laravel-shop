<header class="container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      @if (auth()->user() && auth()->user()->role == 'customer')
        <a class="nav-link" id="logout" href="{{ route('customer.logout') }}">Logout</a>
        <a class="nav-link" href="{{ route('admin.index') }}">Home</a>
      @endif

      @if (auth()->user() && auth()->user()->role == 'admin')
      <a class="nav-link m-3" id="logout" href="{{ route('admin.logout') }}">Logout</a>
      <a class="nav-link m-3" href="{{ route('admin.index') }}">Home</a>
    @endif
  </nav>

  @include('includes.errors')
  @include('includes.success')
</header>