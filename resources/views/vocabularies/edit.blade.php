@extends('layouts.app')

@section('title', '英単語の編集')

@section('content')

<div class="container">
    <h1 class="mb-4 text-center">英単語の編集</h1>

    <div class="mx-auto" style="max-width: 500px;">
        <form action="{{ route('vocabularies.update', $vocabulary->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="word" class="form-label">単語：</label>
                <input type="text" name="word" class="form-control" value="{{ $vocabulary->word }}" required>
            </div>

            <div class="mb-3">
                <label for="meaning" class="form-label">意味：</label>
                <textarea name="meaning" class="form-control" rows="3" required>{{ $vocabulary->meaning }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="max-width: 100px;">更新する</button>
        </form>
    </div>
</div>

@endsection
