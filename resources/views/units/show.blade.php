@extends('layouts.app')

@section('title', $unit->name)

@section('content')
<div class="container">
    <h1 class="text-center">{{ $unit->name }}</h1>
    <p class="description">{!! nl2br(e($description)) !!}</p>

    <div class="mt-4">
        <a href="{{ route('units.index') }}" class="btn btn-back">単元一覧に戻る</a>
        <a href="{{ route('grammar.index', ['slug' => $unit->slug]) }}" class="btn btn-test">テストする</a>
    </div>

    <!-- Chatbot button -->
    <div class="chatbot-button">
        <button id="openChatbot">{{ $unit->name }}について質問する</button>
    </div>

    <!-- Chatbot window -->
    <div class="chatbot-window">
        <div class="chatbot-header">
            <p>チャットボット サポート</p>
            <button id="closeChatbot">x</button>
        </div>
        <div class="chatbot-messages" id="messages"></div>
        <div class="chatbot-input">
            @if ($errors->has('message'))
                <div class="alert alert-danger">
                    {{ $errors->first('message') }}
                </div>
            @endif
            <input type="text" id="userInput" placeholder="質問..." maxlength="150">
            <button id="sendMessage">送信</button>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#openChatbot').click(function() {
                $('#openChatbot').fadeOut();
                $('.chatbot-window').fadeIn();
            });

            $('#closeChatbot').click(function() {
                $('.chatbot-window').fadeOut();
                $('#openChatbot').fadeIn();
            });

            $('#sendMessage').click(function() {
                let message = $('#userInput').val();
                $('#messages').append('<div>あなた: ' + message + '</div>');
                $.post( "{{ route('ask') }}" , { message: message }, function(data) {
                    $('#messages').append('<div>Bot: ' + data + '</div>');
                });
                $('#userInput').val(''); 
            });
        });
    </script>

@endsection
