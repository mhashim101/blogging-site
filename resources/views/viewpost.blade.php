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
                                <p class="card-text">{{ $post->description }}</p><br>
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
                                        Like
                                    </div>
                                    <div class="col-md-4 text-center">
                                        Comment
                                    </div>
                                    <div class="col-md-4 text-end">
                                        Share
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-around text-align-center"> 
                                    <div class="col-m-12">
                                        <div class="comment-section" style="overflow-y: scroll; height: 400px;">
                                            <div class="comment" id="comment-1">
                                                @isset($post)
                                                    
                                                    @foreach ($post->comment as $comment)
                                                        <div class="comment-user">{{$comment->user->name}}</div>
                                                        <div class="comment-text">{{$comment->body}}</div>
                                                        <div class="comment-actions">
                                                            <button class="reply-btn" onclick="toggleReplyForm('reply-form-{{$comment->id}}')">Reply</button>
                                                        </div>
                                                        <div class="reply-form" id="reply-form-{{$comment->id}}">
                                                            <form action="{{route('storeReply')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" placeholder="Write a reply..." class="reply-input" name="comment_id" value="{{$comment->id}}">
                                                                {{-- @isset() --}}
                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="reply_id"> 
                                                                {{-- @endisset --}}
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

                                                                        {{-- @isset($reply->reply_id)

                                                                            <div class="comment-user">{{$reply->user->name}}</div>
                                                                            <div class="comment-text">{{$reply->body}}</div>
                                                                            <div class="comment-actions">
                                                                                <button class="reply-btn" onclick="toggleReplyForm('reply-form-comment-1-{{$reply->id}}')">Reply</button>
                                                                            </div>   
                                                                        @endisset --}}

                                                                        <div class="replies" id="replies-comment-1-{{$reply->id}}">
                                                                            <div class="reply-form" id="reply-form-comment-1-{{$reply->id}}">
                                                                                {{-- Form --}}
                                                                                <form action="{{route('storeReply')}}" method="post">
                                                                                    @csrf
                                                                                    <input type="text" placeholder="Write a reply..." class="reply-input" name="body">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="user_id">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="post_id" value="{{$comment->post_id}}">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="comment_id" value="{{$reply->comment_id}}">
                                                                                    <input type="hidden" placeholder="Write a reply..." class="reply-input" name="reply_id" {{$reply->id}}>
                                                                                    <button type="submit" class="send-reply-btn" >Send</button>
                                                                                </form>
                                                                                {{-- End Form --}}
                                                                                {{-- <button class="send-reply-btn" onclick="sendReply('comment-1-{{$reply->id}}', 'reply-form-comment-1-{{$reply->id}}')">Send</button> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    <div class="comment-user">User</div>
                                                    <div class="comment-text">No comments</div>
                                                @endisset
                                            </div>
                                    
                                        </div>
                                        <!-- New Comment Form -->
                                        <div class="comment-form">
                                            <form action="{{route('storeComment')}}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="hidden" name="user_id" value="{{$post->user->id}}">
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

<script>
function toggleReplyForm(replyFormId) {
    const replyForm = document.getElementById(replyFormId);
    if (replyForm.style.display === 'none' || replyForm.style.display === '') {
        replyForm.style.display = 'block';
    } else {
        replyForm.style.display = 'none';
    }
}

// function sendReply(parentId, replyFormId) {
//     const replyForm = document.getElementById(replyFormId);
//     const replyInput = replyForm.querySelector('.reply-input');
//     const replyText = replyInput.value;

//     if (replyText.trim() !== '') {
//         const repliesContainer = document.getElementById(`replies-${parentId}`);
//         const newReply = document.createElement('div');
//         newReply.className = 'reply';
//         const newReplyId = `${parentId}-${Math.random().toString(36).substr(2, 9)}`; // Generate a unique id for new reply
//         newReply.id = newReplyId;
//         newReply.innerHTML = `
//             <div class="comment-user">You</div>
//             <div class="comment-text">${replyText}</div>
//             <div class="comment-actions">
//                 <button class="reply-btn" onclick="toggleReplyForm('reply-form-${newReplyId}')">Reply</button>
//             </div>
//             <div class="replies" id="replies-${newReplyId}"></div>
//             <div class="reply-form" id="reply-form-${newReplyId}">
//                 <input type="text" placeholder="Write a reply..." class="reply-input">
//                 <button class="send-reply-btn" onclick="sendReply('${newReplyId}', 'reply-form-${newReplyId}')">Send</button>
//             </div>
//         `;
//         repliesContainer.appendChild(newReply);
//         replyInput.value = '';
//         replyForm.style.display = 'none';
//     }
// }

// function addComment() {
//     const commentInput = document.getElementById('new-comment-input');
//     const commentText = commentInput.value;

//     if (commentText.trim() !== '') {
//         const newComment = document.createElement('div');
//         newComment.className = 'comment';
//         const newCommentId = `comment-${Math.random().toString(36).substr(2, 9)}`; // Generate a unique id for new comment
//         newComment.id = newCommentId;
//         newComment.innerHTML = `
//             <div class="comment-user">You</div>
//             <div class="comment-text">${commentText}</div>
//             <div class="comment-actions">
//                 <button class="reply-btn" onclick="toggleReplyForm('reply-form-${newCommentId}')">Reply</button>
//             </div>
//             <div class="replies" id="replies-${newCommentId}"></div>
//             <div class="reply-form" id="reply-form-${newCommentId}">
//                 <input type="text" placeholder="Write a reply..." class="reply-input">
//                 <button class="send-reply-btn" onclick="sendReply('${newCommentId}', 'reply-form-${newCommentId}')">Send</button>
//             </div>
//         `;
//         document.querySelector('.comment-section').appendChild(newComment);
//         commentInput.value = '';
//     }
// }


</script>
