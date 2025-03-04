@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
    
    <div class="event-section">
        @if(!$events->isEmpty())
            @if(isset($message))
                <p class="msg-info">{{ $message }}</p>
            @endif
            <h2 class="title">Meus eventos</h2>
            @if ($user->admin)
                <a class="event-action-btn create-btn" href="{{ route('create', ['token' => $token]) }}">Criar evento</a>
            @endif
            <div id="event-list" class="event-grid">
                @foreach($events as $event)
                <div class="event-card">
                    <h3>{{ $event['title'] }}</h3>
                    <p class="event-date">
                        📅 {{ date('d/m/Y', strtotime($event['start_date'])) }} - {{ \Carbon\Carbon::parse($event['start_date'])->format('H:i') }}
                    </p>
                    <p class="event-location">📍 {{ $event['location'] }}</p>
                    <p class="event-description">{{ $event['description'] }}</p>
                    @if($user->admin)
                        <a class="edit-btn info-btn" href="{{ route('event', ['id' => $event['id'], 'token' => $token]) }}">Editar Evento</a>
                        <a class="info-btn" href="{{ route('participants', ['id' => $event['id'], 'token' => $token]) }}">Participantes</a>
                        <a class="delete-btn" href="{{ route('delete-event', ['id' => $event['id'], 'token' => $token]) }}"><i class="bi bi-trash3-fill"></i></a>
                    @else
                        <a class="info-btn" href="{{ route('event', ['id' => $event['id'], 'token' => $token]) }}">Mais informações</a>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            @if ($user->admin)
                <a class="event-action-btn create-btn" href="{{ route('create', ['token' => $token]) }}">Criar evento</a>
            @endif
            <h2 class="msg-null">Você não possui eventos...</h2>
        @endif
    </div>
    
@endsection
