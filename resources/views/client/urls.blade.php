@extends('layouts.app')

@section('content')
    <h2>Generate Short URLs</h2>

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('generate.url') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="long_url" class="form-label">Long URL</label>
            <input type="url" name="long_url" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Generate</button>
    </form>

    
	<div class="d-flex justify-content-between align-items-center mt-4">
	<h3 class="mb-0">Generated Short URLs</h3>
    <div>
        <form action="{{ route('client.urls') }}" method="GET" class="d-inline">
            <select name="filter" class="form-select d-inline w-auto" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="this_month" {{ request('filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
            </select>
        </form>
    </div>
    <a href="{{ route('client.urls.download') }}" class="btn btn-success">Download CSV</a>
</div>
  
    <table class="table">
        <thead>
            <tr>
                <th>Long URL</th>
                <th>Short URL</th>
                <th>Hits</th>
                <th>Client Name</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            @foreach($urls as $url)
                <tr>
                    <td>{{ $url->long_url }}</td>
                    <td><a href="{{ url($url->short_url) }}" target="_blank">{{ url($url->short_url) }}</a></td>
                    <td>{{ $url->hits }}</td>
                    <td>{{ $url->client ? $url->client->name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($url->created_at)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
