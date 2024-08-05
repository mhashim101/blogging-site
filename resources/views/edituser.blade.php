@extends('layouts.masterlayout')

@section('title')
    All Posts
@endsection

@section('content')

<div class="container-fluid px-0" style="background-color: #D6EFD8;">
    <div class="row px-5" style="background-color: #D6EFD8; height: 100vh;">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-10">
                    <h1 class="fw-bold">All Users</h1>
                </div>
                <div class="col-2">
                    <a href="{{route('dashboard')}}">Home</a> \ <a href="{{route('allusers')}}">Users</a> \ Edit
                </div>
                <hr class="w-100">
            </div>
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="col-12 shadow p-3 mb-5 rounded" style="background-color: #508d4e;">                                    
                    <form action="{{route('updateUser',$user->id)}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control shadow p-3 bg-body rounded" id="name" aria-describedby="emailHelp" name="name" placeholder="Name" value="{{$user->name}}">
                                  </div>
                                  <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control shadow p-3 bg-body rounded" id="userEmail" aria-describedby="emailHelp" name="email" placeholder="Email" value="{{$user->email}}">
                                  </div>    
                            </div>    
                            <div class="col-md-3">
                                {{-- {{asset($user->profile)}} --}}
                                <img src="{{asset($user->profile)}}" class="img-fluid d-block m-auto img-thumbnail shadow" style="width: 200px !important; height: 200px !important;" alt="user profile">    
                            </div>    
                        </div>
                        
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select shadow p-3 bg-body rounded" id="usreRole" aria-label="Default select example" name="role">
                                <option {{$user->role == 'admin' ? 'SELECTED' : ''}} value="admin">Admin</option>
                                <option {{$user->role == 'vendor' ? 'SELECTED' : ''}} value="vendor">Vendor</option>
                                <option {{$user->role == 'user' ? 'SELECTED' : ''}} value="user">User</option>
                              </select>
                        </div>
                        <div class="mb-3">
                          <label for="userProfile" class="form-label">Profile</label>
                          <input type="file" class="form-control shadow p-3 bg-body rounded" id="userProfile" aria-describedby="emailHelp" name="profile" value="{{$user->profile}}">
                        </div>
                        <button type="submit" class="btn primaryBtn shadow bg-body rounded">Update</button>
                      </form>
                      @if($errors->any())
                      <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                        </div>
                      @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


