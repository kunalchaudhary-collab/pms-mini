<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PMS Mini</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="container nav-content">
            <div class="nav-left">
                <a href="{{ route('dashboard') }}" class="brand">PMS Mini</a>
            </div>
            <div class="nav-right">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('projects.index') }}">Projects</a>
                    <a href="{{ route('tasks.index') }}">Tasks</a>
                    <a href="{{ route('activity.index') }}">Activity</a>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>

                    <span class="user-name">{{ auth()->user()->name }}</span>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert success message">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error message">
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <p>© {{ date('Y') }} PMS Mini. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        setTimeout(function() {
            $('.message').fadeOut('slow');
        }, 4000);
    </script>

    @stack('scripts')
</body>
</html>
