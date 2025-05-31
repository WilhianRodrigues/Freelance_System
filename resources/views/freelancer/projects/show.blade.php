@extends('layouts.app')

@section('title', 'Detalhes do Projeto')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Detalhes do Projeto</h1>
                <p class="mt-2 text-sm text-gray-700">Informações completas sobre o projeto.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('freelancer.proposals.create', $project->id) }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Enviar Proposta
                </a>
            </div>
        </div>

        <div class="mt-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $project->title }}</h3>
                    <p class="max-w-2xl mt-1 text-sm text-gray-500">Publicado em:
                        {{ $project->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Descrição</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->description }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Orçamento</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">R$
                                {{ number_format($project->budget, 2, ',', '.') }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prazo</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $project->deadline->format('d/m/Y') }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $project->status === 'open' ? 'text-green-800 bg-green-100' : 'text-gray-800 bg-gray-100' }}">
                                    {{ $project->status === 'open' ? 'Aberto para propostas' : 'Fechado' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <a href="{{ route('freelancer.projects.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Voltar para lista de projetos
                </a>
            </div>
        </div>
    </div>
@endsection
