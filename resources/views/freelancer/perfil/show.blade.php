@extends('layouts.app')

@section('content')
    <h1>Meu Perfil</h1>

    <p><strong>Profissão:</strong> {{ $freelancer->profession }}</p>

    @if ($freelancer->bio)
        <p><strong>Biografia:</strong> {{ $freelancer->bio }}</p>
    @endif

    <p><strong>Habilidades:</strong>
        @foreach (json_decode($freelancer->skills, true) as $skill)
            <span style="margin-right: 5px;">{{ $skill }}</span>
        @endforeach
    </p>

    @if ($freelancer->portfolio_url)
        <p><strong>Portfólio:</strong> <a href="{{ $freelancer->portfolio_url }}"
                target="_blank">{{ $freelancer->portfolio_url }}</a></p>
    @endif

    @if ($freelancer->hourly_rate)
        <p><strong>Valor por Hora:</strong> R$ {{ number_format($freelancer->hourly_rate, 2, ',', '.') }}</p>
    @endif

    <p><strong>Avaliação:</strong> {{ $freelancer->rating }} ⭐</p>

    <a href="{{ route('freelancer.perfil.edit') }}">Editar Perfil</a>
@endsection
