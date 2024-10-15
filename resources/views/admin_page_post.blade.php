@extends('layouts.master')

@section('content')
    <div class="container">
        @if (session('report_success'))
            <div class="alert alert-success">
                {{ session('report_success') }}
            </div>
        @endif
        @if (session('report'))
            <div class="alert alert-success">
                {{ session('report') }}
            </div>
        @endif
<br>
<br>
        <!-- Toggle Buttons for Reports -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" id="showPostReports">Show Post Reports: {{$reportsCount}}</button>
            <button type="button" class="btn btn-secondary" id="showGroupReports">Show Group Reports: {{$ReportsGroupsCount}}</button>
        </div>

        <!-- Post Reports Section -->
        <div id="postReports">
            <h4>Post Reports</h4>
            @if($reports->isNotEmpty())
                @foreach($reports as $report)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($report->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="Reporter Image">
                                <div>
                                    <strong>{{ $report->user->name }}</strong>
                                    <p class="text-danger mb-0">Note about the report: {{ $report->note }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($report->post->user->image ) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="Post Owner Image">
                                <div>
                                    <strong>{{ $report->post->user->name }}</strong>
                                    <div>
                                        <strong>Tags:</strong>
                                        @if($report->post->tags->isEmpty())
                                            <span>No tags.</span>
                                        @else
                                            @foreach($report->post->tags as $tag)
                                                <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title text-center mt-3">{{ $report->post->title }}</h5>
                            <p class="card-text">{{ $report->post->content }}</p>
                            @if(!empty($report->post->image))
                                <div class="text-center my-3">
                                    <img src="{{ asset($report->post->image) }}" alt="Post Image" class="img-fluid img-square w-50">
                                </div>
                            @endif
                            <div class="d-flex justify-content-between">
                                <!-- Accept Button -->
                                <form action="{{ route('accept.report.post', ['id' => $report->id, 'post_id' => $report->post_id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to accept this report? If confirmed, the reported post will be deleted.');">Accept</button>
                                </form>
                                <!-- Reject Button -->
                                <form action="{{ route('reject.report.post', ['id' => $report->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this report?');">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="alert alert-info">There are currently no reports about posts.</p>
            @endif
        </div>

        <!-- Group Reports Section -->
        <div id="groupReports" style="display: none;">
            <h4>Group Reports</h4>
            @if($ReportsGroups->isNotEmpty())
                <div class="row">
                    @foreach($ReportsGroups as $ReportsGroup)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <!-- Reporter Information -->
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset($ReportsGroup->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="Reporter Image">
                                        <div>
                                            <strong>{{$ReportsGroup->user->name }}</strong>
                                            <p class="text-danger mb-0">{{ $ReportsGroup->note }}</p>
                                        </div>
                                    </div>

                                    <!-- Group Information -->
                                    <img src="{{ asset($ReportsGroup->group->image ) }}" class="card-img-top" alt="Group Image">
                                    <div class="mt-2">
                                        <a href="{{ route('group', ['id' => $ReportsGroup->group_id]) }}" class="btn btn-sm ">
                                            <h4>{{$ReportsGroup->group->name}}</h4>
                                        </a>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between mt-3">
                                        <!-- Accept Button -->
                                        <form action="{{ route('accept.report.group', ['id' => $ReportsGroup->group_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to accept this report? If confirmed, the reported group will be deleted.');">Accept</button>
                                        </form>
                                        <!-- Reject Button -->
                                        <form action="{{ route('reject.report.group', ['id' => $ReportsGroup->group_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this report?');">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="alert alert-info">There are currently no reports about groups.</p>
            @endif
        </div>
    </div>


@endsection
