<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentRequest extends Model
{
    use HasFactory;

    // Visible attributes
    protected $fillable = [
        'ticket_id',
        'agent_id',
        'title',
        'notes',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // This model dont need casts or hidden attributes for now


    /*______________Relationships______________*/

    // Ticket associated with the document request
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Agent who requested the document
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Documents that respond to this request
    public function documents()
    {
        return $this->hasMany(TicketDocument::class);
    }

}
