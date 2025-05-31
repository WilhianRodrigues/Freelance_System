@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Editar Perfil</h1>
                <p class="mt-2 text-sm text-gray-700">Atualize suas informações profissionais.</p>
            </div>
        </div>

        <div class="mt-8">
            @if ($errors->any())
                <div class="p-4 mb-6 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Corrija os seguintes erros:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6 bg-white rounded-lg shadow">
                <form method="POST" action="{{ route('freelancer.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="profession" class="block text-sm font-medium text-gray-700">Profissão</label>
                        <div class="mt-1">
                            <input type="text" name="profession" id="profession" required
                                value="{{ old('profession', $freelancer->profession) }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700">Biografia</label>
                        <div class="mt-1">
                            <textarea name="bio" id="bio" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('bio', $freelancer->bio) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label for="skills" class="block text-sm font-medium text-gray-700">Habilidades</label>
                        <div class="mt-1">
                            <select name="skills[]" id="skills" multiple
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill }}"
                                        {{ in_array($skill, old('skills', json_decode($freelancer->skills) ?? [])) ? 'selected' : '' }}>
                                        {{ $skill }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Mantenha pressionado Ctrl (Windows) ou Command (Mac) para
                                selecionar múltiplas habilidades.</p>
                        </div>
                    </div>

                    <div>
                        <label for="portfolio_url" class="block text-sm font-medium text-gray-700">Portfólio (URL)</label>
                        <div class="mt-1">
                            <input type="url" name="portfolio_url" id="portfolio_url"
                                value="{{ old('portfolio_url', $freelancer->portfolio_url) }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="hourly_rate" class="block text-sm font-medium text-gray-700">Valor por Hora (R$)</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" name="hourly_rate" id="hourly_rate" step="0.01" min="0"
                                value="{{ old('hourly_rate', $freelancer->hourly_rate) }}"
                                class="block w-full px-3 py-2 pl-8 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('freelancer.dashboard') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Atualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
