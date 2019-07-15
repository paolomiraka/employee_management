@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            @if(Auth::user()->isAdmin == 1)

            <strong>
                <h2>{{ Auth::user()->name }}'s Profile</h2>
            </strong>

            <br>
            <a href="/users/showall">
                <button class="btn btn-outline-primary btn-block btn-lg">Show users</button>
            </a>
            <br>
            <a href="/departments/showall">
                <div class="btn btn-outline-success btn-block btn-lg">Show departments</div>
            </a>

            @else

            <div class="row justify-content-center">
                <div class="col">
                    <img src="/uploads/avatars/{{ Auth::user()->avatar }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                </div>
                <div class="col-lg-8">
                    <br>
                    <strong>
                        <h2>{{ Auth::user()->name }}'s Profile</h2>
                    </strong>
                    <h4>{{ Auth::user()->email }}</h4>

                    <form enctype="multipart/form-data" action="/home" method="POST">
                        <label>Update Profile Image</label>
                        <br>
                        <input type="file" name="avatar">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <br><br>
                        <input type="submit" class="pull-right btn btn-sm btn-primary">
                    </form>


                </div>
            </div>

            @endif



        </div>
    </div>
    @endsection