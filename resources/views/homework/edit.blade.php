@extends('layouts.app')

@section('title', '宿題の編集')

@section('content')

<div class="container">
    <h1 class="mb-4 text-center">宿題の編集</h1>

    <div class="mx-auto" style="max-width: 500px;">
        <form action="{{ route('homeworks.update', ['homework' => $homework->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $homework->id }}">

            <div class="mb-3">
                <label for="subject_id" class="form-label">科目：</label>
                <select name="subject_id" class="form-control form-select-small" required>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $homework->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">宿題の内容：</label>
                <input type="text" name="title" class="form-control" value="{{ $homework->title }}" required>
            </div>

            <div class="mb-3">
                <label for="deadline" class="form-label">期限：</label>
                <input type="date" name="deadline" class="form-control form-input-date" value="{{ $homework->deadline }}" required>
            </div>

            <button type="submit" class="btn btn-update">宿題を更新</button>
            </form>
    </div>
</div>

@endsection
