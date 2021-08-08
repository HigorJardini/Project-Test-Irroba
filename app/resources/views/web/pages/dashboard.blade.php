@extends('web.common.content')
@section('title', 'Home')
@section('page', 'dashboard')
@section('content')

<div class="page-header">
    <h1>Home</h1>

    <div class="breadcrumb-content">
        <ol>
            <li class="breadcrumb-item active" aria-current="page"><a class="text-dark" href="{{ route('admin.dashboard') }}">Home</a></li>
        </ol>
    </div>
    
    
</div>

@endsection