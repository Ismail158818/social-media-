@extends('layouts.master')

@section('content2')
    <div class="app" id="app">
        <span class="clear hidden-folded p-x">
            <span class="block _500">{{ $name->first()->name }}</span>
            <small class="block text-muted"><i class="fa fa-circle text-success m-r-sm"></i>online</small>
        </span>
    </div>

    <div id="content" class="app-content box-shadow-z0" role="main">
        <div class="app-header white box-shadow">
            <div class="navbar navbar-toggleable-sm flex-row align-items-center">
                <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
                    <i class="material-icons">&#xe5d2;</i>
                </a>
                <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>
                <div class="collapse navbar-collapse" id="collapse">
                    <!-- link and dropdown -->
                    <ul class="nav navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href data-toggle="dropdown">
                                <i class="fa fa-fw fa-plus text-muted"></i>
                                <span>New</span>
                            </a>
                            <div ui-include="'../views/blocks/dropdown.new.html'"></div>
                        </li>
                    </ul>

                    <div ui-include="'../views/blocks/navbar.form.html'"></div>
                </div>

                <ul class="nav navbar-nav ml-auto flex-row">
                    <li class="nav-item dropdown pos-stc-xs">
                        <a class="nav-link mr-2" href data-toggle="dropdown">
                            <i class="material-icons">&#xe7f5;</i>
                            <span class="label label-sm up warn">3</span>
                        </a>
                        <div ui-include="'../views/blocks/dropdown.notification.html'"></div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link p-0 clear" href="#" data-toggle="dropdown">
                            <span class="avatar w-32">
                                <img src="{{ asset($name->image) }}" alt="{{ $name->name }}" class="avatar-img">
                                <i class="on b-white bottom"></i>
                            </span>
                        </a>
                        <div ui-include="'../views/blocks/dropdown.user.html'"></div>
                    </li>
                    <li class="nav-item hidden-md-up">
                        <a class="nav-link pl-2" data-toggle="collapse" data-target="#collapse">
                            <i class="material-icons">&#xe5d4;</i>
                        </a>
                    </li>
                </ul>
                <!-- / navbar right -->
            </div>
        </div>

        <div class="app-footer">
            <div class="p-2 text-xs">
                <div class="pull-right text-muted py-1">
                    &copy; Copyright <strong>Flatkit</strong> <span class="hidden-xs-down">- Built with Love v1.1.3</span>
                    <a ui-scroll-to="content"><i class="fa fa-long-arrow-up p-x-sm"></i></a>
                </div>
                <div class="nav">
                    <a class="nav-link" href="../..">About</a>
                    <a class="nav-link" href="http://themeforest.net/user/flatfull/portfolio?ref=flatfull">Get it</a>
                </div>
            </div>
        </div>

        <div ui-view class="app-body" id="view">
            <div class="item">
                <div class="item-bg">
                    <img src="{{ asset($name->image) }}" alt="{{ $name->name }}" class="img-square opacity-3">
                </div>

                <div class="row m-t">
                    <div class="col-sm-7">
                        <a href class="pull-left m-r-md">
                            <div class="avatar-container">
                                <span class="avatar w-96">
                                    <img src="{{ asset($name->image) }}" alt="{{ $name->name }}" class="img-square">
                                    <i class="on b-white"></i>
                                </span>
                            </div>
                        </a>
                        <div class="clear m-b">
                            <h3 class="m-0 m-b-xs">{{ $name->name }}</h3>
                            <p class="text-muted"><span class="m-r">{{ $name->first()->phone_number }}</span><small><i class="fa fa-map-marker m-r-xs"></i></small></p>
                            <div class="block clearfix m-b">
                                <a href="{{ $name->facebook }}" class="btn btn-icon btn-social rounded white btn-sm" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                    <i class="fa fa-facebook indigo"></i>
                                </a>
                                <a href="{{ $name->twitter }}" class="btn btn-icon btn-social rounded white btn-sm" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                    <i class="fa fa-twitter light-blue"></i>
                                </a>
                                <a href="{{ $name->google }}" class="btn btn-icon btn-social rounded white btn-sm" target="_blank">
                                    <i class="fa fa-google-plus"></i>
                                    <i class="fa fa-google-plus red"></i>
                                </a>
                                <a href="{{ $name->linkedin }}" class="btn btn-icon btn-social rounded white btn-sm" target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                    <i class="fa fa-linkedin cyan-600"></i>
                                </a>
                            </div>
                            @if ($isFollowing&&auth()->user()->block!=1)

                                <a href="{{ route('follow', $user->id) }}" class="btn btn-sm warn btn-rounded m-b">Follower</a>
                            @elseif(!$my_profile&&auth()->user()->block!=1)
                                <a href="{{ route('follow', $user->id) }}" class="btn btn-sm warn btn-rounded m-b">Follow</a>
                            @endif

                            @if(auth()->user()->id != $user->id&&auth()->user()->block!=1)
                                <a href="{{ url('/chatify/' . $user->id) }}" class="btn btn-sm btn-primary btn-rounded m-b shadow-lg animate__animated animate__pulse" target="_blank">
                                    <i class="fa fa-envelope"></i> Message
                                </a>
                            @endif
                        </div>
                        <div class="avatar-container">
                            @if(auth()->user()->id == $user->id||auth()->user()->role_id==1||auth()->user()->role_id==2)
                                
                                    <a href="{{ route('add.or.demote.or.delete.or.block', ['id'=>$user->id,"task_id"=>0,"view"=>'profile']) }}"  class="d-inline">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </a>
                            @endif
                            @if(auth()->user()->id == $user->id)
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editImageModal">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            @endif
                            <div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="editImageModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editImageModalLabel">Edit My Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('edit.info', ['id' => $name->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="image-upload">Choose Image</label>
                                                    <input type="file" name="image" id="image-upload" class="form-control" accept="image/*">
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ $name->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="facebook">Facebook</label>
                                                    <input type="url" name="facebook" class="form-control" id="facebook" value="{{ $name->facebook }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="twitter">Twitter</label>
                                                    <input type="url" name="twitter" class="form-control" id="twitter" value="{{ $name->twitter }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="linkedin">LinkedIn</label>
                                                    <input type="url" name="linkedin" class="form-control" id="linkedin" value="{{ $name->linkedin }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="google">Google</label>
                                                    <input type="url" name="google" class="form-control" id="google" value="{{ $name->google }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
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
            <div class="dker p-x">
                <div class="row">
                    <div class="col-sm-6 push-sm-6">
                        <div class="p-y text-center text-sm-right">
                            <div class="d-flex justify-content-center py-3 bg-light rounded shadow-sm">
                                <!-- عرض عدد المتابعين للجميع، مع جعل الرابط نشط لصاحب الحساب فقط -->
                                <div class="text-center mx-3">
                                    <span class="h4 d-block m-0">{{ $followersCount }}</span>
                                    <small class="text-muted">Followers</small>
                                    @if(auth()->user()->id == $user->id)
                                        <a href="{{ route('show.user.following.or.follower') }}" class="d-block">View Details</a>
                                    @endif
                                </div>
                                <!-- عرض عدد المتابعين للجميع، مع جعل الرابط نشط لصاحب الحساب فقط -->
                                <div class="text-center mx-3">
                                    <span class="h4 d-block m-0">{{ $followingCount }}</span>
                                    <small class="text-muted">Following</small>
                                    @if(auth()->user()->id == $user->id)
                                        <a href="{{ route('show.user.following.or.follower') }}" class="d-block">View Details</a>
                                    @endif
                                </div>
                                <!-- عرض عدد المجموعات فقط للأدوار المحددة -->
                                @if($user1->role_id == 3 || $user1->role_id == 4)
                                    <div class="text-center mx-3">
                                        <span class="h4 d-block m-0">{{ $group_count }}</span>
                                        <small class="text-muted">Groups</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 pull-sm-6">
                        <div class="p-y-md clearfix nav-active-primary">
                            <ul class="nav nav-pills nav-sm">
                                <li class="nav-item active">
                                    <a class="nav-link" href data-toggle="tab" data-target="#tab_1">Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href data-toggle="tab" data-target="#tab_2">Comments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href data-toggle="tab" data-target="#tab_3">UpVote</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href data-toggle="tab" data-target="#tab_4">DownVote</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="padding">
                <div class="row">
                    <div class="col-sm-8 col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane p-v-sm active" id="tab_1">
                                <div class="streamline b-l m-b m-l">
                                    @foreach($info as $in)
                                        <div class="card mb-4 shadow-sm">
                                            <div class="card-body">
                                                <small class="text-muted d-block">{{ $in->created_at->diffForHumans() }}</small>
                                                @if($in->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                    <button type="button" class="btn btn-primary btn-sm btn-icon-only" data-toggle="modal" data-target="#editPostModal-{{ $in->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <a href="{{ route('delete.post.or.comment', ['id' => $in->id,'type'=>'post']) }}"  class="d-inline">

                                                        <button type="submit" class="btn btn-danger btn-sm btn-icon-only">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        @if(!empty($in->user->image))
                                                            <img src="{{ asset($in->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="User Image">
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('profile', $in->user->id) }}" class="text-primary">{{ $in->user->name }}</a>
                                                            <div>
                                                                <strong>Tags:</strong>
                                                                @if($in->tags->isEmpty())
                                                                    <span>No tags.</span>
                                                                @else
                                                                    @foreach($in->tags as $tag)
                                                                        <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <a href="{{route('posts.upVote', $in->id)}}" class="btn btn-icon btn-light @if($in->authedRating?->pivot->type == 'upVote') bg-primary @endif white">
                                                                <i class="fa fa-thumbs-up text-success"></i>
                                                            </a>
                                                            <span>{{$in->upVotesCount}}</span>
                                                            <a href="{{route('posts.downVote', $in->id)}}" class="btn btn-icon btn-light @if($in->authedRating?->pivot->type == 'downVote') bg-primary @endif white">
                                                                <i class="fa fa-thumbs-down text-danger"></i>
                                                            </a>
                                                            <span>{{$in->downVotesCount}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <h5 class="card-title text-center mt-3">
                                                    <a href="{{route('posts.show', $in->id)}}" class="text-dark">{{ $in->title }}</a>
                                                </h5>
                                                <p class="card-text">{{ $in->content }}</p>
                                                @if(!empty($in->image))
                                                    <div class="text-center my-3">
                                                        <img src="{{ asset('storage/' . $in->image) }}" alt="Post Image" class="img-square">
                                                    </div>
                                                @endif
                                                <div class="mt-3">
                                                    <a href="#" data-toggle="collapse" data-target="#reply-{{ $in->id }}" class="card-link">
                                                        <i class="fa fa-fw fa-mail-reply text-muted"></i> Reply
                                                    </a>
                                                    <div class="collapse mt-2" id="reply-{{ $in->id }}">
                                                        <form action="{{route('comments.store')}}" method="POST">
                                                            @csrf
                                                            <input name="post_id" value="{{$in->id}}" hidden>
                                                            <div class="form-group">
                                                                <label for="content">Add Comment</label>
                                                                <input type="text" name="content" class="form-control" placeholder="Enter Content">
                                                            </div>
                                                            <button type="submit" class="btn btn-info btn-sm">Comment</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @if($in->comments != null)
                                                    <div class="mt-3">
                                                        @foreach($in->comments as $comment)
                                                            <div class="media mb-3 p-3" style="background-color: #e9ecef; margin-left: 20px; border-radius: 5px;">
                                                                @if(!empty($comment->user->image))
                                                                    <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="Commenter Image">
                                                                @endif
                                                                <div class="media-body">
                                                                    <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                                                    <p>{{ $comment->content }}</p>
                                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Modal for Edit Post -->
                                        <div class="modal fade" id="editPostModal-{{ $in->id }}" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel-{{ $in->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPostModalLabel-{{ $in->id }}">Edit post</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('post.edit') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $in->id }}">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="title">Edit title post</label>
                                                                <input type="text" name="title" class="form-control" id="title" value="{{ $in->title }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="content">Edit content post</label>
                                                                <textarea name="con" class="form-control" id="content" rows="5" required>{{ $in->content }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="image">edit image (optional)</label>
                                                                <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tags">Edit tags</label>
                                                                <select name="tags[]" id="tags" class="form-control" multiple>
                                                                    @foreach($in->tags as $tag)
                                                                        <option value="{{ $tag->id }}" @if($in->tags->contains($tag->id)) selected @endif>{{ $tag->tag_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-pane p-v-sm" id="tab_2">
                                @foreach($infocom as $post)
                                    <div class="streamline b-l m-b m-l">
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
                                                </div>
                                                @if(!empty($post->image))
                                                    <div class="text-center my-3">
                                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-square">
                                                    </div>
                                                @endif
                                                <h5 class="card-title text-center mt-3">
                                                    <a href="{{route('posts.show', $post->id)}}" class="text-dark">{{ $post->title }}</a>
                                                </h5>
                                                <p class="card-text">{{ $post->content }}</p>
                                                <div class="mt-3">
                                                    <h6>Comments:</h6>
                                                    <ul class="list-unstyled">
                                                        @foreach($post->comments as $comment)
                                                            <li class="media my-3" style="background-color: #e9ecef; margin-left: 20px; border-radius: 5px;">
                                                                @if(!empty($comment->user->image))
                                                                    <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="Commenter Image">
                                                                @endif
                                                                <div class="media-body">
                                                                    <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                                                    <p>{{ $comment->content }}</p>
                                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane p-v-sm" id="tab_3">
                                @foreach($postupvote as $upvote)
                                    <div class="streamline b-l m-b m-l">
                                        <div class="card mb-4 shadow-sm">
                                            <div class="card-body">
                                                <small class="text-muted d-block">{{ $upvote->created_at->diffForHumans() }}</small>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        @if(!empty($upvote->user->image))
                                                            <img src="{{ asset($upvote->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="User Image">
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('profile', $upvote->user->id) }}" class="text-primary">{{ $upvote->user->name }}</a>
                                                            <div>
                                                                <strong>Tags:</strong>
                                                                @if($upvote->tags->isEmpty())
                                                                    <span>No tags.</span>
                                                                @else
                                                                    @foreach($upvote->tags as $tag)
                                                                        <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mr-3">
                                                        <a href="{{route('posts.upVote', $upvote->id)}}" class="btn btn-icon btn-light @if($upvote->authedRating?->pivot->type == 'upVote') bg-primary @endif white">
                                                            <i class="fa fa-thumbs-up text-success"></i>
                                                        </a>
                                                        <span>{{$upvote->upVotesCount}}</span>
                                                        <a href="{{route('posts.downVote', $upvote->id)}}" class="btn btn-icon btn-light @if($upvote->authedRating?->pivot->type == 'downVote') bg-primary @endif white">
                                                            <i class="fa fa-thumbs-down text-danger"></i>
                                                        </a>
                                                        <span>{{$upvote->downVotesCount}}</span>
                                                    </div>
                                                </div>
                                                @if(!empty($upvote->image))
                                                    <div class="text-center my-3">
                                                        <img src="{{ asset('storage/' . $upvote->image) }}" alt="Post Image" class="img-square">
                                                    </div>
                                                @endif
                                                <h5 class="card-title text-center mt-3">
                                                    <a href="{{route('posts.show', $upvote->id)}}" class="text-dark">{{ $upvote->title }}</a>
                                                </h5>
                                                <p class="card-text">{{ $upvote->content }}</p>
                                                <div class="mt-3">
                                                    <h6>Comments:</h6>
                                                    <ul class="list-unstyled">
                                                        @foreach($upvote->comments as $comment)
                                                            <li class="media my-3" style="background-color: #e9ecef; margin-left: 20px; border-radius: 5px;">
                                                                @if(!empty($comment->user->image))
                                                                    <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="Commenter Image">
                                                                @endif
                                                                <div class="media-body">
                                                                    <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                                                    <p>{{ $comment->content }}</p>
                                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane p-v-sm" id="tab_4">
                                @foreach($postdownvote as $downvote)
                                    <div class="streamline b-l m-b m-l">
                                        <div class="card mb-4 shadow-sm">
                                            <div class="card-body">
                                                <small class="text-muted d-block">{{ $downvote->created_at->diffForHumans() }}</small>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        @if(!empty($downvote->user->image))
                                                            <img src="{{ asset($downvote->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="User Image">
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('profile', $downvote->user->id) }}" class="text-primary">{{ $downvote->user->name }}</a>
                                                            <div>
                                                                <strong>Tags:</strong>
                                                                @if($downvote->tags->isEmpty())
                                                                    <span>No tags.</span>
                                                                @else
                                                                    @foreach($downvote->tags as $tag)
                                                                        <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mr-3">
                                                        <a href="{{route('posts.upVote', $downvote->id)}}" class="btn btn-icon btn-light @if($downvote->authedRating?->pivot->type == 'upVote') bg-primary @endif white">
                                                            <i class="fa fa-thumbs-up text-success"></i>
                                                        </a>
                                                        <span>{{$downvote->upVotesCount}}</span>
                                                        <a href="{{route('posts.downVote', $downvote->id)}}" class="btn btn-icon btn-light @if($downvote->authedRating?->pivot->type == 'downVote') bg-primary @endif white">
                                                            <i class="fa fa-thumbs-down text-danger"></i>
                                                        </a>
                                                        <span>{{$downvote->downVotesCount}}</span>
                                                    </div>
                                                </div>
                                                @if(!empty($downvote->image))
                                                    <div class="text-center my-3">
                                                        <img src="{{ asset('storage/' . $downvote->image) }}" alt="Post Image" class="img-square">
                                                    </div>
                                                @endif
                                                <h5 class="card-title text-center mt-3">
                                                    <a href="{{route('posts.show', $downvote->id)}}" class="text-dark">{{ $downvote->title }}</a>
                                                </h5>
                                                <p class="card-text">{{ $downvote->content }}</p>
                                                <div class="mt-3">
                                                    <h6>Comments:</h6>
                                                    <ul class="list-unstyled">
                                                        @foreach($downvote->comments as $comment)
                                                            <li class="media my-3" style="background-color: #e9ecef; margin-left: 20px; border-radius: 5px;">
                                                                @if(!empty($comment->user->image))
                                                                    <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="Commenter Image">
                                                                @endif
                                                                <div class="media-body">
                                                                    <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                                                    <p>{{ $comment->content }}</p>
                                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div ui-include="'../views/blocks/widget.friends.html'"></div>
                        </div>
                    </div>
@if(auth()->user()->block!=1)
    @if(auth()->user()->id==$user->id)
                    <div class="col-sm-4 col-lg-3">
                        <div>
                            <div class="box">
                                <div class="box-header">
                                    <h3>Who to follow</h3>
                                </div>
                                <div class="box-divider m-0"></div>
                                <ul class="list no-border p-b">
                                    @forelse($unfollowing as $un)
                                        <li class="list-item">
                                            <a href="#" class="list-left">
                                                <span class="w-40 avatar">
                                                    <img src="{{ asset($un->image) }}" alt="{{ $un->name }}" class="avatar-img">
                                                    <i class="on b-white bottom"></i>
                                                </span>
                                            </a>
                                            <div class="list-body">
                                                <div><a href="{{route('profile',$un->id)}}">{{$un->name}}</a></div>
                                                <a href="{{ route('follow', $un->id) }}" class="btn btn-sm warn btn-rounded m-b">Follow</a>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-center">No users to follow at the moment</p>
                                    @endforelse
                                </ul>
                                <div class="box-divider m-0"></div>
                                <ul class="list no-border p-b">
                                    @forelse($following as $follow)
                                        <li class="list-item">
                                            <a href="#" class="list-left">
                                                <span class="w-40 avatar">
                                                    <img src="{{ asset($follow->image) }}" alt="{{$follow->name }}" class="avatar-img">
                                                    <i class="on b-white bottom"></i>
                                                </span>
                                            </a>
                                            <div class="list-body">
                                                <div><a href="{{route('profile',$follow->id)}}">{{$follow->name}}</a></div>
                                                <a href="{{ route('follow', $follow->id) }}" class="btn btn-sm warn btn-rounded m-b">Follower</a>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-center">No users to follow at the moment</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
    @endif
    @endif
                </div>
            </div>
        </div>

        <style>
            .btn-sm {
                padding: 5px 10px;
                font-size: 12px;
                line-height: 1.5;
            }

            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }

            .img-square {
                width: 100%;
                height: auto;
                max-width: 600px;
                max-height: 600px;
                object-fit: cover;
                border-radius: 0;
            }

            .avatar-img {
                width: 35px;
                height: 35px;
                object-fit: cover;
                border-radius: 50%;
            }
        </style>
        <style>
            .btn-icon-only {
                padding: 0.25rem !important;
                width: 20px !important;
                height:20px !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .btn-icon-only i {
                font-size: 0.875rem !important; /* تقليل حجم الأيقونة */
            }
            .btn-rounded {
                border-radius: 1px !important; /* تقليل نصف قطر الحدود */
            }
            .shadow-sm {
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            }
        </style>
          <style>
            .btn-sm {
                padding: 5px 10px;
                font-size: 12px;
                line-height: 1.5;
            }

            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }

            .img-square {
                width: 100%;
                height: auto;
                max-width: 600px;
                max-height: 600px;
                object-fit: cover;
                border-radius: 0;
            }

            .avatar-img {
                width: 50px;
                height: 50px;
                object-fit: cover;
                border-radius: 50%;
            }
        </style>
        <style>
            .btn-icon-only {
                padding: 0.25rem !important;
                width: 20px !important;
                height:20px !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .btn-icon-only i {
                font-size: 0.875rem !important; /* تقليل حجم الأيقونة */
            }
            .btn-rounded {
                border-radius: 1px !important; /* تقليل نصف قطر الحدود */
            }
            .shadow-sm {
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            }
        </style>
    </div>
@endsection

