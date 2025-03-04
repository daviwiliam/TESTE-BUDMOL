<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Traits\VerifyAdminTrait;

class EventController extends Controller implements HasMiddleware
{
    use  VerifyAdminTrait;

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        return Event::all();
    }

    public function store(Request $request)
    {
        $this->verifyAdmin($request);

        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'string|required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|max:255',
            'capacity' => 'required|integer',
            'status' => 'nullable'
        ]);

        $start_datetime = \Carbon\Carbon::parse($fields['start_date'] . ' ' . $fields['time'])->format('Y-m-d H:i:s');

        $fields['start_date'] = $start_datetime;

        $fields['status'] = $request->input('status', 'open');

        $event = $request->user()->events()->create($fields);

        return $event;
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        return $event;
    }

    public function update(Request $request, $id)
    {
        $this->verifyAdmin($request);

        $event = Event::findOrFail($id);

        $fields = $request->validate([
            'title' => 'max:255',
            'description' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'time' => 'date_format:H:i',
            'location' => 'max:255',
            'capacity' => 'integer',
            'status' => 'in:open,closed,canceled'
        ]);

        $start_datetime = \Carbon\Carbon::parse($fields['start_date'] . ' ' . $fields['time'])->format('Y-m-d H:i:s');

        $fields['start_date'] = $start_datetime;

        $event->update($fields);

        return $event;
    }

    public function destroy(Request $request, $id)
    {
        $this->verifyAdmin($request);

        $event = Event::findOrFail($id);

        $event->delete();

        return ['message' => 'The event was deleted.'];
    }
}
