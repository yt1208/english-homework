@extends('layouts.app')

@section('content')
    <!-- Chatbot button -->
    <div class="chatbot-button">
        <button id="openChatbot">チャットボットを使う</button>
    </div>

    <!-- Chatbot window -->
    <div class="chatbot-window">
        <div class="chatbot-header">
            <p>チャットボット サポート</p>
            <button id="closeChatbot">x</button>
        </div>
        <div class="chatbot-messages" id="messages"></div>
        <div class="chatbot-input">
            <input type="text" id="userInput" placeholder="質問...">
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
