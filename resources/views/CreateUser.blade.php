@extends('adminlte::page')

@section('title', 'user data')

@section('content_header')
    <h1>user creation</h1>
@stop
@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif    <form action={{ route('users.createUser') }} method="post"  class="form-group">
            @csrf
        <div>
            <label for="first_name">first_name</label>
            <input type="text" class="form-control" name="first_name" id="first_name" value={{ old("first_name") }}>
        </div>
        <div>
            <label for="last_name">last_name</label>
            <input type="text" class="form-control" name="last_name" id="last_name" value={{ old("last_name") }}>
        </div>
        <div>
            <label for="username">username</label>
            <input type="text" class="form-control" name="username" id="username" value={{ old("username") }}>
        </div>
        <div>
            <label for="email">email</label>
            <input type="text" class="form-control" name="email" id="email" value={{ old("email") }}>
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" class="form-control" name="password" id="password" >
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:20px;width:100px">Submit</button>
    </form>
@stop


