@extends('layouts.masterlayout')

@section('title')
    Update Post
@endsection

@section('content')
<div class="container-fluid px-0" style="background-color: #D6EFD8;">
    <div class="row px-5" style="background-color: #D6EFD8; height: 100vh;">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-10">
                    <h1 class="fw-bold">Update Post</h1>
                </div>
                <div class="col-2">
                    <a href="{{route('dashboard')}}">Home</a> \ Update Post
                </div>
                <hr class="w-100">
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
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
                    <form action="{{route('post.update',$post->id)}}" enctype="multipart/form-data" method="post" class="addPost mb-5">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="adminPost" class="form-label">Post Title</label>
                            <input type="text" class="form-control" id="adminPost" name="title" value="{{$post->title}}">
                        </div>
                        <div class="mb-3">
                            <label for="postDec" class="form-label">Post Description</label>
                            <textarea name="description" class="form-control" id="postDec" rows="10" columns="20">{!!html_entity_decode($post->description)!!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingSelect" class="form-label">Categories</label>
                            <select class="form-select" id="floatingSelect" name="category_id"  aria-label="Floating label select example">
                                <option selected hidden>{{$post->category->name}}</option>
                                @forelse ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @empty
                                    <option class="text-secondary">No Category Available</option>    
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="postImg" class="form-label">Post Title</label>
                            <input type="file" name="image" class="form-control" id="postImg">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-md primaryBtn" style="background-color: #1A5319;">Update</button>
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
                <div class="col-sm-6 col-12">
                    <img src="{{asset($post->image)}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection