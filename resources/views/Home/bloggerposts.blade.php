@extends('Home.layouts.homemasterlayout')




@section('header')
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center">
                <img src="{{asset($user->profile)}}" style="object-fit: cover; width: 100px; height: 100px;" class="rounded-circle shadow" alt="">
                <h1 class="fw-bolder">{{$user->name}}</h1>
                <span class="text-muted">Followers {{$user->followers()->count()}}</span>
                <p class="lead mb-2">Welcome to {{$user->name}} Blogs, read more to make yourself valuable. </p>
                @auth
                    @if ($user->isFollowing(Auth::user()))
                        <form action="{{ route('unFollowUser',$user->id) }}" method="POST" class="">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn primaryBtn btn-md">Unfollow</button>
                        </form>
                    @else
                        <form action="{{route('followUser',$user->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn primaryBtn btn-md">Follow</button>
                        </form>
                    @endif
                @endauth
                {{-- <button class="btn primaryBtn">Follow</button> --}}
            </div>
        </div>
    </header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                {{-- <div class="card-header">Search</div> --}}
                <div class="card-body">
                    <form action="{{route('search')}}" method="post">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." name="search" aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn primaryBtn" id="button-search" type="submit">Go!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-12">
            <h3 class="mb-0">All Blogs</h3>
            <hr>
        </div>
        <div class="col-lg-12">
            {{-- All posts --}}
            <div class="row">
                @isset($posts)
                    @forelse ($posts as $post)
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <a href="{{route('blogposts',$post->id)}}"><img class="card-img-top" src="{{asset($post->image)}}" width="700px" height="350px" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{$post->created_at->diffForHumans()}}</div>
                                    <h2 class="card-title h4">{{$post->title}}</h2>
                                    <p class="card-text text-truncate" style="max-width: 200px; ">{!!html_entity_decode($post->description)!!}</p>
                                    <a class="btn primaryBtn" href="{{route('blogposts',$post->id)}}">Read more →</a>
                                </div>
                            </div>
                        </div>   
                    @empty
                        <div class="col-12">
                            <h4>Not Found</h4>
                        </div>
                    @endforelse              
                @else
                <div class="col-12">
                    <h4>No posts available</h4>
                </div>
                @endisset
            </div>
            
            <!-- Pagination-->
            {{-- <nav aria-label="Pagination">
                <hr class="my-0" />
                @isset($posts)
                    
                    {{$posts->links('pagination::bootstrap-5')}}
                    
                @endisset
            </nav> --}}
        </div>
        
    </div>
</div>
@endsection
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
       $('.owl-carousel').owlCarousel({
           autoplay: true,
           autoplayTimeout: 2000,
           autoplayHoverPause: true,
           loop: true,
           dots: true,
           margin: 10,
           nav: true,
           items: 10 // Adjust as needed
       });
   });
</script>