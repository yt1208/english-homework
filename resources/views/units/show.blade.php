@extends('layouts.app')

@section('title', $unit->name)

@section('content')
    <h2>{{ $unit->name }}</h2>
    <p>{!! nl2br(e($description)) !!}</p>
    <div class="mt-4">
    <a href="{{ route('grammar.index', ['slug' => $unit->slug]) }}" class="btn btn-primary">テストする</a>
    <a href="{{ route('units.index') }}" class="btn btn-primary">単元一覧に戻る</a>
    </div>
@endsection
