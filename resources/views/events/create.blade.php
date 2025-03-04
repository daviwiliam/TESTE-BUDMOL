@extends('layouts.app')

@section('title', 'Criar evento')

@section('content')
    <div class="event-container">
        <h1 class="event-title">Criar evento</h1>
        <div class="event-details">
            @if ($user->admin)
                <form method="POST" action="{{ route('create-event', ['token' => $token]) }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Título do evento" class="form-input">
                    </div>
                
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea name="description" id="description" placeholder="Descrição do evento" class="form-input">{{ old('description') }}</textarea>
                    </div>
                
                    <div class="form-group">
                        <label for="start_date">Data de Início</label>
                        <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" placeholder="dd/mm/yyyy" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="end_date">Data de Término</label>
                        <input type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" placeholder="dd/mm/yyyy" class="form-input">
                    </div>
                
                    <div class="form-group">
                        <label for="time">Horário</label>
                        <input type="text" name="time" id="time" value="{{ old('time') }}" placeholder="HH:mm" class="form-input">
                    </div>
                
                    <div class="form-group">
                        <label for="location">Local</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Local do evento" class="form-input">
                    </div>
                
                    <div class="form-group">
                        <label for="capacity">Capacidade</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" placeholder="Capacidade do evento" class="form-input">
                    </div>
                    
                    <div class="action-buttons">
                        <button type="submit" class="event-action-btn register-btn">Criar Evento</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
