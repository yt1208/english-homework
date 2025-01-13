<!DOCTYPE html>
<html>
<head>
    <title>My英単語帳</title>
</head>
<body>
    <h1>My英単語帳</h1>
    <a href="{{ route('vocabularies.create') }}">新しい単語を追加</a>
    <table border="1">
        <thead>
            <tr>
                <th>単語</th>
                <th>意味</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vocabularies as $vocabulary)
            <tr>
                <td>{{ $vocabulary->word }}</td>
                <td>{{ $vocabulary->meaning }}</td>
                <td>
                    <a href="{{ route('vocabularies.edit', $vocabulary->id) }}">編集</a>
                    <form action="{{ route('vocabularies.destroy', $vocabulary->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
