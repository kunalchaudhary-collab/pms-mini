@extends('layouts.app')
@section('content')
<h2>Register</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div><label>Name</label><br><input name="name" value="{{ old('name') }}"></div>
    <div><label>Email</label><br><input name="email" value="{{ old('email') }}"></div>
    <div><label>Password</label><br><input type="password" name="password"></div>
    <div><label>Confirm Password</label><br><input type="password" name="password_confirmation"></div>
    <div><button type="submit">Register</button></div>
</form>
@endsection
