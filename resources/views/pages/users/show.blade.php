@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <h6>Email: {{ $user->email }}</h6>
            @if (auth()->user()->role == 'admin')
                <h6>Role: {{ ucfirst($user->role) }}</h6>
            @endif

            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary mt-3">Edit Profile</a>
            @if (auth()->user()->role == 'admin')
                <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
            @endif
        </div>
    </div>
@endsection
