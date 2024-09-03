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
            {{-- search results --}}
            <div class="row">
                @isset($searchResults)
                    @forelse ($searchResults as $result)
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="{{asset($result->image)}}" width="700px" height="350px" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{$result->created_at->diffForHumans()}}</div>
                                    <h2 class="card-title h4">{{$result->title}}</h2>
                                    {{-- <p class="card-text text-truncate" style="max-width: 200px; ">{!!html_entity_decode($result->description)!!}</p> --}}
                                    <p class="card-text text-truncate" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {!! strip_tags(html_entity_decode($result->description)) !!}
                                    </p>
                                    <a class="btn primaryBtn" href="{{route('blogposts',$result->id)}}">Read more →</a>
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
                    <h4>No search results available</h4>
                </div>
                @endisset
            </div>
            
            <!-- Pagination-->
            <nav aria-label="Pagination">
                <hr class="my-0" />
                @isset($posts)
                    
                    {{$searchResults->links('pagination::bootstrap-5')}}
                    
                @endisset
            </nav>
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