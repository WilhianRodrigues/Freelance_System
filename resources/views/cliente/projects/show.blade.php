@extends('layouts.app')

@section('title', 'Detalhes do Projeto')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Detalhes do Projeto</h1>
                <p class="mt-2 text-sm text-gray-700">Informações completas sobre o projeto e propostas recebidas.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('cliente.projects.edit', $project->id) }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Editar Projeto
                </a>
            </div>
        </div>

        <div class="mt-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $project->title }}</h3>
                    <p class="max-w-2xl mt-1 text-sm text-gray-500">Criado em:
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
                                    {{ $project->status === 'open' ? 'Aberto' : 'Fechado' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Seção de Propostas -->
            @if ($project->proposals_count > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900">Propostas Recebidas</h2>
                    <div
                        class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        Freelancer</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Valor</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Prazo</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Ações</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($project->proposals as $proposal)
                                    <tr>
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $proposal->freelancer->user->name }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            R$ {{ number_format($proposal->value, 2, ',', '.') }}
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
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-4 mt-8 text-center bg-white rounded-lg shadow">
                    <p class="text-gray-500">Nenhuma proposta recebida ainda.</p>
                </div>
            @endif

            <div class="flex justify-end mt-8">
                <a href="{{ route('cliente.projects.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Voltar para lista de projetos
                </a>
            </div>
        </div>
    </div>
@endsection
