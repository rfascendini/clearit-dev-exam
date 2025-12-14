<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDocument extends Model
{
    // Visible attributes
    protected $fillable = [
        'ticket_id',
        'uploaded_by',
        'document_request_id',
        'name',
        'path',
        'mime',
        'size',
    ];

    // This model dont need casts or hidden attributes for now

    /*______________Relationships______________*/

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function request()
    {
        return $this->belongsTo(DocumentRequest::class, 'document_request_id');
    }
}
