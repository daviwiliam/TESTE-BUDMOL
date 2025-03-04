@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-form">
        @if(isset($message) && $message)
            <p class="msg-erro">{{ $message }}</p>
        @endif
        <h2>Login</h2>
        <form method="POST" action="{{ route('login-auth') }}">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Digite seu e-mail" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Digite sua senha" required>
            </div>
            <button type="submit" class="auth-btn">Entrar</button>
            <p class="register-link">Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
        </form>
    </div>
</div>
@endsection
