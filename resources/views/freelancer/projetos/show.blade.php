@extends('layouts.app')

@section('content')
    <h1>{{ $projeto->titulo }}</h1>
    <p>{{ $projeto->descricao }}</p>
    <p>Prazo: {{ $projeto->prazo }}</p>
    <p>Orçamento: R$ {{ $projeto->orcamento }}</p>

    <h2>Enviar Proposta</h2>
    <form method="POST" action="{{ route('freelancer.projetos.enviarProposta', $projeto->id) }}">
        @csrf
        <label>Valor (R$): <input type="number" name="valor" step="0.01" required></label><br>
        <label>Prazo estimado (em dias): <input type="number" name="prazo_estimado" required></label><br>
        <label>Mensagem:
            <textarea name="mensagem" required></textarea>
        </label><br>
        <button type="submit">Enviar Proposta</button>
    </form>
@endsection
