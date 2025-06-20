@extends('layouts.app')

@section('title', 'Mensagens - ' . $project->title)

@section('content')
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">Mensagens</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Projeto: <span class="font-medium">{{ $project->title }}</span>
                        @if (isset($proposal) && $proposal)
                            | Status: <span class="font-medium">{{ $proposal->status }}</span>
                        @endif
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('freelancer.projects.show', $project) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Voltar para o projeto
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Lista de mensagens -->
            <div class="lg:col-span-2">
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        @if ($messages->isEmpty())
                            <p class="text-gray-500">Nenhuma mensagem ainda.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($messages as $message)
                                    <div
                                        class="p-4 border rounded-lg {{ $message->user_id == Auth::id() ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="font-medium text-gray-900">
                                                {{ $message->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $message->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <p class="text-gray-800 whitespace-pre-line">{{ $message->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Formulário de nova mensagem -->
                <div class="mt-6 overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <form action="{{ route('messages.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">Nova Mensagem</label>
                                <textarea name="content" id="content" rows="3"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enviar Mensagem
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informações do projeto -->
            <div>
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detalhes do Projeto</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->status }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Prazo</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->deadline->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Valor</h4>
                                <p class="mt-1 text-sm text-gray-900">R$ {{ number_format($project->budget, 2, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Descrição</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações da proposta -->
                @if (isset($proposal) && $proposal)
                    <div class="mt-6 overflow-hidden bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Sua Proposta</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Valor Proposto</h4>
                                    <p class="mt-1 text-sm text-gray-900">R$
                                        {{ number_format($proposal->budget, 2, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Prazo de Entrega</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $proposal->deadline->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Mensagem</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $proposal->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
