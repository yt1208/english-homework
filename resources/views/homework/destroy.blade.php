@extends('layouts.app')

@section('title', '宿題の削除')

@section('content')
<h1 class="text-center">宿題の削除</h1>                                                                                                 
<div class="form-container">
    
    <form action="{{ route('homeworks.destroy', ['homework' => $homework->id]) }}" method="POST" onsubmit="return confirmDelete();">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label class="form-label">科目:</label>
            <p class="form-control-plaintext">{{ $homework->subject->name }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label">宿題の内容:</label>
            <p class="form-control-plaintext">{{ $homework->title }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label">期限:</label>
            <p class="form-control-plaintext">{{ $homework->deadline }}</p>
        </div>

        <button type="submit" class="btn btn-delete">削除する</button>
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm("本当に削除しますか？");
    }
</script>
@endsection
