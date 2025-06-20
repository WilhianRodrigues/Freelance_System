@extends('layouts.app')

@section('title', 'Propostas Recebidas')

@section('content')
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">Propostas Recebidas</h1>
            <p class="mt-2 text-sm text-gray-600">Lista de todas as propostas recebidas para seus projetos</p>
        </div>

        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                @if ($proposals->isEmpty())
                    <p class="text-gray-500">Nenhuma proposta recebida ainda.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Projeto</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Freelancer</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Valor</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Prazo</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($proposals as $proposal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $proposal->project->title }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                                <dt class="text-sm font-medium text-gray-500">Freelancer</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    @if ($proposal->freelancer)
                                                        <a href="{{ route('freelancer.public.profile', $proposal->freelancer->id) }}"
                                                            class="text-blue-600 hover:underline">
                                                            {{ $proposal->freelancer->name }}
                                                        </a>
                                                    @else
                                                        Freelancer não disponível
                                                    @endif
                                                </dd>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">R$
                                                {{ number_format($proposal->budget, 2, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $proposal->deadline->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'accepted' => 'bg-green-100 text-green-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusText = [
                                                    'pending' => 'Pendente',
                                                    'accepted' => 'Aceita',
                                                    'rejected' => 'Rejeitada',
                                                    'completed' => 'Concluída',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusClasses[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusText[$proposal->status] ?? $proposal->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            <a href="{{ route('cliente.proposals.show', $proposal) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $proposals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
