@extends('layouts.app')

@section('title', 'Detalhes da Proposta - ' . $proposal->project->title)

@section('content')
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">Detalhes da Proposta</h1>
            <p class="mt-2 text-sm text-gray-600">Projeto: <span
                    class="font-medium text-indigo-600">{{ $proposal->project->title }}</span></p>
        </div>

        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <!-- Informações Básicas -->
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Informações da Proposta</h3>
                        <dl class="mt-4 space-y-4">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $statusText = [
                                            'pending' => 'Pendente',
                                            'accepted' => 'Aceita',
                                            'rejected' => 'Rejeitada',
                                            'completed' => 'Concluída',
                                            'cancelled' => 'Cancelada',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusText[$proposal->status] ?? $proposal->status }}
                                    </span>
                                </dd>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Valor Proposto</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    R$ {{ number_format($proposal->budget, 2, ',', '.') }}
                                </dd>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Prazo de Entrega</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $proposal->deadline->format('d/m/Y') }}
                                    <span class="text-xs text-gray-500">({{ $proposal->deadline->diffForHumans() }})</span>
                                </dd>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Data de Envio</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $proposal->created_at->format('d/m/Y H:i') }}
                                    <span
                                        class="text-xs text-gray-500">({{ $proposal->created_at->diffForHumans() }})</span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Detalhes do Projeto -->
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Sobre o Projeto</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Título</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $proposal->project->title }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Descrição</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $proposal->project->description }}</p>
                            </div>
                            <div>
                                <a href="{{ route('freelancer.projects.show', $proposal->project) }}"
                                    class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                    Ver detalhes completos do projeto
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mensagem -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Sua Mensagem</h3>
                    <div class="p-4 mt-4 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $proposal->message }}</p>
                    </div>
                </div>

                <!-- Ações -->
                <div
                    class="flex flex-col justify-between pt-6 mt-8 space-y-4 border-t border-gray-200 sm:flex-row sm:space-y-0 sm:items-center">
                    <a href="{{ route('freelancer.proposals.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar para minhas propostas
                    </a>

                    <div class="flex space-x-3">
                        @if ($proposal->status === 'accepted')
                            <a href="{{ route('freelancer.projects.show', $proposal->project_id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Acessar Projeto
                            </a>

                            <a href="{{ route('freelancer.projects.messages', $proposal->project_id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Mensagens
                            </a>
                        @endif


                        @if (in_array($proposal->status, ['pending', 'accepted']))
                            <form action="{{ route('freelancer.proposals.destroy', $proposal) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja cancelar esta proposta? Esta ação não pode ser desfeita.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    {{ $proposal->status === 'accepted' ? 'Cancelar Contrato' : 'Cancelar Proposta' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
