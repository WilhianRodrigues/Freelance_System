@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Projetos Disponíveis</h1>

        @foreach ($projetos as $projeto)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $projeto->titulo }}</h5>
                    <p class="card-text">{{ $projeto->descricao }}</p>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#propostaModal{{ $projeto->id }}">Enviar Proposta</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal de Envio de Proposta -->
    @foreach ($projetos as $projeto)
        <div class="modal fade" id="propostaModal{{ $projeto->id }}" tabindex="-1"
            aria-labelledby="propostaModalLabel{{ $projeto->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="propostaModalLabel{{ $projeto->id }}">Enviar Proposta para:
                            {{ $projeto->titulo }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('freelancer.sendProposal') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="projeto_id" value="{{ $projeto->id }}">
                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor</label>
                                <input type="text" class="form-control" id="valor" name="valor" required>
                            </div>
                            <div class="mb-3">
                                <label for="prazo" class="form-label">Prazo de Entrega</label>
                                <input type="date" class="form-control" id="prazo" name="prazo" required>
                            </div>
                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Enviar Proposta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
