@extends('adminlte::page')

@section('title', 'user data')

@section('content_header')
    <h1>Edit {{ $user->username }} Data</h1>
@stop
@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
    <form action={{ route('users.update',[$user->id]) }} method="post"  class="form-group">
            @csrf
    @method('PUT')

        <div>
            <label for="first_name">first_name</label>
            <input type="text" class="form-control" name="first_name" id="first_name" value={{ $user->first_name }}>
        </div>
        <div>
            <label for="last_name">last_name</label>
            <input type="text" class="form-control" name="last_name" id="last_name" value={{ $user->last_name }}>
        </div>
        <div>
            <label for="username">username</label>
            <input type="text" class="form-control" name="username" id="username" value={{ $user->username }}>
        </div>
        <div>
            <label for="email">email</label>
            <input type="text" class="form-control" name="email" id="email" value={{ $user->email }}>
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" class="form-control" name="password" id="password" >
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:20px;width:100px">Submit</button>
    </form>
@stop


