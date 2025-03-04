<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionCancellation;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Traits\VerifyAdminTrait;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Support\Facades\Mail;

class UserEventController extends Controller implements HasMiddleware
{
    use VerifyAdminTrait;

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }

    public function myEvents(Request $request)
    {
        $this->verifyAdmin($request);

        $events = Event::where('user_id', $request->user()->id)->get();

        return $events;
    }

    public function participants(Request $request, $eventId)
    {
        $this->verifyAdmin($request);

        $event = Event::find($eventId);
        $participants = $event->participants;

        return $participants;
    }

    public function subscriptions($userId)
    {
        $user = User::find($userId);
        $events = $user->userEvents;

        return $events;
    }

    public function subscribe(Request $request)
    {
        $fields = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'active' => 'boolean'
        ]);

        $userId = $request->user()->id;

        $event = Event::findOrFail($fields['event_id']);

        $currentRegistrations = UserEvent::where('event_id', $event->id)->count();

        if ($currentRegistrations >= $event->capacity) {
            return response()->json([
                'message' => 'Maximum capacity for this event has been reached.'
            ], 403);
        }

        $subscription = UserEvent::firstOrCreate(
            ['event_id' => $event->id, 'user_id' => $userId]
        );

        if (!$subscription->wasRecentlyCreated) {
            return response()->json(['message' => 'You are already registered for this event.'], 403);
        }

        Mail::to($request->user()->email)->send(new SubscriptionConfirmation($subscription));

        return response()->json([
            'message' => 'Registration completed successfully.',
            'subscription' => $subscription
        ], 201);
    }


    public function cancelSubscription(Request $request, $eventId)
    {
        $event = UserEvent::findOrFail($eventId);

        $fields = $request->validate([
            'user_id' => 'boolean',
            'active' => 'boolean|nullable'
        ]);

        $fields['active'] = $fields['active'] ?? $request->input('active', 0);

        $event->update($fields);

        Mail::to($request->user()->email)->send(new SubscriptionCancellation($event));

        return response()->json(['message' => 'Registration successfully cancelled.'], 200);
    }
}
