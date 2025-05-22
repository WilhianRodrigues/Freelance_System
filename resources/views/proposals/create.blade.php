<!-- resources/views/proposals/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="py-6 mx-auto max-w-7xl">
        <h1 class="mb-6 text-3xl font-bold">Enviar Proposta</h1>

        <div class="p-6 bg-white shadow sm:rounded-lg">
            <form action="{{ route('proposals.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="project_id" class="block text-sm font-medium text-gray-700">Projeto</label>
                    <select name="project_id" id="project_id"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="value" class="block text-sm font-medium text-gray-700">Valor</label>
                    <input type="text" name="value" id="value"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="deadline" class="block text-sm font-medium text-gray-700">Prazo</label>
                    <input type="date" name="deadline" id="deadline"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700">Mensagem</label>
                    <textarea name="message" id="message" rows="4"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required></textarea>
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 font-semibold text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Enviar Proposta
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
