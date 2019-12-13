@extends('layouts.base')

@section('content')

<h1>Your Account</h1>

<form method="post">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" readonly value="{{ Auth::user()->username }}">
        </div>

        <div class="form-group col-md-6">
            <label for="username">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}">
        </div>
    </div>

</form>

@endsection
