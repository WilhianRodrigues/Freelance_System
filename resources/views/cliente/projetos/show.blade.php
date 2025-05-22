<!-- resources/views/projects/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="py-6 mx-auto max-w-7xl">
        <h1 class="mb-6 text-3xl font-bold">Detalhes do Projeto</h1>

        <div class="p-6 bg-white shadow sm:rounded-lg">
            <div class="mb-4">
                <strong class="text-gray-700">Título:</strong>
                <p class="text-gray-900">{{ $project->title }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Descrição:</strong>
                <p class="text-gray-900">{{ $project->description }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Orçamento:</strong>
                <p class="text-gray-900">{{ $project->budget }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Prazo:</strong>
                <p class="text-gray-900">{{ $project->deadline }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Status:</strong>
                <p class="text-gray-900">{{ $project->status }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('projects.index') }}" class="text-indigo-600 hover:text-indigo-900">Voltar para a lista de
                    projetos</a>
            </div>
        </div>
    </div>
@endsection
