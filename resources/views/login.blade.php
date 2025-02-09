@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="container">
    <h1 class="text-center">Login</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form login-form" action="{{ route('login') }}" method="POST">
    @csrf 
        <div class="mb-3">
            <label for="student_id" class="form-label">生徒番号</label>
            <input type="text" name="student_id" id="student_id" class="form-control" placeholder="student_id" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
        </div>
        <button type="submit" class="btn btn-submit">Login</button>
    </form>
</div>
@endsection
