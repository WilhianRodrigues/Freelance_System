<!-- resources/views/proposals/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="py-6 mx-auto max-w-7xl">
        <h1 class="mb-6 text-3xl font-bold">Detalhes da Proposta</h1>

        <div class="p-6 bg-white shadow sm:rounded-lg">
            <div class="mb-4">
                <strong class="text-gray-700">Projeto:</strong>
                <p class="text-gray-900">{{ $proposal->project->title }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Valor:</strong>
                <p class="text-gray-900">{{ $proposal->value }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Prazo:</strong>
                <p class="text-gray-900">{{ $proposal->deadline }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Mensagem do Freelancer:</strong>
                <p class="text-gray-900">{{ $proposal->message }}</p>
            </div>

            <div class="mb-4">
                <strong class="text-gray-700">Status:</strong>
                <p class="text-gray-900">{{ $proposal->status }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('proposals.index') }}" class="text-indigo-600 hover:text-indigo-900">Voltar para a lista
                    de propostas</a>
            </div>
        </div>
    </div>
@endsection
