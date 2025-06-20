@extends('layouts.app')

@section('title', 'Meu Perfil - Cliente')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        @if (session('success'))
            <div class="p-4 mb-6 text-green-800 bg-green-100 border border-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Meu Perfil</h1>
            <a href="{{ route('cliente.profile.edit') }}"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Editar Perfil
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <!-- Seção principal com informações do cliente -->
            <div class="md:col-span-2">
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-gray-200 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if ($user->client && $user->client->company_name)
                            <div>
                                <h3 class="font-medium text-gray-900">Empresa</h3>
                                <p class="mt-1 text-gray-600">{{ $user->client->company_name }}</p>
                            </div>
                        @endif

                        @if ($user->client->phone)
                            <div>
                                <h3 class="font-medium text-gray-900">Telefone</h3>
                                <p class="mt-1 text-gray-600">{{ $user->client->phone }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Seção lateral com estatísticas -->
            <div>
                <div class="p-6 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-lg font-medium">Estatísticas</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Projetos Ativos</p>
                            <p class="text-xl font-semibold">{{ $activeProjectsCount ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Propostas Recebidas</p>
                            <p class="text-xl font-semibold">{{ $proposalsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Seção de projetos recentes -->
                @if (isset($recentProjects) && $recentProjects->count() > 0)
                    <div class="p-6 mt-6 bg-white rounded-lg shadow">
                        <h2 class="mb-4 text-lg font-medium">Projetos Recentes</h2>
                        <div class="space-y-4">
                            @foreach ($recentProjects as $project)
                                <div>
                                    <h3 class="font-medium">{{ $project->title }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $project->proposals_count }} proposta(s)
                                    </p>
                                    <a href="{{ route('cliente.projects.show', $project) }}"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                        Ver detalhes
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
