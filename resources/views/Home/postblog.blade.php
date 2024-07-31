@extends('Home.layouts.homemasterlayout')

<style>
    .comment a:hover{
        color: white;
    }
    .editComment{
    display: none;  
}
</style>

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Post content-->
            @isset($posts)
                {{-- @foreach ($posts as $value) --}}
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{$posts->title}}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on {{$posts->created_at->format('g:i A')}}</div>
                            <!-- Post categories-->
                            <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{$posts->category->name}}</a>
                            {{-- <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a> --}}
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="{{asset($posts->image)}}" alt="..." /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4">{{$posts->description}}</p>
                        </section>
                    </article>
                {{-- @endforeach --}}
            @else
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1">Welcome to Blog Post!</h1>
                        <!-- Post meta content-->
                        <div class="text-muted fst-italic mb-2">Posted on january 2024</div>
                        <!-- Post categories-->
                        <a class="badge bg-secondary text-decoration-none link-light" href="#!">JavaScript</a>
                        {{-- <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a> --}}
                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4"><img class="img-fluid rounded" src="" alt="..." /></figure>
                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut porro error quidem illo sed. Iure iusto quaerat est quos, vel sequi harum alias! Distinctio cupiditate nam eos, ad consequuntur et pariatur aliquam sunt omnis quasi quo perferendis consectetur corporis vero officiis molestiae quae? Placeat nam eligendi doloribus pariatur voluptate quos, fugit aperiam, debitis perspiciatis dolore maiores at vitae autem. Accusantium perspiciatis dolorum architecto alias necessitatibus eligendi nemo! Repellat possimus commodi iure tenetur. Voluptatibus nostrum incidunt porro sint eveniet fugiat velit eos suscipit ad recusandae consequatur provident exercitationem odio alias numquam quas, facere cum. Ut, architecto nemo pariatur labore cum nam expedita possimus iure ipsum dolore quidem adipisci, maiores numquam nulla temporibus. Ullam quae et necessitatibus dolorum doloremque mollitia possimus hic esse asperiores qui, eum, eligendi molestiae, voluptatibus aliquid. Voluptatum et quasi nisi natus sapiente reiciendis minus aperiam totam fuga dolore quia nihil, alias culpa laboriosam, labore quae adipisci at modi!</p>
                    </section>
                </article>
            @endisset

            {{-- @forelse ($posts as $key => $value )
                
            @empty
                
            @endforelse --}}
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <!-- Comment form-->
                        <div class="row d-flex justify-content-around text-align-center"> 
                            <div class="col-m-12">
                                <div class="comment-section" style="">
                                    <div class="comment" id="comment-1">
                                        @isset($posts)
                                            
                                            @forelse ($posts->comment as $comment)                  
                                            
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div id="comment-{{$comment->id}}">
                                                            <div class="comment-user">
                                                                {{$comment->user->name}}
                                                                @if($comment->user->role == 'vendor')
                                                                <span class="text-secondary" style="font-size: 12px;">author</span>
                                                                @endif
                                                            </div>
                                                            <div id="comment-text-{{$comment->id}}" class="comment-text">{{$comment->body}}</div>
                                                        </div>
                                                        {{-- {{$comment->post_id}} <br>
                                                        {{$comment->user->id}} <br>
                                                        {{$comment->id}} <br> --}}
                                                        <div id="edit-comment-form-{{$comment->id}}" class="editComment">
                                                            <form action="{{route('updateComment')}}" method="post">
                                                                @csrf
                                                                {{-- @method('PUT') --}}
                                                                <input type="text" name="body">
                                                                <input type="hidden" name="$post_id" value="{{$comment->post_id}}">
                                                                <input type="hidden" name="user_id" value="{{$comment->user->id}}">
                                                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                                <button type="submit" class="btn primaryBtn fs-7 btn-sm">Update</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        @if (Auth::guest() == false)
                                                            @if (Auth::user()->id == $comment->user->id)
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
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                @if (Auth::guest() == false)
                                                    <div class="comment-actions">
                                                        <button class="reply-btn" onclick="toggleReplyForm('reply-form-{{$comment->id}}')">Reply</button>
                                                    </div>
                                                @endif
                                                
                                                
                                                <div class="reply-form" id="reply-form-{{$comment->id}}">
                                                    <form action="{{route('storeReply')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" placeholder="Write a reply..." class="reply-input" name="comment_id" value="{{$comment->id}}">
                                                        <input type="hidden" placeholder="Write a reply..." class="reply-input" name="reply_id"> 
                                                        <input type="hidden" placeholder="Write a reply..." class="reply-input" name="post_id" value="{{$comment->post_id}}">
                                                        <input type="text" placeholder="Write a reply..." class="reply-input" name="body">
                                                        <button type="submit" class="send-reply-btn pirmaryBtn" >Send</button>
                                                    </form>
                                                </div>
                                                @foreach ($comment->replies as $reply)
                                                    @if ($comment->id === $reply->comment_id)
                                                        <div class="replies" id="replies-comment-1">
                                                            <div class="reply" id="comment-1-{{$reply->id}}">
                                                                <div class="comment-user">{{$reply->user->name}}</div>
                                                                <div class="comment-text">{{$reply->body}}</div>
                                                                @if (Auth::guest() == false)
                                                                    <div class="comment-actions">
                                                                        <button class="reply-btn" onclick="toggleReplyForm('reply-form-comment-1-{{$reply->id}}')">Reply</button>
                                                                    </div>      
                                                                @endif
                                                                                                                                    
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
                                                <hr class="p-0 my-2">
                                            @empty
                                                {{-- <div class="comment-user">User</div> --}}
                                                <div class="comment-text text-secondary">No comments</div>
                                            @endforelse                                           
                                        @endisset
                                    </div>
                            
                                </div>
                                <!-- New Comment Form -->
                                <div class="comment-form">
                                    <form action="{{route('storeComment')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-10 d-flex justify-content-center align-items-center">
                                                <input type="hidden" name="user_id" value="{{ Auth::guest() == false ? Auth::user()->id : null }}">
                                                <input type="hidden" name="post_id" value="{{$posts->id}}">
                                                <input type="text" id="new-comment-input" placeholder="Write a comment..." class="reply-input w-100" name="body">           
                                            </div>
                                            @if(Auth::check())
                                            <div class="col-md-2">
                                                <button type="submit" class="send-reply-btn primaryBtn w-100">Send</button>
                                            </div>
                                            @else
                                            <div class="col-md-2 d-flex justify-content-center align-items-center comment mb-0">
                                                <a href="{{route('loginPage')}}" class="text-decoration-none primaryBtn text-center send-reply-btn w-100 me-3">Send</a>
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="comment-form">
                                    <form action="{{route('storeComment')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="hidden" name="user_id" value="{{ Auth::guest() == false ? Auth::user()->id : null }}">
                                                <input type="hidden" name="post_id" value="{{$posts->id}}">
                                                <input type="text" id="new-comment-input" placeholder="Write a comment..." class="reply-input w-100" name="body">           
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="send-reply-btn w-100">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div> --}}
                            </div>
                           
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- <div class="row d-flex justify-content-around text-align-center"> 
                            <div class="col-m-12">
                                <div class="comment-section" style="overflow-y: scroll; height: 400px;">
                                    <div class="comment" id="comment-1">
                                        @isset($posts)
                                            
                                            @foreach ($posts->comment as $comment)
                                                <div class="comment-user">{{$comment->user->name}}</div>
                                                <div class="comment-text">{{$comment->body}}</div>
                                                @if (Auth::check() && Auth::user()->role === 'user')
                                                    <div class="comment-actions">
                                                        <button class="reply-btn" onclick="toggleReplyForm('reply-form-{{$comment->id}}')">Reply</button>
                                                    </div>    
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
                                                @endif
                                                @foreach ($comment->replies as $reply)
                                                    @if ($comment->id === $reply->comment_id)
                                                        <div class="replies" id="replies-comment-1">
                                                            <div class="reply" id="comment-1-{{$reply->id}}">
                                                                <div class="comment-user">{{$reply->user->name}}</div>
                                                                <div class="comment-text">{{$reply->body}}</div>
                                                                @if (Auth::check() && Auth::user()->role === 'user')
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
                                                                @endif    
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
                               
                                    <div class="comment-form">
                                        <form action="{{route('storeComment')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-10 d-flex justify-content-center align-items-center">
                                                    <input type="hidden" name="user_id" value="{{$posts->user->id}}">
                                                    <input type="hidden" name="post_id" value="{{$posts->id}}">
                                                    <input type="text" id="new-comment-input" placeholder="Write a comment..." class="reply-input w-100" name="body">           
                                                </div>
                                                @if(Auth::check())
                                                <div class="col-md-2">
                                                    <button type="submit" class="send-reply-btn w-100">Send</button>
                                                </div>
                                                @else
                                                <div class="col-md-2 d-flex justify-content-center align-items-center comment mb-0">
                                                    <a href="{{route('loginPage')}}" class="text-decoration-none text-center send-reply-btn w-100 me-3">Send</a>
                                                </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </section>
        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Search widget-->
            {{-- <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn primaryBtn" id="button-search" type="button">Go!</button>
                    </div>
                </div>
            </div> --}}
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
</script>