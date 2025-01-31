@extends('layouts.app')

@section('content')
    <h2>Client Admin Dashboard</h2>
    <a href="{{ route('client.team') }}" class="btn btn-primary">Manage Team</a>
    <a href="{{ route('client.urls') }}" class="btn btn-secondary">View Short URLs</a>
@endsection
