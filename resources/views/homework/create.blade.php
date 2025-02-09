@extends('layouts.app')

@section('title', '宿題の新規作成')

@section('content')
<div class="container" style="max-width: 500px;">
    <h1 class="text-center mb-4">宿題の新規作成</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('homeworks.store') }}">
        @csrf

        <div class="mb-3">
            <label for="subject_id" class="form-label">科目</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">宿題の内容</label>
            <input type="text" name="title" id="title" class="form-control-wide form-control" required>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">期限</label>
            <input type="date" name="deadline" id="deadline" class="form-control" style="max-width: 150px;" required>
        </div>

        <button type="submit" class="btn btn-submit">作成する</button>
    </form>
</div>
@endsection
