@extends('layouts.masterlayout')

@section('title')
    Delete Post
@endsection

@section('content')
    <div class="container-fluid px-0" style="background-color: #D6EFD8; height: 100%;">
        <div class="row px-5" style="background-color: #D6EFD8; height: 100%;">
            <div class="col-12">
                <div class="row shadow p-3 mt-3 mb-5 rounded" style="background-color: #508d4e;">
                    <div class="col-10">
                        <h1 class="fw-bold mb-0">Delete Post By Id</h1>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="{{ route('dashboard') }}">Home</a> <span>\ Delete Post</span>
                    </div>
                    {{-- <hr class="w-100"> --}}
                </div>
                <div class="row shadow p-3 mb-5 rounded" style="background-color: #508d4e;">
                    <div class="col-12">
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
                        <form action="{{ route('showPostOnDelete') }}" method="GET"
                            class="addPost d-flex justify-content-start align-items-end">
                            @csrf
                            <div class="me-sm-5 me-1">
                                <label for="postId" class="form-label mb-0">Post Id</label>
                                <input type="number" class="form-control mb-0 shadow p-2 bg-body rounded" id="postId" name="id">
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-xl btn-lg btn-md btn-sm primaryBtn shadow p-2 bg-body rounded"
                                    style="background-color: #1A5319;">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row shadow p-3 mb-5 rounded" style="background-color: #508d4e;">

                    @isset($post)
                        <div class="col-md-12">
                            <form action="" enctype="multipart/form-data" method="post"
                                class="addPost mb-5">
                                @csrf
                                {{-- @method('DELETE') --}}
                                <div class="mb-3">
                                    <label for="adminPost" class="form-label">Post Title</label>
                                    <input type="text" class="form-control shadow p-3 bg-body rounded" id="adminPost" name="title"
                                        value="{{ $post->title }}">
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="postDec" class="form-label">Post Description</label>
                                    <textarea id="mytextarea" name="description" class="form-control shadow p-3 bg-body rounded" id="postDec" rows="10" columns="20">{!! html_entity_decode( $post->description) !!}</textarea>
                                </div> --}}
                                <div class="mb-3">
                                    <label for="postOldImg" class="form-label">Post Image</label>
                                    <img src="{{ asset($post->image) }}" id="postOldImg" class="form-control" style="object-fit: cover; width: 400px; height: 400px;" alt="">
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="postImg" class="form-label">Post Title</label>
                                    <input type="file" name="image" class="form-control shadow p-3 bg-body rounded" id="postImg">
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-md primaryBtn"
                                        style="background-color: #1A5319;">Delete</button>
                                </div> --}}
                            </form>
                            <form action="{{route('post.destroy',$post->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-md primaryBtn shadow p-3 bg-body rounded"
                                        style="background-color: #1A5319;">Delete</button>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        {{-- <div class="col-sm-6 col-12">
                            <img src="{{ asset($post->image) }}" class="img-fluid" alt="">
                        </div> --}}
                    @else
                        <div class="col-md-6 col-12">

                            <form action="" enctype="multipart/form-data" method="post" class="addPost mb-5">
                                @csrf
                                <div class="mb-3">
                                    <label for="adminPost" class="form-label">Post Title</label>
                                    <input type="text" class="form-control shadow p-3 bg-body rounded" id="adminPost" name="title">
                                </div>
                                <div class="mb-3">
                                    <label for="postDec" class="form-label">Post Description</label>
                                    <textarea id="mytextarea" name="description" class="form-control shadow p-3 bg-body rounded" id="postDec" rows="10" columns="20"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="postImg" class="form-label">Post Title</label>
                                    <input type="file" name="image" class="form-control shadow p-3 bg-body rounded" id="postImg">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-md primaryBtn shadow p-3 bg-body rounded"
                                        style="background-color: #1A5319;">Delete</button>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
