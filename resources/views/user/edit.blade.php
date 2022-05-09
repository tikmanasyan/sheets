@extends("layouts.app")
@section('title')Update user {{$user['first_name']}} {{$user['last_name']}}
@endsection
@section("content")
    <div class="container">
        <h3>Update  {{$user['first_name']}} {{$user['last_name']}}</h3>
        <form action="{{ route('update-user') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$user['id']}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="John" value="{{$user['first_name']}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Smith" value="{{$user['last_name']}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">User Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="example@mail.ru" value="{{$user['email']}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="+37498323232" value="{{$user['phone']}}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Example textarea</label>
                <textarea class="form-control" id="comment" name="comments" rows="3">{{$user['comments']}}</textarea>
            </div>
            <button class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
