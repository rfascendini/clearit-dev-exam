<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GenericNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Ticket;
use App\Models\User;


class UserTicketController extends Controller
{
    /*
    The User Ticket Controller has TODO
    1. Create tickets
    2. Show tickets
    3. Show details of a ticket

    1) Create ticket
    -- Ticket name
    -- Ticket type (1, 2, 3)
    -- Mode of transport (air, land, sea)
    -- Product
    -- Country of origin / destination
    -- Initial status => new

    2) Show tickets
    -- List of tickets (all or filtered by status)

    3) Show details of a ticket
    -- Status
    -- Documents associated with the ticket
    -- Document requests associated with the ticket
    */


    public function index(Request $request)
    {
        $tickets = Ticket::where('user_id', $request->user()->id)->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $types = [1, 2, 3];
        $transportModes = ['air', 'land', 'sea'];

        return view('tickets.create', compact('types', 'transportModes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'in:1,2,3'],
            'transport_mode' => ['required', 'string', 'in:air,land,sea'],
            'product' => ['required', 'string', 'max:255'],
            'country_origin' => ['required', 'string', 'max:255'],
            'country_destination' => ['required', 'string', 'max:255'],
        ]);

        $ticket = Ticket::create([
            'user_id' => $request->user()->id,
            'name' => $data['name'],
            'type' => $data['type'],
            'transport_mode' => $data['transport_mode'],
            'product' => $data['product'],
            'country_origin' => $data['country_origin'],
            'country_destination' => $data['country_destination'],
            'status' => Ticket::STATUS_NEW,
        ]);

        $agents = User::where('role', 'agent')->get();

        if ($agents->isNotEmpty()) {
            Notification::send(
                $agents,
                new GenericNotification("New ticket created: #{$ticket->id}")
            );
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket created successfully.');
    }

    public function show(Request $request, Ticket $ticket)
    {
        if ((int) $ticket->user_id !== (int) $request->user()->id) {
            abort(403, 'You are not allowed to view this ticket.');
        }

        $ticket->load(['documents', 'documentRequests']);

        return view('tickets.show', compact('ticket'));
    }




}
