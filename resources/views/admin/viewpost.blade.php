@extends('layouts.masterlayout')

@section('title')
    View Post
@endsection
<style>
    .dropdown-menu li a:hover,
    .dropdown-menu li form button:hover {
        background-color: #508D4E;
        color: #D6EFD8;

    }

    .dropstart:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        /* Remove the margin so it aligns properly */
    }
    .dropdown-menu {
    min-width: 5rem !important;
    padding: .5rem 0 !important;
    font-size: 0.9rem !important;
}
.editComment{
    display: none;
}
.comment-section{
    display: none;
}
</style>

@section('content')
    <div class="container-fluid px-0" style="background-color: #D6EFD8;">
        <div class="row px-5" style="background-color: #D6EFD8;">
            <div class="col-12">
                <div class="row mt-4">
                    <div class="col-md-9 col-sm-6 col-8">
                        <h1 class="fw-bold">All Posts</h1>
                    </div>
                    <div class="col-md-3 col-sm-6 col-4 text-end">
                        <a href="{{ route('dashboard') }}">Home</a>
                        <a href="{{ route('post.index') }}">\View Posts</a>
                        <span>\ View</span>
                    </div>
                    <hr class="w-100" />
                </div>
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
                <div class="row d-flex justify-content-center align-items-center">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="col-lg-8 col-md-9 col-12">
                        {{-- <div class="card mb-5" style="width: 100%; background-color: #508D4E;"> --}}
                        <div class="card mb-5" style="width: 100%; background-color: #508D4E;">
                            <div class="card-header">
                                <div class="row py-2">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div
                                                class="col-lg-2 mb-lg-0 mb-md-2 col-sm-12 justify-content-lg-end align-items-center">
                                                <div class="border border-5 image-box rounded-circle">
                                                    <img src="{{ asset($post->user->profile) }}" alt="">
                                                </div>
                                            </div>
                                            <div
                                                class="col-lg-10 col-sm-12 d-flex flex-column justify-content-center align-items-start">
                                                <h4 class="text-start d-block ml-2 mb-0">{{ $post->user->name }}</h4>
                                                <span class="text-start d-block ml-lg-2">{{ $post->user->role }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-start align-items-center"
                                        style="position: relative;">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle dropdown-toggle-split"
                                                style="font-size: 25px;" type="button" id="dropdownMenuButton2"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                            </button>
                                            <ul class="dropdown-menu" style="background-color: rgb(26, 83, 25);"
                                                aria-labelledby="dropdownMenuButton2">
                                                <li>
                                                    <a class="dropdown-item text-white"
                                                        href="{{ route('post.edit', $post->id) }}">Edit</a>
                                                </li>
                                                @if (Auth::user()->role == 'admin')
                                                    <li>
                                                        <form action="{{ route('post.destroy', $post->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="dropdown-item text-white">Delete</button>
                                                        </form>
                                                        {{-- <a class="dropdown-item text-white" href="#">Delete</a> --}}
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-white">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{!!html_entity_decode($post->description)!!}</p><br>
                                
                               
                                <p class="card-text"> <span class="text-light">Category: </span><strong
                                        class="border-2 rounded">{{ $post->category->name }}</strong></p>
                                @if ($post->image != '')
                                    <div class="w-100 d-block">
                                        <img src="{{ asset($post->image) }}" class="card-img-top" width="400px"
                                            height="600px" alt="...">
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row d-flex justify-content-around text-align-center px-1 py-2">
                                    <div class="col-md-4">
                                        @php
                                        $userHasLiked = $post->like->contains('user_id', Auth::user()->id);
                                        @endphp
        
                                        @if ($userHasLiked)
                                            <form action="{{ route('dislike', $post->id) }}" class="d-inline" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 fs-5 text-primary" style="background-color:#508D4E;">
                                                    Like
                                                    {{-- <img src="{{ asset('img/like.png') }}" width="40px" height="40px" alt="Dislike"> --}}
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('like', $post->id) }}" class="d-inline" method="POST">
                                                @csrf
                                                <button type="submit" class="border-0 fs-5" style="background-color:#508D4E;">
                                                    Like
                                                    {{-- <img src="{{ asset('img/dislike.png') }}" width="40px" height="40px" alt="Like"> --}}
                                                </button>
                                            </form>
                                        @endif
                                        <span class="d-inline">{{ $post->like->count() }} likes</span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button class="border-0 fs-5" style="background-color:#508D4E;" id="CommentSection">Comments</button>
                                       <span class="d-inline">{{ $post->comment->count() }} likes</span>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <button class="border-0 fs-5" style="background-color:#508D4E;" onclick="copyCurrentUrl()">Share</button>
                                        <span class="d-inline">{{ $post->like->count() }} likes</span>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-around text-align-center"> 
                                    <div class="col-m-12">
                                        <div class="comment-section" id="comment-section" style="">
                                            <div class="comment" id="comment-1">
                                                @isset($post)
                                                     

                                                    @forelse ($post->comment as $comment)
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <div id="comment-{{$comment->id}}">
                                                                    <div class="comment-user">
                                                                        {{$comment->user->name}}
                                                                        @if($comment->user->role == 'blogger')
                                                                        <span class="text-secondary" style="font-size: 12px;">author</span>
                                                                        @endif
                                                                    </div>
                                                                    <div id="comment-text-{{$comment->id}}" class="comment-text">{{$comment->body}}</div>
                                                                </div>
                                                                <div id="edit-comment-form-{{$comment->id}}" class="editComment">
                                                                    <form action="{{route('updateComment')}}" method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="text" name="body">
                                                                        <input type="hidden" name="$post_id" value="{{$comment->post_id}}">
                                                                        <input type="hidden" name="user_id" value="{{$comment->user->id}}">
                                                                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                                        <button type="submit" class="btn primaryBtn fs-7 btn-sm">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="dropdown">
                                                                    <button style="border: none;" class="bg-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                        <li><button class="dropdown-item fs-7" onclick="editComment('edit-comment-form-{{$comment->id}}','comment-{{$comment->id}}','comment-text-{{$comment->id}}')">Edit</button></li>
                                                                        <li>
                                                                            <form action="{{route('deleteComment',$comment->id)}}" method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-xl btn-lg btn-md btn-sm mb-md-0 mb-sm-2 mx-2">Delete</button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="comment-actions">
                                                            <button class="reply-btn" onclick="toggleReplyForm('reply-form-{{$comment->id}}')">Reply</button>
                                                        </div>
                                                        <hr class="p-0 m-0">
                                                        <div class="reply-form" id="reply-form-{{$comment->id}}">
                                                            <form action="{{route('storeReply')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" placeholder="Write a reply..." class="reply-input" name="comment_id" value="{{$comment->id}}">
                                                                <input type="hidden" placeholder="Write a reply..." class="reply-input" name="reply_id"> 
                                                                <input type="hidden" placeholder="Write a reply..." class="reply-input" name="post_id" value="{{$comment->post_id}}">
                                                                <input type="text" placeholder="Write a reply..." class="reply-input" name="body">
                                                                <button type="submit" class="send-reply-btn" >Send</button>
                                                            </form>
                                                        </div>
                                                        @foreach ($comment->replies as $reply)
                                                            @if ($comment->id === $reply->comment_id)
                                                                <div class="replies" id="replies-comment-1">
                                                                    <div class="reply" id="comment-1-{{$reply->id}}">
                                                                        <div class="comment-user">{{$reply->user->name}}</div>
                                                                        <div class="comment-text">{{$reply->body}}</div>
                                                                        <div class="comment-actions">
                                                                            <button class="reply-btn" onclick="toggleReplyForm('reply-form-comment-1-{{$reply->id}}')">Reply</button>
                                                                        </div>                                                                      
                                                                        <div class="replies" id="replies-comment-1-{{$reply->id}}">
                                                                            <div class="reply-form" id="reply-form-comment-1-{{$reply->id}}">
                                                                                <form action="{{route('storeReply')}}" method="post">
                                                                                    @csrf
                                                                                    <input type="text" placeholder="Write a reply..." class="reply-input" name="body">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="user_id">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="post_id" value="{{$comment->post_id}}">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="comment_id" value="{{$reply->comment_id}}">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="reply_id" {{$reply->id}}>
                                                                                    <button type="submit" class="send-reply-btn" >Send</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            @endif
                                                        @endforeach
                                                    
                                                    @empty
                                                        {{-- <div class="comment-user">User</div> --}}
                                                        <div class="comment-text">No comments</div>
                                                    @endforelse
                                                @endisset
                                            </div>
                                    
                                        </div>
                                        <!-- New Comment Form -->
                                        <div class="comment-form">
                                            <form action="{{route('storeComment')}}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                                        <input type="text" id="new-comment-input" placeholder="Write a comment..." class="reply-input w-100" name="body">           
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="send-reply-btn w-100">Send</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function(){
        $('#CommentSection').click(function(){
            $('#comment-section').slideToggle();
        })

    });
