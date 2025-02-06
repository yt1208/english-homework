@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $unit->name }} - 文法テスト</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- テスト終了時の表示 --}}
    @if (Session::get('is_test_complete') && empty($explanation))
        <div class="alert alert-success">
            <p>テストが終了しました！お疲れさまでした。</p>
        </div>
        <a href="{{ route('units.index') }}" class="btn btn-primary">単元一覧に戻る</a>

    @else
        {{-- 現在の問題を表示 --}}
        @if (!empty($question) && !Session::has('is_test_complete'))
            <div class="card mb-3">
                <div class="card-body">
                    <h4>問題 {{ $questionNumber ?? 1 }}/{{ config('grammarChatGPT.max_questions') }}</h4>
                    <p>{!! nl2br(e($question)) !!}</p>

                    {{-- 解答フォーム --}}
                    <form id="answer-form" method="POST" action="{{ route('grammar.post', ['slug' => $unit->slug]) }}">
                        @csrf
                        <input type="hidden" name="question" value="{{ $question }}">
                        <input type="hidden" name="questionNumber" value="{{ $questionNumber }}">
                        <div class="form-group">
                        <label for="answer">回答:</label>
                        <input type="number" name="answer" id="answer" class="form-control"
                        placeholder="1～4の半角数字を入力してください" required min="1" max="4"
                        style="max-width: 300px; text-align: center;">
                        <button type="submit" class="btn text-white mt-3" 
                         style="background-color: #F4C542; border-color: #F4C542; max-width: 150px; width: 100%;">
                        回答を送信
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- 解説の表示 --}}
        @if (!empty($explanation))
        <div class="conversation-log mt-4">
            <h5>解説</h5>
            <ul class="list-group">
            <li class="list-group-item">{{ $explanation }}</li>
            </ul>
        </div>
        @endif

        {{-- 最後の問題の解説を表示し、終了ボタンを出す --}}
        @if (Session::has('is_test_complete'))
            <div class="alert alert-info">
                <p>これで最後の問題です。お疲れさまでした！</p>
                <a href="{{ route('units.index') }}" class="btn btn-primary">単元一覧に戻る</a>
            </div>
        @endif

        {{-- 次の問題ボタン --}}
        @if (!Session::has('is_test_complete') && !empty($question))
            <form method="GET" action="{{ route('grammar.index', ['slug' => $unit->slug]) }}">
                <input type="hidden" name="questionNumber" value="{{ $questionNumber }}">
                <button type="submit" class="btn btn-primary mt-3">次の問題へ進む</button>
            </form>
        @endif
    @endif
</div>
@endsection

