@extends('layouts.app')
@section('content')

<div class="container">
    <div class=" row justify-content-center">
        <form method="post" action="/users/edit/{{ $user->id }}/update">

            {{ csrf_field() }}
            {{ method_field('patch') }}

            <div class="form-group">
                <h4>Name</h4>
                <input class="form-control" type="text" name="name" value="{{ $user->name }}" required />

                <br>
                <h4>Email</h4>
                <input class="form-control" type="email" name="email" value="{{ $user->email }}" required />

                <br>
                <h4>Department</h4>
                <select name="department" class="form-control">

                    @foreach($departments as $key=>$department)
                    <option id="{{$department->id}}" value="{{$department->id}}">{{ $department->name }}</option>
                    @endforeach

                </select>
            </div>

            <button class="btn  btn-outline-success btn-block btn-lg" type="submit">Submit</button>

        </form>
    </div>
</div>

@endsection