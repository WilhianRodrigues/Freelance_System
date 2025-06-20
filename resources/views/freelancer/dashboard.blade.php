@extends('layouts.app')

@section('title', 'Painel do Freelancer')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Cabeçalho -->
        <div class="pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Bem-vindo, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 text-sm text-gray-600">Aqui você pode gerenciar suas propostas e encontrar novos projetos.</p>
        </div>

        <!-- Cards de Resumo -->
        <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card Propostas Ativas -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-50">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Propostas Ativas</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ $activeProposalsCount ?? auth()->user()->proposals()->where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('freelancer.proposals.index') }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Ver todas as propostas
                    </a>
                </div>
            </div>

            <!-- Card Projetos Ativos -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-green-50">
                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Projetos Ativos</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $activeProjectsCount ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('freelancer.projects.index') }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Ver meus projetos
                    </a>
                </div>
            </div>

            <!-- Card Meu Perfil -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Meu Perfil</h3>
                    <a href="{{ route('freelancer.profile.show') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Perfil
                    </a>
                </div>
                <div class="mt-4 space-y-2">
                    @if (auth()->user()->skills)
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Habilidades:</span> {{ auth()->user()->skills }}
                        </p>
                    @endif
                    @if (auth()->user()->hourly_rate)
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Valor/hora:</span> R$
                            {{ number_format(auth()->user()->hourly_rate, 2, ',', '.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Ações Rápidas -->
        <div class="p-6 mt-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">Ações Rápidas</h3>
            <div class="grid grid-cols-1 gap-3 mt-4 sm:grid-cols-2">
                <a href="{{ route('freelancer.projects.index') }}"
                    class="flex items-center p-3 text-sm font-medium text-indigo-600 rounded-md hover:bg-indigo-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Buscar Novos Projetos
                </a>
                <a href="{{ route('freelancer.proposals.index') }}"
                    class="flex items-center p-3 text-sm font-medium text-indigo-600 rounded-md hover:bg-indigo-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Gerenciar Propostas
                </a>
                <a href="{{ route('freelancer.profile.edit') }}"
                    class="flex items-center p-3 text-sm font-medium text-indigo-600 rounded-md hover:bg-indigo-50">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Perfil
                    <!--<a href="{{-- {{ route('freelancer.projects.create') }} --}}"
                                                class="flex items-center p-3 text-sm font-medium text-indigo-600 rounded-md hover:bg-indigo-50">
                                                <svg class="flex-shrink-0 w-5 h-5 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Criar Novo Projeto
                                            </a>-->
            </div>
        </div>

        <!-- Últimas Propostas -->
        @isset($recentProposals)
            <div class="mt-8">
                <h2 class="text-xl font-medium text-gray-900">Suas Propostas Recentes</h2>
                <div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Projeto</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Valor
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Prazo
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Ações</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentProposals as $proposal)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ $proposal->project->title }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500">
                                        R$ {{ number_format($proposal->budget, 2, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500">
                                        {{ $proposal->deadline->format('d/m/Y') }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500">
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $proposal->status === 'active' ? 'text-green-800 bg-green-100' : 'text-gray-800 bg-gray-100' }}">
                                            {{ $proposal->status === 'active' ? 'Ativa' : 'Inativa' }}
                                        </span>
                                    </td>
                                    <td
                                        class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                        <a href="{{ route('freelancer.proposals.show', $proposal->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 pl-4 pr-3 text-sm text-center text-gray-500 sm:pl-6">
                                        Nenhuma proposta encontrada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endisset
    </div>
@endsection
