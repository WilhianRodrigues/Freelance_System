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
                @if ($project->status !== 'completed')
                    <a href="{{ route('cliente.projects.edit', $project->id) }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Editar Projeto
                    </a>
                @endif
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
                                    class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $project->status === 'open' ? 'text-green-800 bg-green-100' : ($project->status === 'completed' ? 'text-blue-800 bg-blue-100' : 'text-gray-800 bg-gray-100') }}">
                                    @if ($project->status === 'open')
                                        Aberto
                                    @elseif($project->status === 'completed')
                                        Concluído
                                    @else
                                        Fechado
                                    @endif
                                </span>
                            </dd>
                        </div>
                        @if ($project->status === 'completed' && $project->acceptedProposal)
                            <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Freelancer Contratado</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $project->acceptedProposal->freelancer->name }}
                                    @if (!$project->clientHasRatedFreelancer())
                                        <div class="mt-2">
                                            <a href="{{ route('cliente.ratings.create_freelancer', $project) }}"
                                                class="inline-flex items-center px-3 py-1 text-sm text-white bg-yellow-600 rounded-md hover:bg-yellow-700">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                                Avaliar Freelancer
                                            </a>
                                        </div>
                                    @else
                                        <span class="ml-2 text-green-600">Você já avaliou este freelancer</span>
                                    @endif
                                </dd>
                            </div>
                        @endif
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
                                            {{ $proposal->freelancer->name }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            R$ {{ number_format($proposal->budget, 2, ',', '.') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $proposal->deadline->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $proposal->status === 'accepted' ? 'text-green-800 bg-green-100' : ($proposal->status === 'rejected' ? 'text-red-800 bg-red-100' : 'text-gray-800 bg-gray-100') }}">
                                                @if ($proposal->status === 'accepted')
                                                    Aceita
                                                @elseif($proposal->status === 'rejected')
                                                    Rejeitada
                                                @else
                                                    Pendente
                                                @endif
                                            </span>
                                        </td>
                                        <td
                                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                            <a href="{{ route('cliente.proposals.show', $proposal) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver</a>
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

            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('cliente.projects.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Voltar para lista de projetos
                </a>
                @if ($project->status === 'completed' && $project->acceptedProposal && !$project->clientHasRatedFreelancer())
                    <a href="{{ route('cliente.ratings.create_freelancer', $project) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Avaliar Freelancer
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
