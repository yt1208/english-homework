@extends('layouts.app')

@section('title', '学習単元一覧')

@section('content')
    <h1>学習単元一覧</h1>
    <ul>
        @foreach ($units as $unit)
            <li>
                <a href="{{ url('/units/' . $unit->slug) }}">{{ $unit->name }}</a>
                <a href="{{ route('grammar.index', ['slug' => $unit->slug]) }}">テストページ</a>
            </li>
        @endforeach
    </ul>
@endsection
                                                                                            