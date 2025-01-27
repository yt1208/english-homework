@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $unit->name }} - 文法テスト</h1>

    {{-- テスト終了時の表示 --}}
    @if (Session::has('is_test_complete'))
        <div class="alert alert-success">
            <p>テストが終了しました！お疲れさまでした。</p>
        </div>
        <a href="{{ route('units.index') }}" class="btn btn-primary">単元一覧に戻る</a>
        @php
            Session::forget('is_test_complete'); // セッションフラグをクリア
        @endphp
    @else
        {{-- 現在の問題を表示 --}}
        @if (!empty($question))
            <div class="card mb-3">
                <div class="card-body">
                    <h4>問題 {{ $questionNumber }}/{{ \App\Http\Controllers\GrammarChatGPTController::MAX_QUESTIONS }}</h4>
                    <p>{{ $question }}</p>

                    {{-- 解答フォーム --}}
                    <form id="answer-form" method="POST" action="{{ route('grammar.post', ['slug' => $unit->slug, 'userId' => auth()->id()]) }}">
                        @csrf
                        <input type="hidden" name="question" value="{{ $question }}">
                        <input type="hidden" name="slug" value="{{ $unit->slug }}">
                        <div class="form-group">
                            <label for="answer">回答:</label>
                            <input type="text" name="answer" id="answer" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">送信</button>
                    </form>
                </div>
            </div>
        @endif

        {{-- 解説の表示 --}}
        @if (!empty($conversation))
            <div class="conversation-log mt-4">
                <h5>テスト履歴</h5>
                <ul class="list-group">
                    @foreach ($conversation as $entry)
                        <li class="list-group-item">{{ $entry }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 次の問題ボタン --}}
        @if (!Session::has('is_test_complete'))
            <form method="GET" action="{{ route('grammar.index', ['slug' => $unit->slug]) }}">
                <button type="submit" class="btn btn-primary mt-3">次の問題へ進む</button>
            </form>
        @endif
    @endif
</div>
@endsection

