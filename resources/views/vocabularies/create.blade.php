<!DOCTYPE html>
<html>
<head>
    <title>新しい単語を追加</title>
</head>
<body>
    <h1>新しい単語を追加</h1>
    <form action="{{ route('vocabularies.store') }}" method="POST">
        @csrf
        <label for="word">単語:</label>
        <input type="text" name="word" required>
        <br>
        <label for="meaning">意味:</label>
        <textarea name="meaning" required></textarea>
        <br>
        <button type="submit">保存</button>
    </form>
</body>
</html>
