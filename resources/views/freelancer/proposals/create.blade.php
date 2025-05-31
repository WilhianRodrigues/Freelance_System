@extends('layouts.app')

@section('title', 'Enviar Proposta para ' . $project->title)

@section('content')
    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Cabeçalho -->
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900">Enviar Proposta</h1>
                <p class="mt-2 text-gray-600">Para o projeto: <span
                        class="font-medium text-indigo-600">{{ $project->title }}</span></p>
            </div>

            <!-- Card do Formulário -->
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('freelancer.proposals.store', $project) }}" method="POST">
                        @csrf

                        <!-- Mensagem -->
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensagem da
                                Proposta</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="5" required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Descreva sua proposta, abordagem e qualificações...">{{ old('message') }}</textarea>
                            </div>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Prazo -->
                            <div class="mb-6">
                                <label for="deadline" class="block text-sm font-medium text-gray-700">Prazo de
                                    Entrega</label>
                                <div class="mt-1">
                                    <input type="date" id="deadline" name="deadline"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('deadline') }}"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('deadline')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Orçamento -->
                            <div class="mb-6">
                                <label for="budget" class="block text-sm font-medium text-gray-700">Orçamento (R$)</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">R$</span>
                                    </div>
                                    <input type="number" step="0.01" id="budget" name="budget" min="0"
                                        value="{{ old('budget') }}" required
                                        class="block w-full px-3 py-2 pl-8 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="0,00">
                                </div>
                                @error('budget')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="flex items-center justify-end pt-6 mt-6 space-x-4 border-t border-gray-200">
                            <a href="{{ route('freelancer.projects.show', $project) }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enviar Proposta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
