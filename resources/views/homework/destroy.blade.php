@extends('layouts.app')

@section('title', 'Homework List')

@section('content')
<h1 class="text-center">宿題の削除</h1>                                                                                                 
<div class="container" style="max-width: 500px;">
    
    <form action="{{ route('homeworks.destroy', ['homework' => $homework->id]) }}" method="POST" onsubmit="return confirmDelete();">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label class="form-label">科目:</label>
            <p class="form-control-plaintext text-white">{{ $homework->subject->name }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label">宿題の内容:</label>
            <p class="form-control-plaintext text-white">{{ $homework->title }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label">期限:</label>
            <p class="form-control-plaintext text-white">{{ $homework->deadline }}</p>
        </div>

        <button type="submit" class="btn btn-danger w-10">削除する</button>
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm("本当に削除しますか？");
    }
</script>
@endsection
