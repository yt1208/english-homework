
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel English Grammar')</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #0F0F0F;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        h1 {
            color: #43C6AC;
            font-weight: bold;
        }

        .navbar {
            background-color: #121212;
            padding: 10px 20px;
        }
        .navbar-brand {
            color: #43C6AC;
            font-weight: bold;
        }

        .container {
            max-width: 900px;
        }

        .nav-button {
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none !important;
        }

        .btn-homework {
            background: #4A90E2;
            color: white !important;
            border: none;
        }
        .btn-homework:hover {
            background: #357ABD;
        }

        .btn-vocab {
            background: #F4C542;
            color: white !important;
            border: none;
        }
        .btn-vocab:hover {
            background: #E0AC2B;
}

        .question-number, .question-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .choices li {
            font-size: 1.2rem;
            list-style-type: none;
        }

        .explanation {
            font-size: 1.2rem;
            background-color: #222222;
            padding: 10px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #43C6AC;
            border-color: #43C6AC;
        }
        .btn-primary:hover {
            background-color: #2F9E86;
            border-color: #2F9E86;
        }

        .card, .list-group-item {
            background-color: #1C1C1C;
            border: 1px solid #2E2E2E;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('units.index') }}">English Grammar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNav">
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item me-2">
                        <a class="nav-button btn-homework" href="{{ route('homeworks.index') }}">宿題の一覧</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-button btn-vocab" href="{{ route('vocabularies.index') }}">My単語帳</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
