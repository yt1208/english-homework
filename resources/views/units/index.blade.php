@extends('layouts.app')

@section('title', '学習単元一覧')

@section('content')
<div class="container">
    <h1 class="mb-4 text-start">英検５級の文法</h1>

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
                <a href="{{ url('/units/' . $unit->slug) }}" class="btn text-white" style="background-color: #68a5da;">
                     学習開始
                </td>
                <td>
                <a href="{{ route('grammar.index', ['slug' => $unit->slug]) }}" class="btn text-white" style="background-color: #fedc5e;">
                     テスト開始               
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
