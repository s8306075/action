<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'status',
        'name',
        'start_time',
        'end_time',
        'score',
        'login_time',
        'ip',
        'username',
        'numbers',
    ];

    public $dates = [
        'start_time',
        'end_time'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'action_tags');
    }

    public function getTicketStatusAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'Rejected';
            case 1:
                return 'Resolved';
            case 2:
                return 'Processing';
            case 3:
                return 'Pending';
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'danger';
            case 1:
                return 'success';
            case 2:
                return 'warning';
            case 3:
                return 'primary';
        }
    }
}
