@extends('layouts.master')

@section('content')
    <div class="container my-5">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="streamline b-l m-l-md">
                            @foreach($posts as $post)
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <small class="text-muted d-block">{{ $post->created_at->diffForHumans() }}</small>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                @if(!empty($post->user->image))
                                                    <img src="{{ asset($post->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="User Image">
                                                @endif
                                                <div>
                                                    <a href="{{ route('profile', $post->user->id) }}" class="text-primary">{{ $post->user->name }}</a>
                                                    <div>
                                                        <strong>Tags:</strong>
                                                        @if($post->tags->isEmpty())
                                                            <span>No tags.</span>
                                                        @else
                                                            @foreach($post->tags as $tag)
                                                                <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <a href="{{route('posts.upVote', $post->id)}}" class="btn btn-icon btn-light @if($post->authedRating?->pivot->type == 'upVote') bg-primary @endif white">
                                                        <i class="fa fa-thumbs-up text-success"></i>
                                                    </a>
                                                    <span>{{$post->upVotesCount}}</span>
                                                    <a href="{{route('posts.downVote', $post->id)}}" class="btn btn-icon btn-light @if($post->authedRating?->pivot->type == 'downVote') bg-primary @endif white">
                                                        <i class="fa fa-thumbs-down text-danger"></i>
                                                    </a>
                                                    <span>{{$post->downVotesCount}}</span>
                                                </div>
                                                @if($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                    @if($post->user->role_id != 1)
                                                        <a href="{{ route('delete.post.or.comment',['id'=>$post->id,'type'=>'post']) }}" class="btn btn-sm btn-danger btn-rounded shadow-lg animate__animated animate__pulse">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @elseif($post->user->role_id ==1 )
                                                        @if(auth()->user()->role_id==1)
                                                            <a href="{{ route('delete.post.or.comment',['id'=>$post->id,'type'=>'post']) }}" class="btn btn-sm btn-danger btn-rounded shadow-lg animate__animated animate__pulse">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if($post->user->id != auth()->user()->id && auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
                                                    <!-- زر فتح المودال -->
                                                    <button class="badge badge-info" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $post->id }}">
                                                        <i class="fa fa-flag"></i> Report
                                                    </button>

                                                    <!-- مودال Bootstrap -->
                                                    <div class="modal fade" id="reportModal-{{ $post->id }}" tabindex="-1" aria-labelledby="reportModalLabel-{{ $post->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="reportModalLabel-{{ $post->id }}">Report Post</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('posts.report', ['post' => $post->id]) }}" method="POST">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label for="note" class="form-label">Note:</label>
                                                                            <input type="text" name="note" class="form-control" required>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">Send</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>

                                        <h5 class="card-title text-center mt-3">
                                            <a href="{{route('posts.show', $post->id)}}" class="text-dark">{{ $post->title }}</a>
                                        </h5>
                                        <p class="card-text" style="text-indent: 40px;">{{ $post->content }}</p>
                                        <div class="mt-3">
                                            @if(!empty($post->image))
                                                <div class="text-center my-3">
                                                    <img src="{{ asset($post->image) }}" alt="Post Image" class="img-fluid img-square w-50">
                                                </div>
                                            @endif
                                            <a href="#" data-toggle="collapse" data-target="#reply-{{ $post->id }}" class="card-link">
                                                <i class="fa fa-fw fa-mail-reply text-muted"></i> Reply
                                            </a>

                                            <div class="collapse mt-2" id="reply-{{ $post->id }}">
                                                <form action="{{route('comments.store')}}" method="POST">
                                                    @csrf
                                                    <input name="post_id" value="{{$post->id}}" hidden>
                                                    <div class="form-group">
                                                        <label for="content">Add Comment</label>
                                                        <textarea name="content" class="form-control" placeholder="Enter Content" rows="5"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-info btn-sm">Comment</button>
                                                </form>
                                            </div>
                                        </div>
                                        @if($post->comments != null)
                                            <div class="mt-3">
                                                @foreach($post->comments as $comment)
                                                    <div class="media mb-3 p-3 shadow-sm" style="background-color: #f1f3f5; border-radius: 10px;">
                                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                        <div class="d-flex w-100 align-items-center mt-2">
                                                            @if(!empty($comment->user->image))
                                                                <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 45px; height: 45px; object-fit: cover;" alt="User Image">
                                                            @endif
                                                            <div class="media-body flex-grow-1">
                                                                <h6 class="mt-0 font-weight-bold">{{ $comment->user->name }}</h6>
                                                                <p>{{ $comment->content }}</p>
                                                            </div>
                                                            @if($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                                <a href="{{ route('delete.post.or.comment', ['id' => $post->id, 'type' => 'comment']) }}" class="btn btn-sm btn-danger ml-auto">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Group Modal -->
        <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createGroupModalLabel">Create Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('creat.group') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Group Name:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Group Description:</label>
                                <input type="text" name="description" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="photo">Group image:</label>
                                <input class="form-control" name="photo" type="file" id="photo" required>
                            </div>
                            @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
                                <div class="form-group">
                                    <label for="users">Select Users:</label>
                                    <select name="users[]" id="users" class="form-control select2" multiple required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-info mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Post Modal -->
        <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPostModalLabel">Create Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.store.group') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <input type="text" name="content" class="form-control" placeholder="Enter Content">
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <select class="tags form-control" id="tags" name="tags[]" multiple="multiple"></select>
                            </div>
                            <div class="form-group">
                                <label for="photos">Post images:</label>
                                <input class="form-control" name="photos[]" type="file" id="photos" multiple accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Tag Modal -->
        <div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTagModalLabel">Add New Tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tags.user') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="newtag">New Tag</label>
                                <input type="text" name="newtag" class="form-control" placeholder="Enter New Tag" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleJoinedGroups() {
                var groups = document.getElementById('joinedGroups');
                if (groups.style.display === "none") {
                    groups.style.display = "block";
                } else {
                    groups.style.display = "none";
                }
            }

            function toggleNotJoinedGroups() {
                var groups = document.getElementById('notJoinedGroups');
                if (groups.style.display === "none") {
                    groups.style.display = "block";
                } else {
                    groups.style.display = "none";
                }
            }

            function toggleReportForm(postId) {
                var form = document.getElementById('reportForm-' + postId);
                if (form.style.display === "none") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }

            function openTagModal() {
                $('#addTagModal').modal('show');
            }
        </script>
    </div>

    <style>
        /* تعديل الأزرار */
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* تعديل الصور لتكون مربعة وأصغر */
        .img-square {
            width: 100%;
            height: auto;
            max-width: 600px; /* أقصى عرض للصورة */
            max-height: 600px; /* أقصى ارتفاع للصورة */
            object-fit: cover;
            border-radius: 0; /* إزالة الحواف المستديرة */
        }
    </style>
@endsection
