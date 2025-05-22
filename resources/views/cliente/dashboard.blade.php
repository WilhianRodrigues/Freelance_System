@extends('layouts.app')

@section('content')
    <div class="container p-6 mx-auto">
        <h1 class="text-2xl font-bold text-gray-900">Bem-vindo ao Painel do Cliente</h1>

        <div class="p-4 mt-4 bg-white rounded-md shadow-md">
            <h1>Área do Cliente</h1>
            <a href="{{ route('cliente.projetos.create') }}">Criar Projeto</a>
            <a href="{{ route('cliente.projetos.index') }}">Listar/Editar/Deletar Projetos</a>

        </div>
    </div>
@endsection
