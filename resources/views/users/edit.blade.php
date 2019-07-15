@extends('layouts.app')
@section('content')

<div class="container">
    <div class=" row justify-content-center">
        <form method="post" action="/users/edit/{{ $user->id }}/update">

            {{ csrf_field() }}
            {{ method_field('patch') }}

            <div class="form-group">
                <h4>Name</h4>
                <input class="form-control" type="text" name="name" value="{{ $user->name }}" />

                <br>
                <h4>Email</h4>
                <input class="form-control" type="email" name="email" value="{{ $user->email }}" />

                <!-- <input type="password" name="password" />

            <input type="password" name="password_confirmation" /> -->
            </div>

            <button class="btn  btn-outline-success btn-block btn-lg" type="submit">Submit</button>

        </form>
    </div>
</div>

@endsection