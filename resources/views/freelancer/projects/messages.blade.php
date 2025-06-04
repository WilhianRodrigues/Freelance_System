@extends('layouts.app')

@section('title', 'Mensagens do Projeto')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="pb-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Mensagens - {{ $project->title }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Conversa com {{ $project->client->name }}</p>
                </div>
                <a href="{{ route('freelancer.projects.show', $project) }}"
                    class="inline-flex items-center px-3 py-1 text-sm text-indigo-600 rounded-md bg-indigo-50 hover:bg-indigo-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar ao projeto
                </a>
            </div>
        </div>

        <div class="mt-8">
            <div class="p-6 bg-white rounded-lg shadow">
                <!-- Sistema de mensagens -->
                <div class="mb-6 space-y-4 overflow-y-auto max-h-96" id="messages-container">
                    @forelse ($messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div
                                class="p-4 rounded-lg max-w-3/4 
                                {{ $message->sender_id === auth()->id()
                                    ? 'bg-indigo-100 border-indigo-200 text-indigo-800'
                                    : 'bg-gray-100 border-gray-200 text-gray-800' }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-medium">
                                        {{ $message->sender_id === auth()->id() ? 'Você' : $message->sender->name }}
                                    </span>
                                    <span class="ml-2 text-xs text-gray-500">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <p class="whitespace-pre-wrap">{{ $message->content }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Nenhuma mensagem ainda. Inicie a conversa!</p>
                    @endforelse
                </div>

                <!-- Formulário de mensagem -->
                <form class="mt-6" method="POST" action="{{ route('projects.messages.store', $project) }}">
                    @csrf
                    <div class="flex items-start space-x-2">
                        <div class="flex-1">
                            <label for="message-content" class="sr-only">Mensagem</label>
                            <textarea id="message-content" name="content" rows="3" required
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Digite sua mensagem..."></textarea>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span class="sr-only">Enviar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Rolagem automática para a última mensagem
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('messages-container');
                container.scrollTop = container.scrollHeight;
            });

            // Opcional: Atualização periódica das mensagens (para chat em tempo real)
            // setInterval(function() {
            //     // Implementar AJAX para buscar novas mensagens
            // }, 5000);
        </script>
    @endpush
@endsection
