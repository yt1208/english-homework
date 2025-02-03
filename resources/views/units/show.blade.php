@extends('layouts.app')

@section('title', $unit->name)

@section('content')
    <h2>{{ $unit->name }}</h2>
    <p>{!! nl2br(e($description)) !!}</p>
    <a href="{{ route('units.index') }}">単元一覧に戻る</a>
@endsection
