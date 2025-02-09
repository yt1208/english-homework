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
@endsection
