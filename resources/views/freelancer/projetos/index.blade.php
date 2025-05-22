@extends('layouts.app')

@section('content')
    <h1>Projetos Disponíveis</h1>
    <ul>
        @foreach ($projetos as $projeto)
            <li>
                <strong>{{ $projeto->titulo }}</strong><br>
                {{ $projeto->descricao }}<br>
                <a href="{{ route('freelancer.projetos.show', $projeto->id) }}">Ver detalhes / Enviar proposta</a>
            </li>
        @endforeach
    </ul>
@endsection
