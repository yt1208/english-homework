<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $unit->name }} - 文法テスト</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .question {
            margin-bottom: 20px;
        }
        .options label {
            display: block;
            margin: 5px 0;
        }
        .result {
            margin-top: 20px;
            font-weight: bold;
        }
        .explanation {
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>{{ $unit->name }} - 文法テスト</h1>

    <div id="quiz-container">
        <div class="question">
            <p id="question-text"></p>
        </div>
        <form id="answer-form">
            <div class="options" id="options-container"></div>
            <button type="submit">回答する</button>
        </form>
        <div class="result" id="result-container"></div>
        <div class="explanation" id="explanation-container"></div>
    </div>

    <script>
        const questions = @json($questions);
        let currentQuestionIndex = 0;

        // 次の質問を読み込む
        function loadQuestion() {
            const question = questions[currentQuestionIndex];
            document.getElementById('question-text').innerText = `問題 ${currentQuestionIndex + 1}: ${question.question}`;
            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';

            question.options.forEach((option, index) => {
                const label = document.createElement('label');
                const input = document.createElement('input');
                input.type = 'radio';
                input.name = 'answer';
                input.value = option;
                label.appendChild(input);
                label.appendChild(document.createTextNode(` ${option}`));
                optionsContainer.appendChild(label);
                optionsContainer.appendChild(document.createElement('br'));
            });

            // 結果や解説をリセット
            document.getElementById('result-container').innerText = '';
            document.getElementById('explanation-container').innerText = '';
        }

        // 回答フォームの送信イベントを処理
        document.getElementById('answer-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const userAnswer = formData.get('answer');

            if (!userAnswer) {
                alert('回答を選択してください！');
                return;
            }

            const question = questions[currentQuestionIndex];
            const response = await fetch('{{ route("check-answer") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    question: question.question,
                    answer: userAnswer,
                    correct_answer: question.answer,
                }),
            });

            const result = await response.json();

            // 結果を表示
            const resultContainer = document.getElementById('result-container');
            if (result.correct) {
                resultContainer.innerText = '正解です！ 🎉';
                resultContainer.style.color = 'green';
            } else {
                resultContainer.innerText = '不正解です。 😢';
                resultContainer.style.color = 'red';
                // 解説を表示
                document.getElementById('explanation-container').innerText = `解説: ${result.explanation}`;
            }

            // 次の質問へ進む
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                setTimeout(loadQuestion, 2000); // 2秒後に次の問題を表示
            } else {
                setTimeout(() => {
                    alert('テストが終了しました！お疲れさまでした。');
                    document.getElementById('quiz-container').innerHTML = '<h2>すべての問題が終了しました！</h2>';
                }, 2000);
            }
        });

        // 初回の質問を読み込む
        loadQuestion();
    </script>
</body>
</html>
