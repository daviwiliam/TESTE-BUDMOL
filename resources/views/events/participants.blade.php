@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
    <div class="participante-container">
        <h2 class="participante-title">Participantes</h2>
        
        <table class="participante-table">
            <thead>
                <tr>
                    <th class="column-name">Nome</th>
                    <th class="column-email">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participantes as $participante)
                    <tr>
                        <td>{{ $participante->name }}</td>
                        <td>{{ $participante->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
