<h1>Homework List</h1>
<div>
    <h2>宿題の一覧</h2>
    <a href="{{ route('homeworks.create') }}">宿題を追加</a>
    <table border="1">
        <tr>
            <th>科目</th>
            <th>宿題の内容</th>
            <th>期限</th>
            <th colspan="2">操作</th>
        </tr>
            @if($homeworks->isNotEmpty())
                @foreach($homeworks as $homework)
                    <tr>
                        <td>{{ $homework->subject->name }}</td>
                        <td>{{ $homework->title }}</td>
                        <td>{{ $homework->deadline }}</td>
                        <td><a href="/edit-page/{{ $homework->id }}">編集</a></td>
                        <td><a href="/delete-page/{{ $homework->id }}">削除</a></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">宿題がありません</td>
                </tr>
            @endif
    </table>
</div>
