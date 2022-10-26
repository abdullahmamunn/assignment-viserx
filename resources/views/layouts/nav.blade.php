<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="{{ route('dashboard') }}">Laravel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('registation') }}">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product.index') }}">Product List</a>
                </li>

                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product.index') }}">Product List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.assign.role') }}">Assign Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.assign.route') }}">Assign Route Permission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">Logout</a>
                </li>
                
                @endguest
            </ul>
        </div>
    </div>
</nav>
