@extends('layouts.masterlayout')

@section('title')
    All Posts
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
            <div class="row shadow p-3 mt-3 mb-5 rounded" style="background-color: #508d4e;">
                <div class="col-10">
                    <h1 class="fw-bold mb-0">All Posts</h1>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <a href="{{route('dashboard')}}">Home</a> \ Followers
                </div>
                {{-- <hr class="w-100"> --}}
            </div>
            <div class="row shadow p-3 mb-5 rounded" style="background-color: #508d4e;">
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
                                    <th scope="col" >Name</th>
                                    <th scope="col" >Profile</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($followers as $follower)
                                    <tr>
                                        <td>{{$follower->id}}</td>
                                        <td>{{$follower->name}}</td>
                                        <td><img src="{{asset($follower->profile)}}" alt="follower image" style="object-fit: cover; width: 50px; height: 50px;"></td>
                                    </tr>                      
                                @empty
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
                                    </tr>  
                                @endforelse      
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
