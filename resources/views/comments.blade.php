@extends('layouts.masterlayout')

@section('title')
    Comments
@endsection

@section('content')
<style>
    .page-link {
    position: relative;
    display: block;
    color: #D6EFD8;
    text-decoration: none;
    background-color: #1A5319;
    border: 1px solid #dee2e6;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.page-link:hover {
    z-index: 2;
    color: #D6EFD8;
    background-color: #508D4E;
    border-color: #dee2e6;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #113520;
    border-color: #D6EFD8;
}
.page-item.disabled .page-link {
    color: #D6EFD8;
    pointer-events: none;
    background-color: #1A5319;
    border-color: #dee2e6;
}
</style>
<div class="container-fluid px-0" style="background-color: #D6EFD8;">
    <div class="row px-5" style="background-color: #D6EFD8; height: 100vh;">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-10">
                    <h1 class="fw-bold">All Comments</h1>
                </div>
                <div class="col-2">
                    <a href="{{route('dashboard')}}">Home</a> \ Comments
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

                <div class="col-12">
                    <div class="table-responsive">
                        <table id="example" style="width:100%" class="display">
                            <thead>
                                <tr>
                                    <th scope="col" >S.No</th>
                                    <th scope="col" >Author</th>
                                    <th scope="col" >Comment</th>
                                    <th scope="col" >Email</th>
                                    <th scope="col" >Post Title</th>
                                    <th scope="col" class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($comments)
                                    
                                @foreach  ($comments as $key => $comment) 
                                    <tr>
                                        <td>{{$comment->id}}</td>
                                        <td>{{$comment->author}}</td>
                                        <td>
                                            <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                                {{$comment->comment}}
                                            </span>
                                        </td>
                                        <td>{{$comment->email}}</td>
                                        <td>{{$comment->post->title}}</td>
                                        {{-- <td class="text-center">
                                            <img src="{{ asset($userPost->image) }}" width="50px" alt="">
                                        </td> --}}
                                        {{-- <td class="text-center">
                                            <span>{{$userPost->user->name}} <br> {{$userPost->user->role}}</span>
                                        </td> --}}
                                        {{-- <td class="text-center">
                                            <a href="{{route('post.show',$userPost->id)}}" class="btn btn-success d-inline-block btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mb-2 mx-2">View</a>
                                        </td> --}}
                                        {{-- <td class="text-center">
                                            <a href="{{route('post.edit',$userPost->id)}}" class="btn btn-warning btn-xl btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mb-2 mx-2">Edit</a>
                                        </td> --}}
                                        @if (Auth::user()->role == 'admin')
                                            <td class="text-center">
                                                <form action="{{route('destroyComment',$comment->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xl btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mx-2">Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach                      
                                @else
                                    <tr>
                                        <td class="text-secondary">
                                            <span>No Record</span>
                                        </td>
                                        <td class="text-secondary">
                                            <span>No Record</span>
                                        </td>
                                        <td class="text-secondary">
                                            <span>No Record</span>
                                        </td>
                                        <td class="text-secondary">
                                            <span>No Record</span>
                                        </td>
                                        <td class="text-secondary">
                                            <span>No Record</span>
                                        </td>
                                        <td class="text-secondary text-center">
                                            <span>No Record</span>
                                        </td>
                                        
                                    </tr>   
                                @endisset   
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{-- {{ $comments->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
