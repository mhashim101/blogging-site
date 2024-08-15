@extends('layouts.masterlayout')

@section('title')
    Add Post
@endsection

@section('content')
<div class="container-fluid px-0" style="background-color: #D6EFD8; ">
    <div class="row px-5" style="background-color: #D6EFD8;">
        <div class="col-12">
            <div class="row shadow p-3 mt-3 mb-5 rounded" style="background-color: #508d4e;">
                <div class="col-10">
                    <h1 class="fw-bold mb-0">Add New Post</h1>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <a href="{{route('dashboard')}}">Home</a> \ <span>Add Post</span>
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
                    <form action="{{route('post.store')}}" enctype="multipart/form-data"  method="post" class="addPost mb-5">
                        @csrf
                        <div class="mb-3">
                            <input type="number" hidden value="{{ Auth::id() }}" name="user_id">
                            <label for="adminPost" class="form-label">Post Title</label>
                            <input type="text" class="form-control shadow p-3 bg-body rounded" id="adminPost" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="postDec" class="form-label">Post Description</label>
                            {{-- <div id="editor"></div> --}}
                            <textarea id="mytextarea" name="description" class="form-control shadow bg-body rounded" id="postDec" rows="10" columns="20"></textarea>

                           
                            {{-- <textarea name="description" class="form-control" id="postDec" rows="10" columns="20"></textarea> --}}
                        </div>
                        <div class="mb-3">
                            
                                <label for="floatingSelect" class="form-label">Categories</label>
                                <select class="form-select shadow p-3 bg-body rounded" id="floatingSelect" name="category_id"  aria-label="Floating label select example">
                                    <option selected hidden>Select Category</option>
                                    @forelse ($categories as $category)
                                        <option value="{{$category->id}}" class="shadow p-3 bg-body rounded">{{$category->name}}</option>
                                    @empty
                                        <option class="text-secondary shadow p-3 bg-body rounded">No Category Available</option>    
                                    @endforelse
                                </select>
                    
                        </div>
                        <div class="mb-3">
                            <label for="postImg" class="form-label">Post Image</label>
                            <input type="file" name="image" class="form-control shadow p-3 bg-body rounded" id="postImg">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn primaryBtn btn-md shadow p-3 bg-body rounded" style="background-color: #1A5319;">Publish</button>
                        </div>
                    </form>
                </div>
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
        </div>
    </div>
</div>
@endsection


