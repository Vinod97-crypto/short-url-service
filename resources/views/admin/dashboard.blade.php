@extends('layouts.app')

@section('content')
    <h2>Super Admin Dashboard</h2>
    <a href="{{ route('admin.clients') }}" class="btn btn-primary">Manage Clients</a>
    <a href="{{ route('admin.urls') }}" class="btn btn-secondary">View All URLs</a>
@endsection
