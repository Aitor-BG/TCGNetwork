<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $route = $role . '.dashboard';
        $all_events = Event::all();

        $events = [];
        foreach ($all_events as $event) {
            $events[] = [
                'title' => $event->name,
                'start' => $event->start_date->toIso8601String(), // Format as ISO8601 string
                'end' => $event->end_date->toIso8601String(), // Format as ISO8601 string
            ];
        }

        return view('tienda.tienda_dashboard', compact('events'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Create a new event
        $event = new Event();
        $event->name = $validated['title'];
        $event->start_date = $validated['start_date'];
        $event->end_date = $validated['end_date'];
        $event->save();

        // Redirect to the dashboard
        return redirect()->route('tienda.dashboard');
    }
}
