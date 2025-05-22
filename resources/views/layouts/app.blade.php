<!DOCTYPE html>
<html lang="pt-BR" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Freelance System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    <!-- Cabeçalho -->
    <header class="p-4 text-white bg-gray-800">
        <div class="container flex items-center justify-between mx-auto">
            <a href="{{ route('welcome') }}" class="text-xl font-bold">Freelancer System</a>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('cliente.projetos.index') }}" class="hover:text-gray-300">Projetos</a></li>
                    <li><a href="{{ route('proposals.all') }}" class="hover:text-gray-300">Propostas</a></li>

                    @auth
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="hover:text-gray-300">Sair</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-gray-300">Entrar</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="container flex-1 p-6 mx-auto">
        @yield('content') <!-- Aqui o conteúdo de cada página será injetado -->
    </main>

    <!-- Rodapé -->
    <footer class="p-4 text-center text-white bg-gray-800">
        <p>&copy; {{ date('Y') }} Freelancer System. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
