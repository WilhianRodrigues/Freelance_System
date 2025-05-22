@extends('layouts.app')

@section('content')
    <h1 class="mb-4 text-3xl font-bold">Bem-vindo, Freelancer!</h1>

    <div class="mb-6 space-x-2">
        <a href="{{ route('freelancer.perfil.show') }}"
            class="inline-block px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            Visualizar Perfil
        </a>

        <a href="{{ route('freelancer.perfil.edit') }}"
            class="inline-block px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-600">
            Editar Perfil
        </a>
    </div>


    <h2 class="mb-2 text-2xl font-semibold">Projetos Disponíveis</h2>

    @if ($projects->isEmpty())
        <p class="text-gray-600">Nenhum projeto disponível no momento.</p>
    @else
        @foreach ($projects as $project)
            <div class="p-4 mb-4 bg-white rounded shadow">
                <h3 class="text-xl font-bold">{{ $project->title }}</h3>
                <p>{{ $project->description }}</p>
                <p class="text-sm text-gray-500">Orçamento: R$ {{ number_format($project->budget, 2, ',', '.') }}</p>
                <a href="{{ route('proposals.create', ['project' => $project->id]) }}"
                    class="inline-block px-3 py-1 mt-2 text-white bg-green-600 rounded hover:bg-green-700">
                    Enviar Proposta
                </a>
            </div>
        @endforeach
    @endif
@endsection
