<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'body',
        'contact_list_id',
        'scheduled_at',
        'status'
    ];

    public function contactList()
    {
        return $this->belongsTo(ContactList::class,'contact_list_id');
    }

    public function sends()
    {
        return $this->hasMany(CampaignSend::class);
    }
}
