<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    // Ticket statuses    
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    // Visible attributes
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'transport_mode',
        'product',
        'country_origin',
        'country_destination',
        'status',
    ];

    // This model dont need casts or hidden attributes for now


    // Helpers methods
    public function status(string $status): bool
    {
        return $this->status === $status;
    }

    /*______________Relationships______________*/

    // Owner of the ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Documents associated with the ticket
    public function documents()
    {
        return $this->hasMany(TicketDocument::class);
    }

    // Document requests associated with the ticket
    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }



}
