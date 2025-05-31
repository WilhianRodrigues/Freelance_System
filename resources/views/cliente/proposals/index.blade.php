@extends('layouts.app')

@section('title', 'Propostas Recebidas')

@section('content')
    <div class="max-w-4xl py-10 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Propostas Recebidas</h1>

        @if ($propostas->isEmpty())
            <p class="text-gray-600">Nenhuma proposta recebida ainda.</p>
        @else
            <div class="space-y-4">
                @foreach ($propostas as $proposta)
                    <div class="p-4 bg-white rounded shadow">
                        <h2 class="text-lg font-semibold">{{ $proposta->projeto->title }}</h2>
                        <p><strong>Freelancer:</strong> {{ $proposta->freelancer->user->name }}</p>
                        <p><strong>Valor:</strong> R$ {{ number_format($proposta->valor, 2, ',', '.') }}</p>
                        <p><strong>Prazo:</strong> {{ \Carbon\Carbon::parse($proposta->prazo)->format('d/m/Y') }}</p>
                        <p><strong>Mensagem:</strong> {{ $proposta->mensagem }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
