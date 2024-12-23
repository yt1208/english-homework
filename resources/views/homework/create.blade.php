@extends('layouts.app') <!-- レイアウトを継承 -->

@section('title', 'Homework List') <!-- タイトル部分 -->

@section('content') <!-- コンテンツ部分 -->
<h1> Homework List</h1>                                                                                                 
<div>
    <h2>宿題の追加</h2>
    <form method="POST" action="{{ route('homeworks.store') }}">
        @csrf
        @if ($errors->any())
            <ul>
            @foreach ($errors->all() as $error)
               <li style="color:red">{{$error}}</li>
            @endforeach
            </ul>
        @endif
        <p>
            科目：  <select name="subject_id">
            @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
            </select>
        </p>
        <p>
            宿題の内容：<input type="text" name="title">
        </p>
        <p>
            期限：<input type="text" name="deadline">
        </p>
        <input type="submit" name="create" value="追加">
    </form>
    <a href="/homeworks">戻る</a>
</div>
@endsection