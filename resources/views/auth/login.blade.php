@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div><label>Email</label><br><input name="email" value="{{ old('email') }}"></div>
            <div><label>Password</label><br><input type="password" name="password"></div>
            <div><button class="btn" type="submit">Login</button></div>
        </form>
    </div>
@endsection
