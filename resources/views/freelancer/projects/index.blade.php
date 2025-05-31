@extends('layouts.app')

@section('title', 'Projetos Disponíveis')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Projetos Disponíveis</h1>
                <p class="mt-2 text-sm text-gray-700">Lista de todos os projetos disponíveis para proposta.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('freelancer.proposals.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Minhas Propostas
                </a>
            </div>
        </div>

        <div class="mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Título</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Descrição</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Prazo</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Orçamento</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Ações</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                <a href="{{ route('freelancer.projects.show', $project->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    {{ $project->title }}
                                </a>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                {{ Str::limit($project->description, 50) }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                {{ $project->deadline->format('d/m/Y') }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                R$ {{ number_format($project->budget, 2, ',', '.') }}
                            </td>
                            <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                <a href="{{ route('freelancer.proposals.create', $project->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Enviar Proposta</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 pl-4 pr-3 text-sm text-center text-gray-500 sm:pl-6">
                                Nenhum projeto disponível no momento
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
