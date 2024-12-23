<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel ToDo List')</title> <!-- ページ毎にタイトルを変える -->
    
    <!-- BootstrapのCSSを追加 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- ナビゲーションバー（任意） -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ToDo List</a>
        </div>
    </nav>

    <!-- ページのコンテンツがここに挿入されます -->
    <div class="container mt-5">
        @yield('content') <!-- 各ページのコンテンツを表示する場所 -->
    </div>

    <!-- BootstrapのJSを追加 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>