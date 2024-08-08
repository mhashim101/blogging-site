@extends('Home.layouts.homemasterlayout')


@section('header')
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
            </div>
        </div>
    </header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">        
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                @isset($posts)
                    @forelse ($posts as $post)
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <img class="card-img-top" src="{{asset($post->image)}}" width="700px" height="350px" alt="..." />
                            <div class="card-body">
                                <div class="small text-muted">{{$post->created_at->diffForHumans()}}</div>
                                <h2 class="card-title h4">{{$post->title}}</h2>
                                <p class="card-text text-truncate" style="max-width: 200px; ">{{$post->description}}</p>
                                <a class="btn primaryBtn" href="{{route('blogposts',$post->id)}}">Read more →</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-6">
                        <h2 class="card-title h4">No post available.</h2>
                    </div> 
                    @endforelse                        
                @endisset
            </div>
        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="row">
                        @isset($categories)
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($categories as $item)
                                        <li><a href="{{route('postByCategory',$item->id)}}">{{$item->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @else 
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">Web Design</a></li>
                                <li><a href="#!">HTML</a></li>
                                <li><a href="#!">Freebies</a></li>
                            </ul>
                        </div>   
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">JavaScript</a></li>
                                <li><a href="#!">CSS</a></li>
                                <li><a href="#!">Tutorials</a></li>
                            </ul>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
            <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header">Side Widget</div>
                <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
            </div>
        </div>
    </div>
</div>
@endsection