</script>


<script>
function editComment(editForm, commentBox, comment) {
    const updateCommentForm = document.getElementById(editForm);
    const targetedCommentBox = document.getElementById(commentBox);
    const commentText = document.getElementById(comment);
    const updateCommentFormInput = updateCommentForm.querySelector('input[name="body"]');
    if (updateCommentForm.style.display === 'none' || updateCommentForm.style.display === '') {
        targetedCommentBox.style.display = 'none';
        updateCommentForm.style.display = 'block';
        updateCommentFormInput.value = commentText.textContent.trim();
    } else{
        updateCommentForm.style.display = 'none';
        targetedCommentBox.style.display = 'block';
    }
}

function toggleReplyForm(replyFormId) {
    const replyForm = document.getElementById(replyFormId);
    if (replyForm.style.display === 'none' || replyForm.style.display === '') {
        replyForm.style.display = 'block';
    } else {
        replyForm.style.display = 'none';
    }
}


// Share post 

function copyCurrentUrl() {
    const url = window.location.href;
    const tempInput = document.createElement('input');
    tempInput.value = url;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('Current posts URL copied to clipboard!');
}

// Show Comments Section

// function showComments(commentsClass){
//     const commentSection = document.getElementById(commentsClass);
//     if(commentSection.style.display == 'none' || commentSection.style.display == ''){
//         commentSection.style.display == 'block';
//     }else{
//         commentSection.style.display == 'none';
//     }
// }

</script>
