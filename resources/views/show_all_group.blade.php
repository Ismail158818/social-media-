@extends('layouts.master')
@section('content')
    <div class="container my-5">
        @if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
            <!-- الأزرار لعرض المجموعات المشتركة وغير المشتركة -->
            <div class="mb-4 d-flex justify-content-center">
                <button class="btn btn-primary mx-2" id="showJoinedGroups">Joined Groups</button>
                <button class="btn btn-secondary mx-2" id="showNotJoinedGroups">Available Groups</button>
            </div>
            <!-- المجموعات غير المشتركة -->
            <div id="notJoinedGroups" class="row mb-4 align-items-center" style="display: none;">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @if($groupsNotJoined->isEmpty())
                        <p class="text-center w-100">No available groups to join at the moment</p>
                    @else
                        @foreach($groupsNotJoined as $group)
                            <div class="card me-3 shadow-sm" style="width: 14rem; border-radius: 15px;">
                                <img src="{{ asset($group->image) }}" class="card-img-top img-fluid" style="height: 120px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;" alt="{{ $group->name }}">
                                <div class="card-body d-flex flex-column p-2">
                                    <h5 class="card-title">
                                        <a href="{{ route('group', ['id' => $group->id]) }}" class="text-info">{{ $group->name }}</a>
                                    </h5>
                                    <p class="mb-1 text-primary">Members: {{ $group->users_count }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('join.group', ['id' => $group->id]) }}" class="btn btn-sm btn-outline-success rounded-pill">Join</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- المجموعات المشتركة -->
            <div id="joinedGroups" class="row mb-4 align-items-center">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @if($groupsJoined->isEmpty())
                        <p class="text-center w-100">You haven't joined any groups yet.</p>
                    @else
                        @foreach($groupsJoined as $group)
                            <div class="card me-3 shadow-sm" style="width: 14rem; border-radius: 15px;">
                                <img src="{{ asset($group->image) }}" class="card-img-top img-fluid" style="height: 120px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;" alt="{{ $group->name }}">
                                <div class="card-body d-flex flex-column p-2">
                                    <h5 class="card-title">
                                        <a href="{{ route('group', ['id' => $group->id]) }}" class="text-info">{{ $group->name }}</a>
                                    </h5>
                                    <p class="mb-1 text-primary">Members: {{ $group->users_count }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('join.group', ['id' => $group->id]) }}" class="btn btn-sm btn-outline-secondary rounded-pill">Joined</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="row mb-4 align-items-center">
                <h4 class="text-center w-100 mb-3">All Groups</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @if($groupsNotJoined->isEmpty())
                        <p class="text-center w-100">No available groups at the moment.</p>
                    @else
                        @foreach($groupsNotJoined as $group)
                            <div class="card me-3 shadow-sm" style="width: 14rem; border-radius: 15px;">
                                <img src="{{ asset($group->image) }}" class="card-img-top img-fluid" style="height: 120px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;" alt="{{ $group->name }}">
                                <div class="card-body d-flex flex-column p-2">
                                    <h5 class="card-title">
                                        <a href="{{ route('group', ['id' => $group->id]) }}" class="text-info">{{ $group->name }}</a>
                                    </h5>
                                    <p class="mb-1 text-primary">Members: {{ $group->users_count }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('delete.group', ['group_id' => $group->id]) }}" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Are you sure you want to delete this group?')"><i class="bi bi-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var showJoinedGroupsButton = document.getElementById('showJoinedGroups');
            var showNotJoinedGroupsButton = document.getElementById('showNotJoinedGroups');
            var joinedGroupsSection = document.getElementById('joinedGroups');
            var notJoinedGroupsSection = document.getElementById('notJoinedGroups');

            showJoinedGroupsButton.addEventListener('click', function() {
                joinedGroupsSection.style.display = 'block';
                notJoinedGroupsSection.style.display = 'none';
            });

            showNotJoinedGroupsButton.addEventListener('click', function() {
                notJoinedGroupsSection.style.display = 'block';
                joinedGroupsSection.style.display = 'none';
            });

            // عرض المجموعات المشتركة عند التحميل الافتراضي
            joinedGroupsSection.style.display = 'block';
            notJoinedGroupsSection.style.display = 'none';
        });
    </script>
@endsection
