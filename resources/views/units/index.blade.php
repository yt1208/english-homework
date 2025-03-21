@extends('layouts.app')

@section('title', '学習単元一覧')

@section('content')
<div class="container">
    <h1 class="mb-4 text-start">英検５級 文法トレーニング</h1>

    <table class="table table-dark table-striped table-hover text-center">
        <thead>
            <tr>
                <th>UNIT</th>
                <th>STUDY</th>
                <th>TEST</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
            <tr>
                <td>{{ $unit->name }}</td>
                <td>
                <a href="{{ url('/units/' . $unit->slug) }}" class="btn btn-study">学習開始</a>
                </td>
                <td>
                <a href="{{ route('grammar.index', ['slug' => $unit->slug]) }}" class="btn btn-test">テスト開始</a>            
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
