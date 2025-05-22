<!DOCTYPE html>
<html class="h-full bg-white">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Cadastro</title>
</head>

<body class="h-full">
    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-2xl font-bold tracking-tight text-center text-gray-900">
                Crie sua conta
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900">Nome</label>
                    <input type="text" name="name" id="name" required
                        class="mt-2 block w-full rounded-md px-3 py-1.5 text-gray-900 outline-gray-300 focus:outline-indigo-600">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-2 block w-full rounded-md px-3 py-1.5 text-gray-900 outline-gray-300 focus:outline-indigo-600">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Senha</label>
                    <input type="password" name="password" id="password" required
                        class="mt-2 block w-full rounded-md px-3 py-1.5 text-gray-900 outline-gray-300 focus:outline-indigo-600">
                </div>

                <!-- Campo de confirmação de senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirmar
                        Senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-2 block w-full rounded-md px-3 py-1.5 text-gray-900 outline-gray-300 focus:outline-indigo-600">
                </div>

                <div>
                    <label for="tipo_usuario" class="block text-sm font-medium text-gray-900">Tipo de conta</label>
                    <select name="role" id="tipo_usuario" required
                        class="mt-2 block w-full rounded-md px-3 py-1.5 text-gray-900 outline-gray-300 focus:outline-indigo-600">
                        <option value="">Selecione</option>
                        <option value="cliente">Cliente</option>
                        <option value="freelancer">Freelancer</option>
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="flex justify-center w-full px-3 py-3 font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-500">
                        Cadastrar
                    </button>
                </div>
            </form>



            <p class="mt-6 text-sm text-center text-gray-500">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Faça login</a>
            </p>
        </div>
    </div>
</body>

</html>
