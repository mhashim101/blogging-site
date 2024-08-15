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
            <!-- Featured blog post-->
            @if (isset($latestPost))
                <div class="card mb-4">
                    <a href="#!"><img class="card-img-top" src="{{asset($latestPost->image)}}" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted">{{$latestPost->created_at->diffForHumans()}}</div>
                        <h2 class="card-title">{{$latestPost->title}}</h2>
                        <p class="card-text">{!!html_entity_decode($latestPost->description)!!}</p>
                        <a href="{{route('blogposts',$latestPost->id)}}" class="btn primaryBtn">Read more →</a>
                    </div>
                </div>
            @else
                <div class="card mb-4">
                    <a href="#!"><img class="card-img-top" src="https://dummyimage.com/850x350/dee2e6/6c757d.jpg" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted">January 1, 2023</div>
                        <h2 class="card-title">Featured Post Title</h2>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                        <a class="btn primaryBtn" href="">Read more →</a>
                    </div>
                </div>
            @endif
           
            
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                @isset($posts)
                    
                    @foreach ($posts as $post)
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="{{asset($post->image)}}" width="700px" height="350px" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{$post->created_at->diffForHumans()}}</div>
                                    <h2 class="card-title h4">{{$post->title}}</h2>
                                    <p class="card-text text-truncate" style="max-width: 200px; ">{!!html_entity_decode($post->description)!!}</p>
                                    <a class="btn primaryBtn" href="{{route('blogposts',$post->id)}}">Read more →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        
                @else
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted">January 1, 2023</div>
                                <h2 class="card-title h4">Post Title</h2>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla.</p>
                                <a class="btn primaryBtn" href="#!">Read more →</a>
                            </div>
                        </div>
                    </div> 
                @endisset
                    <!-- Blog post-->
                    {{-- <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted">January 1, 2023</div>
                            <h2 class="card-title h4">Post Title</h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla.</p>
                            <a class="btn primaryBtn" href="#!">Read more →</a>
                        </div>
                    </div> --}}
                {{-- </div> --}}
                {{-- <div class="col-lg-6">
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted">January 1, 2023</div>
                            <h2 class="card-title h4">Post Title</h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla.</p>
                            <a class="btn primaryBtn" href="#!">Read more →</a>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted">January 1, 2023</div>
                            <h2 class="card-title h4">Post Title</h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam.</p>
                            <a class="btn primaryBtn" href="#!">Read more →</a>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!-- Pagination-->
            <nav aria-label="Pagination">
                <hr class="my-0" />
                @isset($posts)
                    
                    {{$posts->links('pagination::bootstrap-5')}}
                    
                @endisset
                {{-- <ul class="pagination justify-content-center my-4">
                    <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                    <li class="page-item"><a class="page-link" href="#!">2</a></li>
                    <li class="page-item"><a class="page-link" href="#!">3</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                    <li class="page-item"><a class="page-link" href="#!">15</a></li>
                    <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                </ul> --}}
            </nav>
        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Search widget-->
            <div class="card mb-4">
                <div class="card-header">Search</div>
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