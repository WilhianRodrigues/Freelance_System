@extends('layouts.app')

@section('title', 'Editar Perfil - Cliente')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Editar Perfil</h1>

        <form method="POST" action="{{ route('cliente.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Campos comuns -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="name">Nome</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border rounded-lg">
                </div>

                <!-- Campos específicos do cliente -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="company_name">Empresa</label>
                    <input type="text" name="company_name" id="company_name"
                        value="{{ old('company_name', $user->company_name) }}" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-gray-700" for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>

            <div class="mt-8">
                <h2 class="mb-4 text-xl font-semibold">Avaliações</h2>

                @if ($user->ratingsReceived->isEmpty())
                    <p class="text-gray-500">Nenhuma avaliação recebida ainda.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($user->ratingsReceived as $rating)
                            @include('partials.rating', ['rating' => $rating])
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Atualizar Perfil
                </button>
            </div>
        </form>
    </div>
@endsection
