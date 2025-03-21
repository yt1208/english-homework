@extends('layouts.app')

@section('title', 'Homework List')

@section('content')

<script>
    function confirmDelete() {
        return confirm("本当に削除しますか？");
    }
</script>

<div class="container">
    <h1 class="text-center">Homework List</h1>

    <div class="mb-3 text-end">
        <a href="{{ route('homeworks.create') }}" class="btn btn-create">新規作成</a>
    </div>

    <table class="table table-dark table-striped table-hover text-center">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Content</th>
                <th>Deadline</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($homeworks->isNotEmpty())
                @foreach($homeworks as $homework)
                    <tr>
                        <td>{{ $homework->subject->name }}</td>
                        <td>{{ $homework->title }}</td>
                        <td>{{ $homework->deadline }}</td>
                        <td>
                            <a href="{{ route('homeworks.edit', ['homework' => $homework->id]) }}" class="btn btn-edit">編集</a>
                        </td>
                        <td>
                            <form action="{{ route('homeworks.destroy', ['homework' => $homework->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">宿題がありません</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
