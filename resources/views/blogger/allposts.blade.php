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
                    <a href="{{route('dashboard')}}">Home</a> \ View Posts
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
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('addpost')}}" class="btn primaryBtn" >Add New</a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="example" style="width:100%" class="display">
                            <thead>
                                <tr>
                                    <th scope="col" >S.No</th>
                                    <th scope="col" >Post Title</th>
                                    {{-- <th scope="col" >Post Description</th> --}}
                                    <th scope="col" >Category</th>
                                    <th scope="col" class="text-center">Post Image</th>
                                    <th scope="col" class="text-center">Post By</th>
                                    <th scope="col" class="text-center">View</th>
                                    <th scope="col" class="text-center">Edit</th>
                                    @if (Auth::user()->role == 'admin')
                                        <th scope="col" class="text-center">Delete</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $userPost)
                                    <tr>
                                        <td>{{$userPost->id}}</td>
                                        <td>{{$userPost->title}}</td>
                                        {{-- <td>
                                            <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                                {!!html_entity_decode($post->description)!!}
                                            </span>
                                        </td> --}}
                                        <td>{{$userPost->category->name}}</td>
                                        <td class="text-center">
                                            <img src="{{ asset($userPost->image) }}" width="50px" alt="">
                                        </td>
                                        <td class="text-center">
                                            {{-- @foreach ($userPost->user_id as $user_role)
                                                <p>{{ $user_role->role }}</p>
                                            @endforeach --}}
                                            <span>{{$userPost->user->name}} <br> {{$userPost->user->role}}</span>
                                        </td>
                                        <td class="text-center">
                                            {{-- {{$userPost->id}} --}}
                                            <a href="{{route('viewpost',$userPost->id)}}" class="btn btn-success d-inline-block btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mb-2 mx-2">View</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('post.edit',$userPost->id)}}" class="btn btn-warning btn-xl btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mb-2 mx-2">Edit</a>
                                        </td>
                                        {{-- @if (Auth::user()->role == 'admin') --}}
                                            <td class="text-center">
                                                <form action="{{route('post.destroy',$userPost->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xl btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mx-2">Delete</button>
                                                </form>
                                            </td>
                                        {{-- @endif --}}
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
                                        <td  class="text-secondary text-center">
                                            <span>No Record</span>
                                        </td>
                                        <td  class="text-secondary text-center">
                                            <span>No Record</span>
                                        </td>
                                        <td  class="text-secondary text-center">
                                            <span>No Record</span>
                                        </td>
                                        <td  class="text-secondary text-center">
                                            <span>No Record</span>
                                        </td>
                                        <td  class="text-secondary text-center">
                                            <span>No Record</span>
                                        </td>
                                    </tr>  
                                @endforelse      
                            </tbody>
                        </table>
                    </div>
                    {{-- <div>
                        {{ $post->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 75, 100],
            "order": [[ 3, "desc" ]]
        });
    });
</script> --}}