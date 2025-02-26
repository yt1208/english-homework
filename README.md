<p align="center">
  <img src="https://github.com/user-attachments/assets/0521694f-9efd-4249-9955-591cab587c88" width="400" alt="単元一覧画面">
</p>

# 英検学習アプリ

このアプリは、英検5級の文法学習をサポートするためのツールです。ユーザーは、各単元に基づいた学習を行い、学習後にテストを受けて理解度の確認ができます。

![動画デモ](https://media1.giphy.com/media/v1.Y2lkPTc5MGI3NjExcWxmZXFwbTB2aDAzbjk1Y2hmeGY0eG9qdWp4Nm9seWhsZGppang5MyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/vLgGXUvXC3huTXKNIY/giphy.gif)


## 管理者機能

管理者は、**Laravel Backpack**を利用して、ユーザーの新規作成・編集・削除を行うことができます。

![バックパック管理画面](https://github.com/user-attachments/assets/72a522cd-994c-4f4b-aa8a-277b3d277b1e)

### 機能紹介

#### 1. 宿題一覧
ユーザーは自分で課題を設定できる**宿題機能**を活用できます。さらに、5科目対応で、学習塾等でのデジタル版宿題シートとしても使用可能です。

![宿題一覧画面](https://github.com/user-attachments/assets/46a8b966-4ad3-4029-b921-010c3311b98f)

#### 2. My英単語帳
分からなかった英単語や語句を**My単語帳**に登録して復習することができます。

![My単語帳画面](https://github.com/user-attachments/assets/36aa4d25-42d0-4cdb-b4ae-d7566db2bab6)

#### 3. 単元一覧ページ
各単元には学習開始ボタンがあり、ユーザーは文法の用法を学習できます。さらに、テストボタンを押すと、その単元に関連する文法テストが5問実施され、理解度を確認できます。

![単元一覧画面](https://github.com/user-attachments/assets/0521694f-9efd-4249-9955-591cab587c88)

#### 4. OpenAIによる文法問題生成と解説
**OpenAI API**を活用して、各単元に基づく**文法問題と解説を自動生成**します。これにより、ユーザーは広範な文法問題に取り組み、AIによる簡潔で分かりやすい解説を受けることができます。

### 使用技術

- **Laravel**（バックエンド）
- **MySQL**（データベース）
- **OpenAI API**（文法問題と解説の自動生成）
- **Laravel Backpack**（管理画面）
- **Bootstrap**（フロントエンド）
