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


<style>

  .card {
    border-radius: 1rem;
    background-color: rgba(31, 41, 55, 1);
    padding: 1rem;
  }
  
  .infos {
    display: flex;
    flex-direction: column;
    align-items: center;
    grid-gap: 1rem;
    gap: 1rem;
  }
  
  .image {
    height: 7rem;
    width: 7rem;
    border-radius: 0.5rem;
    background-color: rgb(118, 36, 194);
    background: linear-gradient(to bottom right, rgb(16, 100, 30), rgb(49, 157, 58));
  }
  
  .image img{
      object-fit: cover;
      height: 7rem;
      width: 7rem;
  }
  
  .info {
    height: 7rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .name {
    font-size: 1.25rem;
    line-height: 1.75rem;
    font-weight: 500;
    color: #1A5319;
  }
  
  .function {
    font-size: 0.75rem;
    line-height: 1rem;
    color: rgba(156, 163, 175, 1);
  }
  
  .stats {
    width: 100%;
    border-radius: 0.5rem;
    background-color: rgba(255, 255, 255, 1);
    padding: 0.5rem;
    /* display: flex;
    align-items: center;
    justify-content: space-between; */
    font-size: 1rem;
    line-height: 1rem;
    color: rgba(0, 0, 0, 1);
  }
  
  .flex {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 4px;
  }
  
  .state-value {
    font-weight: 700;
    color: #1A5319;
    margin-bottom: 4px;
  }
  
  .request {
    margin-top: 1.5rem;
    width: 100%;
    border: 1px solid transparent;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    line-height: 1.5rem;
    transition: all .3s ease;
  }
  
  .request:hover {
    background-color: #1A5319;
    color: #fff;
  }
  
  </style>


@section('content')
<div class="container">
    <div class="row mb-5">
        @isset($bloggers)
            @foreach ($bloggers as $blogger)
            {{-- {{$blogger}} --}}
                <div class="col-md-4">
                  <div class="card shadow p-5">
                      <div class="row text-center">
                        <div class="col-12 mb-3">
                          <img src="{{asset($blogger->profile)}}" class="rounded-circle shadow border border-4" style="object-fit: cover; height: 7rem; width: 7rem;" alt="">
                        </div>
                        <div class="col-12 mb-3">
                          <h4 class="mb-2"><a href="{{route('bloggerposts',$blogger->id)}}" class="text-decoration-none">{{$blogger->name}}</a></h4>
                          <p class="mb-0 text-muted">{{$blogger->role}}</p>
                        </div>
                        <div class="col-md-6 mb-3 stats ps-5">
                          <p class="mb-1">Articles</p>
                          <span class="state-value"> 
                              @php
                                  $count = 0;
                              @endphp
                              @isset($posts)
                                  @foreach ($posts as $post)
                                      @if ($post->user_id == $blogger->id)
                                          @php
                                              $count++;
                                          @endphp
                                      @endif
                                  @endforeach
                                  {{$count}}
                              @endisset
                          </span>
                        </div>
                        <div class="col-md-6 mb-3 stats pe-5">
                          <p class="mb-1">Followers</p>
                          <span class="state-value"> {{$blogger->followers()->count()}}</span>
                        </div>
                        @auth
                            @if ($blogger->isFollowing(Auth::user()))
                            <form action="{{ route('unFollowUser',$blogger->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn primaryBtn btn-md w-100">Unfollow</button>
                            </form>
                            @else
                            <form action="{{route('followUser',$blogger->id)}}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn primaryBtn btn-md w-100">Follow</button>
                            </form>
                            @endif
                        @endauth
                      </div>
                  </div>
              </div>
            @endforeach    
        @endisset
    </div>
</div>
@endsection