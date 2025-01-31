@extends('layouts.app')

@section('content')
    <h2>Invite New Team Member</h2>
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
    <form action="{{ route('client.invite.team') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Send Invitation</button>
    </form>

    <h3 class="mt-4">Team Members</h3>
    <table class="table">
        <thead>
            <tr>
			    <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Total Generated Urls</th>
                <th>Total Url Hits</th>
            </tr>
        </thead>
        <tbody>
            @foreach($team as $member)
                <tr>
                    <td>{{ preg_replace('/@.*$/', '', ucfirst($member->email)) }}</td> 
                    <td>{{ $member->email }}</td>
                    <td>{{ ucfirst($member->role) }}</td>
                    <td>{{ $member->urls_count*2 }}</td> 
                    <td>{{ $member->urls_sum_hits }}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
