<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PMS Mini</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a> |
            <a href="{{ route('projects.index') }}">Projects</a> |
            <a href="{{ route('tasks.index') }}">Tasks</a> |
            <a href="{{ route('activity.index') }}">Activity</a> |
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
            <span> | {{ auth()->user()->name }}</span>
        @else
            <a href="{{ route('login') }}">Login</a>| 
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>
    <hr>
    <div>
        @if(session('success')) <div style="color:green">{{ session('success') }}</div> @endif
        @if($errors->any()) <div style="color:red"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        @yield('content')
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
