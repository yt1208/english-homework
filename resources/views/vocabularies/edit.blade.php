@extends('layouts.app')

@section('title', '英単語の編集')

@section('content')

<div class="container">
    <h1 class="mb-4 text-center">英単語の編集</h1>

    <div class="form-container">
        <form action="{{ route('vocabularies.update', $vocabulary->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="word" class="form-label">単語：</label>
                <input type="text" name="word" class="form-control form-control-wide" value="{{ $vocabulary->word }}" required>
            </div>

            <div class="mb-3">
                <label for="meaning" class="form-label">意味：</label>
                <textarea name="meaning" class="form-control form-control-wide" rows="3" required>{{ $vocabulary->meaning }}</textarea>
            </div>

            <button type="submit" class="btn btn-edit">更新する</button>
        </form>
    </div>
</div>

@endsection
