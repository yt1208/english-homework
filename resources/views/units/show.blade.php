@extends('layouts.app')

@section('title', $unit->name . ' - 詳細')

@section('content')
    <h2>{{ $unit->name }}</h2>
    <p>{{ $unit->description }}</p>
    <a href="{{ route('units.index') }}">単元一覧に戻る</a>
@endsection
