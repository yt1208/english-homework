@extends('layouts.app') <!-- レイアウトを継承 -->

@section('title', 'Homework List') <!-- タイトル部分 -->

@section('content') <!-- コンテンツ部分 -->

<h1>Homework List</h1>                                                                                                 
<div>
    <h2>宿題の修正</h2>
      <form action="{{ route('homeworks.update', ['homework' => $homework->id]) }}" method="POST">
         @csrf
         @method('PUT')
        <input type="hidden" name="id" value="{{$homework->id}}">
        <p>
             科目：  <select 
             <select name="subject_id" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id', $homework->subject_id) == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            </select>  
        </p>
         <p>
             宿題の内容：<input type="text" name="title" value="{{$homework->title}}">
         </p>
         <p>
             期限：<input type="text" name="deadline" value="{{$homework->deadline}}">
         </p>
         <input type="submit" name="edit" value="修正">
     </form>
     <a href="/homeworks">戻る</a>
 </div>
 @endsection