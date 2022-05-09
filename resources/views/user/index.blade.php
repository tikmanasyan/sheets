@extends("layouts.app")
@section('title')Users
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{route("create-user")}}" class="btn btn-primary">Create New User</a>
                <h3>USER LIST</h3>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>IP</th>
                            <th>Link</th>
                            <th>Comments</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < count($users); $i++)
                            <tr>
                                <td>{{$i + 1}}</td>
                                <td>{{$users[$i]['first_name']}}</td>
                                <td>{{$users[$i]['last_name']}}</td>
                                <td>{{$users[$i]['email']}}</td>
                                <td>{{$users[$i]['phone']}}</td>
                                <td>{{$users[$i]['ip']}}</td>
                                <td>{{$users[$i]['link']}}</td>
                                <td>{{$users[$i]['comments']}}</td>
                                <td>{{$users[$i]['created_at']}}</td>
                                <td><a href="{{route("edit-user", $users[$i]['id'])}}" class="btn btn-success">Edit</a></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
