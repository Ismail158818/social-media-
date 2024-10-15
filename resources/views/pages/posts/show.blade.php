@extends('layouts.master')
@section('content')
    <div class="col-lg">

        <div class="box">
            <div class="box-header">
                <h3>Post </h3>
            </div>
            <div class="box-body">
                <div class="streamline b-l m-l-md">
                        <div class="sl-item">

                            @if($post->image != null)
                                <div class="sl-left">
                                    <img src="{{asset('../assets/images/a0.jpg')}}" class="img-circle">
                                </div>
                            @endif
                            @if(!$post->ratings->isNotEmpty())
                                <a href="{{route('posts.upVote', $post->id)}}" class="btn btn-icon white pull-right ml-3">
                                    <i class="fa fa-thumbs-up text-success"></i>
                                </a>
                                <a href="{{route('posts.downVote', $post->id)}}" class="btn btn-icon white pull-right">
                                    <i class="fa fa-thumbs-down text-danger"></i>
                                </a>
                                @endif
                            <div class="sl-content">
                                <div class="sl-author font-weight-bold size-6">
                                    <a style="color: #6f2877" href>{{$post->user->name}}</a>
                                </div>
                                <div class="sl-date text-muted">{{$post->created_at->diffForHumans()}}</div>

                                <div class="sl-author text-center font-weight-bold h3">
                                    <a href>{{$post->title}}</a>
                                </div>
                                <div>
                                    <p>{{$post->content}}</p>
                                </div>


                                <div class="box collapse m-0 b-a" id="reply-1">
                                    <form>
                                        <textarea class="form-control no-border" rows="3" placeholder="Type something..."></textarea>
                                    </form>
                                    <div class="box-footer clearfix">
                                        <button class="btn btn-info pull-right btn-sm">Post</button>
                                        <ul class="nav nav-pills nav-sm">
                                            <li class="nav-item"><a class="nav-link" href><i class="fa fa-camera text-muted"></i></a></li>
                                            <li class="nav-item"><a class="nav-link" href><i class="fa fa-video-camera text-muted"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
            <hr>
        <div class="box">
            <div class="box-header">
                <h3>Comments </h3>
            </div>
            <div class="box-body">
                <div class="streamline b-l m-l-md">
                    @foreach($comments as $comment)
                    <div class="sl-item">
                        <a class="btn btn-icon white pull-right ml-3">
                            <i class="fa fa-thumbs-up text-success"></i>
                        </a>
                        <a class="btn btn-icon white pull-right">
                            <i class="fa fa-thumbs-down text-danger"></i>
                        </a>
                        <div class="sl-content">
                            <div class="sl-author font-weight-bold size-6">
                                <a style="color: #6f2877" href>{{$comment->user->name}}</a>
                            </div>
                            <div class="sl-date text-muted">{{$comment->created_at->diffForHumans()}}</div>

                            <div>
                                <p>{{$comment->content}}</p>
                            </div>

                            <div class="box collapse m-0 b-a" id="reply-1">
                                <form>
                                    <textarea class="form-control no-border" rows="3" placeholder="Type something..."></textarea>
                                </form>
                                <div class="box-footer clearfix">
                                    <button class="btn btn-info pull-right btn-sm">Post</button>
                                    <ul class="nav nav-pills nav-sm">
                                        <li class="nav-item"><a class="nav-link" href><i class="fa fa-camera text-muted"></i></a></li>
                                        <li class="nav-item"><a class="nav-link" href><i class="fa fa-video-camera text-muted"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
        <div class="box">
            <form action="{{route('comments.store')}}" method="POST">
                @csrf
                <div class="padding">
                    <input name="post_id" value="{{$post->id}}" hidden>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Add Comment</label>
                        <input type="text" name="content" class="form-control" placeholder="Enter Content">
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <button type="submit" class="btn btn-info pull-right btn-sm">Comment</button>
                    {{--                <ul class="nav nav-pills nav-sm">--}}
                    {{--                    <li class="nav-item"><a class="nav-link" href><i class="fa fa-camera text-muted"></i></a></li>--}}
                    {{--                </ul>--}}
                </div>
            </form>
        </div>
    </div>
@endsection
