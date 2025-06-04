@extends('layouts.app')

@section('title', 'Editar Projeto')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Editar Projeto</h1>
                <p class="mt-2 text-sm text-gray-700">Atualize os detalhes do projeto abaixo.</p>
            </div>
        </div>

        <div class="mt-8">
            <!-- Mensagens de erro -->
            @if ($errors->any())
                <div class="p-4 mb-6 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Corrija os seguintes erros:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6 bg-white rounded-lg shadow">
                <form method="POST" action="{{ route('cliente.projects.update', $project->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título do Projeto</label>
                        <div class="mt-1">
                            <input type="text" name="title" id="title" required
                                value="{{ old('title', $project->title) }}"
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição Detalhada</label>
                        <div class="mt-1">
                            <textarea name="description" id="description" rows="5" required
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $project->description) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700">Prazo de Entrega</label>
                        <div class="mt-1">
                            <input type="date" name="deadline" id="deadline" required
                                value="{{ old('deadline', $project->deadline->format('Y-m-d')) }}"
                                min="{{ now()->format('Y-m-d') }}"
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700">Orçamento (R$)</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" name="budget" id="budget" step="0.01" min="0" required
                                value="{{ old('budget', $project->budget) }}"
                                class="block w-full px-3 py-2 pl-8 pr-12 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">BRL</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                </form>

                <form method="POST" action="{{ route('cliente.projects.destroy', $project->id) }}" id="deleteForm"
                    class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Excluir Projeto
                    </button>
                </form>


                <div class="flex space-x-3">
                    <a href="{{ route('cliente.dashboard') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Atualizar Projeto
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <script>
        function confirmDelete() {
            if (confirm('Tem certeza que deseja excluir este projeto? Esta ação não pode ser desfeita.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection
