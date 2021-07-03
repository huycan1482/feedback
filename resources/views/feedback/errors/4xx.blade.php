@extends('feedback.layouts.main')

@section('css')
<link rel="stylesheet" href="feedback/css/404.css">
@endsection

@section('content')
<div class="container">
    <div class="error-div">
        <h1>{{ $status }}</h1>
        <p>{{ $msg }}</p>
    </div>
</div>
@endsection