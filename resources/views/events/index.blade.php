@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
<div class="event-section">
    <h2 class="title">Eventos Disponíveis</h2>
    <div id="event-list" class="event-grid">
        @foreach($events as $event)
        <div class="event-card">
            <h3>{{ $event['title'] }}</h3>
            <p class="event-date">
                📅 {{ date('d/m/Y', strtotime($event['start_date'])) }} - {{ \Carbon\Carbon::parse($event['start_date'])->format('H:i') }}
            </p>
            <p class="event-location">📍 {{ $event['location'] }}</p>
            <p class="event-description">{{ $event['description'] }}</p>
            @if(isset($token) && $token)
                @if($event['user_id'] == $user->id)
                    <a class="edit-btn info-btn" href="{{ route('event', ['id' => $event['id'], 'token' => $token]) }}">Editar Evento</a>
                @else
                    <a class="info-btn" href="{{ route('event', ['id' => $event['id'], 'token' => $token]) }}">Mais informações</a>
                @endif
            @else
                <a class="info-btn" href="{{ route('login')}}">Mais informações</a>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
