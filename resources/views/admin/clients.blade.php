@extends('layouts.app')

@section('content')
    <h2>Invite New Client</h2>
	@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

    <form action="{{ route('admin.invite.client') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Client Name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email"  required>
        </div>
        <button type="submit" class="btn btn-primary">Send Invitation</button>
    </form>

    <h3 class="mt-4">Invited Clients</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Client Name</th>
				<th>Users</th>
                <th>Total Generated Urls</th>
                <th>Total Url Hits</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->users_count }}</td>
                    <td>{{ $client->urls_count }}</td>
                    <td>{{ $client->urls_sum_hits ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
