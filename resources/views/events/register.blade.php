@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
<div class="auth-container">
    <div class="auth-form">
        @if(isset($message) && $message)
            <p class="msg-erro">{{ $message }}</p>
        @endif
        <h2>Cadastro</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Digite seu nome completo" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Digite seu e-mail" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Escolha uma senha" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Confirme sua senha" required>
            </div>
            <div class="admin">
                <label for="admin">Admin?</label>
                <input type="checkbox" value="1" id="admin" name="admin" class="form-input">
            </div>
            <button type="submit" class="auth-btn">Cadastrar</button>
            <p class="login-link">Já tem uma conta? <a href="{{ route('login') }}">Entre aqui</a></p>
        </form>
    </div>
</div>
@endsection
