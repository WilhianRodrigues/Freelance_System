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
                    <!-- Informações da Proposta -->
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Informações da Proposta</h3>
                        <dl class="mt-4 space-y-4">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Freelancer</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="text-sm text-gray-900">
                                        {{ optional($proposal->freelancer)->name ?? 'Freelancer não disponível' }}
                                    </div>
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
                                </dd>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($proposal->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Mensagem do Freelancer -->
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Mensagem do Freelancer</h3>
                        <div class="p-4 mt-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-800 whitespace-pre-line">{{ $proposal->message }}</p>
                        </div>
                    </div>
                </div>



                <!-- Ações -->
                <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-200">
                    <a href="{{ route('cliente.proposals.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Voltar para lista de propostas
                    </a>

                    @if ($proposal->status === 'pending')
                        <div class="flex space-x-3">
                            <form action="{{ route('cliente.proposals.accept', $proposal) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Aceitar Proposta
                                </button>
                            </form>
                            <form action="{{ route('cliente.proposals.reject', $proposal) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Rejeitar Proposta
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
