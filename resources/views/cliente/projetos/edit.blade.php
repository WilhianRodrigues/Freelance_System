@extends('layouts.app') <!-- Aqui você inclui seu layout principal, se necessário -->

@section('content')
    <h1>Editar Projeto</h1>
    <form method="POST" action="{{ route('cliente.projetos.update', $projeto->id) }}">
        @csrf
        @method('PUT')
        <label>Título: <input type="text" name="titulo" value="{{ $projeto->titulo }}" required></label><br>
        <label>Descrição:
            <textarea name="descricao" required>{{ $projeto->descricao }}</textarea>
        </label><br>
        <label>Prazo: <input type="date" name="prazo" value="{{ $projeto->prazo }}" required></label><br>
        <label>Orçamento: <input type="number" name="orcamento" value="{{ $projeto->orcamento }}" step="0.01"
                required></label><br>
        <button type="submit">Atualizar</button>
    </form>
@endsection
