@extends('layouts.app')

@section('title', 'My英単語帳')

@section('content')

<script>
    function confirmDelete() {
        return confirm("本当に削除しますか？");
    }
</script>

<div class="container">
    <h1 class="mb-4 text-start">My英単語帳</h1>

    <div class="mb-3">
        <a href="{{ route('vocabularies.create') }}" class="btn text-white" style="background-color: #4A90E2">英単語を追加する</a>
    </div>

    <table class="table table-dark table-striped table-hover text-center">
        <thead>
            <tr>
                <th>単語</th>
                <th>意味</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @if($vocabularies->isNotEmpty())
                @foreach ($vocabularies as $vocabulary)
                    <tr>
                        <td>{{ $vocabulary->word }}</td>
                        <td>{{ $vocabulary->meaning }}</td>
                        <td>
                            <a href="{{ route('vocabularies.edit', $vocabulary->id) }}" class="btn text-white" style="background-color: #F4C542">編集</a>
                            <form action="{{ route('vocabularies.destroy', $vocabulary->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">登録された単語がありません。</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
