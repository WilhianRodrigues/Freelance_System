@extends('layouts.app')

@section('content')
    <h1>Seus Projetos</h1>
    <a href="{{ route('cliente.projetos.create') }}">Novo Projeto</a>
    <ul>
        @foreach ($projetos as $projeto)
            <li>
                <strong>{{ $projeto->titulo }}</strong><br>
                {{ $projeto->descricao }}<br>
                Prazo: {{ $projeto->prazo }}<br>
                Orçamento: R$ {{ $projeto->orcamento }}<br>
                <a href="{{ route('cliente.projetos.edit', $projeto->id) }}">Editar</a>
                <form method="POST" action="{{ route('cliente.projetos.destroy', $projeto->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Deletar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
