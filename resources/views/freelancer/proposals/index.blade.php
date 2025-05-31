@extends('layouts.app')

@section('title', 'Minhas Propostas')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-bold text-gray-900">Minhas Propostas</h1>
                <p class="mt-2 text-sm text-gray-600">Lista de todas as propostas que você enviou.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('freelancer.projects.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Buscar Novos Projetos
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mt-6 mb-4">
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <div class="flex-1">
                    <label for="status-filter" class="sr-only">Filtrar por status</label>
                    <select id="status-filter"
                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="all">Todos os Status</option>
                        <option value="pending">Pendentes</option>
                        <option value="active">Ativas</option>
                        <option value="rejected">Rejeitadas</option>
                        <option value="completed">Concluídas</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label for="search" class="sr-only">Pesquisar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="search"
                            class="block w-full py-2 pl-10 pr-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Pesquisar projetos...">
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Projeto
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Valor
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Prazo
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Status
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Ações</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($proposals as $proposal)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('freelancer.projects.show', $proposal->project_id) }}"
                                            class="font-medium text-indigo-600 hover:text-indigo-900">
                                            {{ $proposal->project->title }}
                                        </a>
                                        <div class="text-gray-500">{{ Str::limit($proposal->project->description, 50) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                R$ {{ number_format($proposal->budget, 2, ',', '.') }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                {{ $proposal->deadline->format('d/m/Y') }}
                                <div class="text-xs text-gray-400">
                                    {{ $proposal->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $statusText = [
                                        'pending' => 'Pendente',
                                        'active' => 'Aceita',
                                        'rejected' => 'Rejeitada',
                                        'completed' => 'Concluída',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusText[$proposal->status] ?? $proposal->status }}
                                </span>
                            </td>
                            <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                <a href="{{ route('freelancer.proposals.show', $proposal) }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    Ver detalhes
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma proposta encontrada</h3>
                                <p class="mt-1 text-sm text-gray-500">Você ainda não enviou nenhuma proposta.</p>
                                <div class="mt-6">
                                    <a href="{{ route('freelancer.projects.index') }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Encontrar projetos
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginação -->
            @if ($proposals->hasPages())
                <div class="px-4 py-3 bg-gray-50 sm:px-6">
                    {{ $proposals->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
