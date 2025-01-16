@extends('layouts.app')

@section('title', $unit->name . ' - テスト')

@section('content')
    <h1>{{ $unit->name }} - テストページ</h1>
    <p>ここに{{ $unit->name }}に関するテストを表示します。</p>
    
    <!-- ここにテスト内容や問題を追加する -->
    <form method="post" action="{{ route('units.grammerChatGPT', $unit->slug) }}">
        @csrf
        <div>
            <label>問題 1: 例題</label><br>
            <input type="radio" name="question1" value="a"> A. 回答1<br>
            <input type="radio" name="question1" value="b"> B. 回答2<br>
        </div>

        <div>
            <label>問題 2: 例題</label><br>
            <input type="radio" name="question2" value="a"> A. 回答1<br>
            <input type="radio" name="question2" value="b"> B. 回答2<br>
        </div>

        <button type="submit">テストを提出</button>
    </form>
@endsection
