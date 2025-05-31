@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-semibold text-gray-800">Minhas Propostas</h1>

    @if ($proposals->isEmpty())
        <p class="text-gray-600">Você ainda não enviou nenhuma proposta.</p>
    @else
        <div class="space-y-4">
            @foreach ($proposals as $proposal)
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-bold">Projeto: {{ $proposal->project->title ?? 'Projeto não encontrado' }}</h2>
                    <p class="text-gray-600">Proposta: {{ $proposal->message }}</p>
                    <p class="text-gray-600">Valor: R$ {{ number_format($proposal->price, 2, ',', '.') }}</p>
                    <p class="text-gray-600">Status: <span class="font-semibold">{{ ucfirst($proposal->status) }}</span></p>
                </div>
            @endforeach
        </div>
    @endif
@endsection
