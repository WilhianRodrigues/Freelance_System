@extends('layouts.app')

@section('content')
    <h1>Criar Projeto</h1>
    <form method="POST" action="{{ route('cliente.projetos.store') }}">
        @csrf
        <label>Título: <input type="text" name="titulo" required></label><br>
        <label>Descrição:
            <textarea name="descricao" required></textarea>
        </label><br>
        <label>Prazo: <input type="date" name="prazo" required></label><br>
        <label>Orçamento: <input type="number" name="orcamento" step="0.01" required></label><br>
        <button type="submit">Criar</button>
    </form>
@endsection
