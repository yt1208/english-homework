<h1>Homework List</h1>                                                                                                 
<div>
    <h2>宿題を削除</h2>
    <form action="{{ route('homeworks.destroy', ['homework' => $homework->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <p>
            科目：{{$homework->subject->name}}
        </p>
        <p>
            宿題の内容：{{$homework->title}}
        </p>
        <p>
            期限：{{$homework->deadline}}
        </p>
        <input type="submit" name="delete" value="削除">
    </form>
    <a href="/homeworks">戻る</a>
</div>