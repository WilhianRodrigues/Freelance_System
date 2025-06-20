<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gerenciamento Freelancer">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Fontes -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Assets compilados -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <title>@yield('title', 'Freelance System')</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <!-- Cabeçalho -->
        <nav class="bg-white border-b border-gray-200">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex items-center flex-shrink-0">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="ml-2 text-xl font-bold text-gray-900">Freelance System</span>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            @auth
                                @if (auth()->user()->role === 'cliente')
                                    <a href="{{ route('cliente.projects.index') }}"
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-indigo-500">
                                        Meus Projetos
                                    </a>
                                    <a href="{{ route('cliente.dashboard') }}"
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-indigo-500">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('freelancer.projects.index') }}"
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-indigo-500">
                                        Projetos
                                    </a>
                                    <a href="{{ route('freelancer.dashboard') }}"
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-indigo-500">
                                        Dashboard
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @auth
                            <div class="relative ml-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                        Sair
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Entrar</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                Cadastre-se
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="py-10">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="p-4 mb-4 rounded-md bg-green-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-4 mb-4 rounded-md bg-red-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
