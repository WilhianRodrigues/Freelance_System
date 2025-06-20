@extends('layouts.app')

@section('title', 'Editar Perfil - Freelancer')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Editar Perfil</h1>

        @if (session('success'))
            <div class="p-4 mb-6 text-green-800 bg-green-100 border border-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-6 text-red-800 bg-red-100 border border-red-200 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-800 bg-red-100 border border-red-200 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('freelancer.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">

                <!-- Campos comuns -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="name">Nome</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Profissão -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="profession">Profissão</label>
                    <input type="text" name="profession" id="profession"
                        value="{{ old('profession', $freelancer->profession) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('profession')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="bio">Bio</label>
                    <textarea name="bio" id="bio" rows="4"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $freelancer->bio) }}</textarea>
                    @error('bio')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Habilidades -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="skills">Habilidades (separadas por vírgula)</label>
                    <input name="skills" value="{{ old('skills', $freelancer->skills) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Ex: PHP, Laravel, JavaScript">
                    @error('skills')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Portfólio -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="portfolio_url">URL do Portfólio</label>
                    <input type="url" name="portfolio_url" id="portfolio_url"
                        value="{{ old('portfolio_url', $freelancer->portfolio_url) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://meuportifolio.com">
                    @error('portfolio_url')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Valor por hora -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="hourly_rate">Valor por hora (R$)</label>
                    <input type="number" step="0.01" name="hourly_rate" id="hourly_rate"
                        value="{{ old('hourly_rate', $freelancer->hourly_rate) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('hourly_rate')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6 space-x-4">
                <a href="{{ route('freelancer.dashboard') }}"
                    class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Atualizar Perfil
                </button>
            </div>
        </form>
    </div>
@endsection
