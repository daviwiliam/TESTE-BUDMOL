<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserEventController;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {

    return view('events.login');
})->name('login');

Route::post('/login', function (Request $request) {

    try {

        $user = (new AuthController())->login($request);

        if (array_key_exists('message', $user)) {

            $message = $user['message'];
            return view('events.login', compact('message'));
        }

        $events = (new EventController())->index();

        $token = $user['token'];

        $user = $user['user'];

        return view('events.index', compact('user', 'events', 'token'));
    } catch (Exception $e) {

        $message = $e->getMessage();

        return view('events.login', compact('message'));
    }
})->name('login-auth');

Route::get('/registro', function () {
    return view('events.register');
})->name('register');

Route::post('/registro', function (Request $request) {

    try {

        $user = (new AuthController())->register($request);

        $events = (new EventController())->index();

        $token = $user['token'];

        $user = $user['user'];

        return view('events.index', compact('user', 'events', 'token'));
    } catch (Exception $e) {

        $message = $e->getMessage();

        return view('events.register', compact('message'));
    }
})->name('register-auth');

Route::get('/logout', function (Request $request, UserService $userService) {

    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $user = (new AuthController())->logout($request);

    return view('events.login');
})->name('logout');

// Página inicial com eventos
Route::get('/eventos', function (Request $request, UserService $userService) {

    $token = $request->query('token');

    $events = (new EventController())->index();

    $user = $userService->getUserFromToken($token);

    return view('events.index', compact('user', 'events', 'token'));
})->name('home');

// Página detalhes do evento
Route::get('/evento', function (Request $request, UserService $userService) {

    $eventId = $request->query('id');
    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    $event = Event::findOrFail($eventId);
    $currentRegistrations = UserEvent::where('event_id', $event->id)->count();

    $achievedCapacity = $currentRegistrations >= $event->capacity;

    $userEvent = UserEvent::where('user_id', $user->id)->where('event_id', $eventId)->first();
    $participant = $userEvent ? $userEvent->active : 0;

    return view('events.event', compact('user', 'event', 'token', 'participant', 'achievedCapacity'));
})->name('event');

Route::get('/painel', function (Request $request, UserService $userService) {

    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    if ($user->admin) {

        Auth::setUser($user);

        $events = (new UserEventController())->myEvents($request);
    } else {

        $events = (new UserEventController())->subscriptions($user->id);
    }

    return view('events.dashboard', compact('user', 'events', 'token'));
})->name('dashboard');

Route::get('/participantes', function (Request $request, UserService $userService) {

    $eventId = $token = $request->query('id');

    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $participantes = (new UserEventController())->participants($request, $eventId);

    return view('events.participants', compact('participantes', 'token'));
})->name('participants');

Route::get('/criar', function (Request $request, UserService $userService) {

    $token = $request->query('token');
    $user = $userService->getUserFromToken($token);

    return view('events.create', compact('user', 'token'));
})->name('create');

Route::post('/criar', function (Request $request, UserService $userService) {

    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $event = (new EventController())->store($request);

    $message = $event ? 'Evento criado com sucesso' : 'Erro ao criar evento';

    $events = (new UserEventController())->myEvents($request);

    return view('events.dashboard', compact('user', 'token', 'events', 'message'));
})->name('create-event');

Route::post('/editar', function (Request $request, UserService $userService) {

    $idEvent = $request->query('id');
    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $event = (new EventController())->update($request, $idEvent);

    $message = $event ? 'Evento atualizado com sucesso' : 'Erro ao atualizar evento';

    $events = (new UserEventController())->myEvents($request);

    return view('events.dashboard', compact('user', 'token', 'events', 'message'));
})->name('edit-event');

Route::get('/deletar', function (Request $request, UserService $userService) {

    $idEvent = $request->query('id');
    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $event = (new EventController())->destroy($request, $idEvent);

    $message = $event ? 'Evento deletado com sucesso' : 'Erro ao deletar evento';

    $events = (new UserEventController())->myEvents($request);

    return view('events.dashboard', compact('user', 'token', 'events', 'message'));
})->name('delete-event');

Route::get('/inscrever', function (Request $request, UserService $userService) {

    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $event = (new UserEventController())->subscribe($request);

    $message = $event ? 'Inscrição realizada com sucesso' : 'Erro ao realizar inscrição';

    $events = $request->user()->admin ? (new UserEventController())->myEvents($request) : (new UserEventController())->subscriptions($request->user()->id);

    return view('events.dashboard', compact('user', 'token', 'events', 'message'));
})->name('subscribe-event');

Route::get('/cancelar-inscricao', function (Request $request, UserService $userService) {

    $eventId = $request->query('event_id');
    $token = $request->query('token');

    $user = $userService->getUserFromToken($token);

    Auth::setUser($user);

    $event = (new UserEventController())->cancelSubscription($request, $eventId);

    $message = $event ? 'Inscrição cancelada com sucesso' : 'Erro ao cancelar inscrição';

    $events = $request->user()->admin ? (new UserEventController())->myEvents($request) : (new UserEventController())->subscriptions($request->user()->id);

    return view('events.dashboard', compact('user', 'token', 'events', 'message'));
})->name('subscrption-cancel');
