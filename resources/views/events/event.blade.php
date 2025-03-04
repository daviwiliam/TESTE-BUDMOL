@extends('layouts.app')

@section('title', 'Detalhes do Evento')

@section('content')
    <div class="event-container">
        <h1 class="event-title">{{ $event->title }}</h1>
        <div class="event-details">
        @if ($user->admin && $user->id == $event->user_id)
            <form action="{{ route('edit-event', ['id'=> $event->id, 'token' => $token]) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" placeholder="{{ $event->title }}" class="form-input">
                </div>
            
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea name="description" id="description" placeholder="{{ $event->description }}" class="form-input">{{ old('description', $event->description) }}</textarea>
                </div>
            
                <div class="form-group">
                    <label for="start_date">Data de Início</label>
                    <input type="text" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('d/m/Y')) }}" placeholder="{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}" class="form-input">
                </div>
            
                <div class="form-group">
                    <label for="time">Horário de Início</label>
                    <input type="text" name="time" id="time" value="{{ old('time', \Carbon\Carbon::parse($event->start_date)->format('H:i')) }}" placeholder="{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}" class="form-input">
                </div>
            
                <div class="form-group">
                    <label for="location">Local</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" placeholder="{{ $event->location }}" class="form-input">
                </div>
            
                <div class="form-group">
                    <label for="capacity">Capacidade</label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" placeholder="{{ $event->capacity }}" class="form-input">
                </div>
            
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-input">
                        <option value="open" {{ $event->status == 'open' ? 'selected' : '' }}>Aberto</option>
                        <option value="closed" {{ $event->status == 'closed' ? 'selected' : '' }}>Fechado</option>
                        <option value="canceled" {{ $event->status == 'canceled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="event-action-btn edit-btn">Atualizar Evento</button>
                </div>
            </form>
        @elseif ($event['status'] == 'open')
                <p><strong>Descrição:</strong> {{ $event->description }}</p>
                <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</p>
                <p><strong>Horario:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}</p>
                <p><strong>Local:</strong> {{ $event->location }}</p>
                <p><strong>Capacidade:</strong> {{ $event->capacity }}</p>
                <p><strong>Status:</strong> 
                    @switch($event->status)
                        @case('open')
                            Aberto
                            @break
                        @case('closed')
                            Fechado
                            @break
                        @case('canceled')
                            Cancelado
                            @break
                        @default
                            Indefinido
                    @endswitch
                </p>
                <p><strong>Organizador:</strong> {{ $event->user->name }}</p>

                <div class="action-buttons">    

                @if ($participant)
                    <a class="event-action-btn cancel-btn" href="{{ route('subscrption-cancel', ['event_id' => $event['id'], 'token' => $token]) }}">Cancelar Inscrição</a>
                @elseif(!$user->admin)
                    @if($achievedCapacity)
                        <p>Capacidade máxima atingida</p>
                    @else
                        <a class="event-action-btn register-btn" href="{{ route('subscribe-event', ['event_id' => $event['id'], 'token' => $token]) }}">Inscrever-se</a>
                    @endif
                @endif

                </div>
        @endif
        </div>
    </div>
@endsection
