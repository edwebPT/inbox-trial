<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'status'
    ];

    public function lists()
    {
        return $this->belongsToMany(
            ContactList::class,
            'contact_contact_list',
            'contact_id',
            'contact_list_id'
        );
    }

    public function sends()
    {
        return $this->hasMany(CampaignSend::class);
    }
}
