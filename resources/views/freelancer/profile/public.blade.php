@extends('layouts.app')

@section('title', 'Perfil - Freelancer')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        @if (session('success'))
            <div class="p-4 mb-6 text-green-800 bg-green-100 border border-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Meu Perfil</h1>
            <a href="{{ route('freelancer.profile.edit') }}"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Editar Perfil
            </a>
        </div> --}}

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="md:col-span-2">
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-full"></div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if ($user->freelancer->profession)
                            <p class="text-sm text-gray-500">{{ $user->freelancer->profession }}</p>
                        @endif

                        @if ($user->freelancer->skills)
                            <div>
                                <h3 class="font-medium text-gray-900">Habilidades</h3>
                                <p class="mt-1 text-gray-600">{{ $user->freelancer->skills }}</p>
                            </div>
                        @endif

                        @if ($user->freelancer->bio)
                            <div>
                                <h3 class="font-medium text-gray-900">Bio</h3>
                                <p class="mt-1 text-gray-600 whitespace-pre-line">{{ $user->freelancer->bio }}</p>
                            </div>
                        @endif

                        @if ($user->freelancer->hourly_rate)
                            <div>
                                <h3 class="font-medium text-gray-900">Valor por hora</h3>
                                <p class="mt-1 text-gray-600">R$
                                    {{ number_format($user->freelancer->hourly_rate, 2, ',', '.') }}</p>
                            </div>
                        @endif

                        @if ($user->freelancer->portfolio_url)
                            <div>
                                <h3 class="font-medium text-gray-900">Portfólio</h3>
                                <a href="{{ $user->freelancer->portfolio_url }}" target="_blank"
                                    class="mt-1 text-blue-600 hover:text-blue-800">
                                    {{ $user->freelancer->portfolio_url }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="p-6 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-lg font-medium">Estatísticas</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Projetos concluídos</p>
                            <p class="text-xl font-semibold">{{ $user->completedProjectsCount() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Avaliação média</p>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($user->averageRating()))
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600">{{ number_format($user->averageRating(), 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 mt-6 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-lg font-medium">Avaliações</h2>
                    @if ($user->ratingsReceived->isEmpty())
                        <p class="text-gray-500">Nenhuma avaliação recebida ainda.</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($user->ratingsReceived->take(3) as $rating)
                                @include('partials.rating', ['rating' => $rating])
                            @endforeach
                            @if ($user->ratingsReceived->count() > 3)
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">
                                    Ver todas as avaliações ({{ $user->ratingsReceived->count() }})
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
