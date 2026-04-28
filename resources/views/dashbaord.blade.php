@extends('layouts.app')

@section('content')

<div class="card">
    <h2>Welcome to the System</h2>
    <p>This system predicts student mental health risk using AI/ML.</p>

    <a href="/predict">
        <button>Start Prediction</button>
    </a>
</div>

@endsection