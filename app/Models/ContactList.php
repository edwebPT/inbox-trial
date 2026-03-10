<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactList extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function contacts()
    {
        return $this->belongsToMany(
            Contact::class,
            'contact_contact_list',
            'contact_list_id',
            'contact_id'
        );
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
