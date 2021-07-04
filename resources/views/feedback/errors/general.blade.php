@extends('feedback.layouts.main')

@section('css')
<link rel="stylesheet" href="feedback/css/404.css">
@endsection

@section('content')
<div class="container">
    <div class="error-general">
        <p>{{ session('message') ? session('message') : '' }}</p>
    </div>
</div>
@endsection