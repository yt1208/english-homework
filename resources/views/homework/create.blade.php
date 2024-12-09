<h1>ToDo List</h1>                                                                                                 
<div>
    <h2>タスクを追加</h2>
    <form method="POST" action="/create">
        @csrf
        <p>
            科目：<input type="text" name="name">
        </p>
        <p>
            宿題の内容：<input type="text" name="title">
        </p>
        <p>
            期限：<input type="text" name="deadline">
        </p>
        <input type="submit" name="create" value="追加">
    </form>
    <a href="/homeworks">戻る</a>
</div>
