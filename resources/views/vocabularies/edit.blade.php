<!DOCTYPE html>
<html>
<head>
    <title>単語を編集</title>
</head>
<body>
    <h1>単語を編集</h1>
    <form action="{{ route('vocabularies.update', $vocabulary->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="word">単語:</label>
        <input type="text" name="word" value="{{ $vocabulary->word }}" required>
        <br>
        <label for="meaning">意味:</label>
        <textarea name="meaning" required>{{ $vocabulary->meaning }}</textarea>
        <br>
        <button type="submit">更新</button>
    </form>
</body>
</html>
