@extends("layouts.app")
@section('title')Create New User
@endsection
@section("content")
    <div class="container">
        <form action="{{ route('store-user') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="John">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Smith">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">User Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="example@mail.ru">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="+37498323232">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Example textarea</label>
                <textarea class="form-control" id="comment" name="comments" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
