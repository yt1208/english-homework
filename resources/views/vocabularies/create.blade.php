@extends('layouts.app')

@section('title', '新しい単語の追加')

@section('content')

<div class="container">
    <h1 class="mb-4 text-center">新しい単語の追加</h1>

    <div class="mx-auto" style="max-width: 500px;">
        <form action="{{ route('vocabularies.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="word" class="form-label">単語：</label>
                <input type="text" name="word" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="meaning" class="form-label">意味：</label>
                <textarea name="meaning" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="max-width: 100px;">追加する</button>
        </form>
    </div>
</div>

@endsection
