@extends('Home.layouts.homemasterlayout')




@section('header')
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">MH Blogging Site</h1>
                <p class="lead mb-0">Welcome to MH Blogs, read more to make yourself valuable. </p>
            </div>
        </div>
    </header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-12">
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
            <!-- Latest blog posts-->
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Latest Blogs</h3>
                    <hr>
                </div>
            </div>
            <div class="row">
                @isset($latestPost)
                    @foreach ($latestPost as $post)
                        <div class="col-lg-3">
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="{{asset($post->image)}}" width="700px" height="250px" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{$post->created_at->diffForHumans()}}</div>
                                    <h2 class="card-title h4 text-truncate mb-2" style="max-width: 300px;">{{$post->title}}</h2>
                                    {{-- <p class="card-text text-truncate" style="max-width: 200px; ">{{$post->description}}</p> --}}
                                    <a class="btn primaryBtn" href="{{route('blogposts',$post->id)}}">Read more →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        
                @else
                    <div class="col-lg-4">
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
            </div>

            <!--Blog posts category-->
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Blog Category</h3>
                    <hr>
                </div>
            </div> 
           <div class="row mb-5">
            <div class="col-md-12">
                @isset($categories)
                    <div class="owl-carousel">
                        @foreach ($categories as $category)
                                <div class="item text-center">
                                    <a href="{{route('postByCategory',$category->id)}}" class="text-decoration-none h4" style="font-weight: bold;">{{$category->name}}
                                </div>
                        @endforeach
                    </div>
                @else 
                    <h4>No Category Found</h4>
                @endisset    
            </div>
           </div>
           
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                @isset($posts)
                    @foreach ($posts as $post)
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="{{asset($post->image)}}" width="700px" height="350px" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{$post->created_at->diffForHumans()}}</div>
                                    <h2 class="card-title h4">{{$post->title}}</h2>
                                    {{-- <p class="card-text text-truncate" style="max-width: 200px; ">{!!html_entity_decode($post->description)!!}</p> --}}
                                    <p class="card-text text-truncate" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {!! strip_tags(html_entity_decode($post->description)) !!}
                                    </p>
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
            </div>
            <!-- Pagination-->
            <nav aria-label="Pagination">
                <hr class="my-0" />
                @isset($posts)
                    
                    {{$posts->links('pagination::bootstrap-5')}}
                    
                @endisset
            </nav>
        </div>
        <!-- Side widgets-->
        {{-- <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn primaryBtn" id="button-search" type="button">Go!</button>
                    </div>
                </div>
            </div>
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
            <div class="card mb-4">
                <div class="card-header">Side Widget</div>
                <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
            </div>
        </div> --}}
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