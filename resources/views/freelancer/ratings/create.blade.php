@extends('layouts.app')

@section('title', 'Avaliar Cliente')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Avaliar Cliente</h1>

        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="mb-4 text-xl font-semibold">Projeto: {{ $project->title }}</h2>
            <p class="mb-6">Você está avaliando: <span class="font-medium">{{ $project->client->name }}</span></p>

            <form method="POST" action="{{ route('freelancer.ratings.store_client', $project) }}">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 text-gray-700">Nota (1-5)</label>
                    <div class="flex space-x-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="score" value="{{ $i }}" class="sr-only peer"
                                    required>
                                <div
                                    class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full peer-checked:bg-indigo-600 peer-checked:text-white">
                                    {{ $i }}
                                </div>
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="mb-6">
                    <label for="comment" class="block mb-2 text-gray-700">Comentário (opcional)</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full px-3 py-2 border rounded-lg"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('cliente.projects.show', $project) }}" class="px-4 py-2 border rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Enviar Avaliação
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
