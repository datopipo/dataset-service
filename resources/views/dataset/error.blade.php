@extends('layouts.app')

@section('title', 'Error')

@section('content')
    <div class="alert alert-danger">
        <h2>Error</h2>
        <p>{{ $exception->getMessage() }}</p>
    </div>

@endsection
