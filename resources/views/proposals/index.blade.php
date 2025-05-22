@extends('layouts.base')

@section('content')
    <h1>Propostas para o projeto: {{ $project->title }}</h1>

    <div>
        <h2>Propostas enviadas</h2>
        @if ($proposals->isEmpty())
            <p>Não há propostas para este projeto ainda.</p>
        @else
            <ul>
                @foreach ($proposals as $proposal)
                    <li>
                        <strong>Valor:</strong> {{ $proposal->value }}<br>
                        <strong>Prazos:</strong> {{ $proposal->deadline }}<br>
                        <strong>Mensagem:</strong> {{ $proposal->message }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
