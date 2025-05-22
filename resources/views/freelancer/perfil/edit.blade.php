@extends('layouts.app')

@section('content')
    <h1>Editar Perfil do Freelancer</h1>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('freelancer.perfil.update') }}">
        @csrf

        <label>Profissão:</label>
        <input type="text" name="profession" value="{{ old('profession', $freelancer->profession) }}" required><br>

        <label>Biografia:</label>
        <textarea name="bio">{{ old('bio', $freelancer->bio) }}</textarea><br>

        <label>Habilidades (separadas por vírgula):</label>
        <input type="text" name="skills_input"
            value="{{ old('skills_input', implode(', ', json_decode($freelancer->skills, true))) }}"><br>

        <label>URL do Portfólio:</label>
        <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $freelancer->portfolio_url) }}"><br>

        <label>Valor por Hora (R$):</label>
        <input type="number" name="hourly_rate" step="0.01"
            value="{{ old('hourly_rate', $freelancer->hourly_rate) }}"><br>

        <input type="hidden" name="skills[]" id="skills-hidden"><br>

        <button type="submit" onclick="formatarSkills()">Salvar</button>
    </form>

    <script>
        function formatarSkills() {
            const input = document.querySelector('input[name="skills_input"]');
            const skills = input.value.split(',').map(skill => skill.trim()).filter(skill => skill.length);
            document.querySelectorAll('input[name="skills[]"]').forEach(e => e.remove());
            skills.forEach(skill => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'skills[]';
                hidden.value = skill;
                input.form.appendChild(hidden);
            });
        }
    </script>
@endsection
