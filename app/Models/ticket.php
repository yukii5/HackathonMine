<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function hasUpdatePolicy()
    {
        return Auth::user()->admin 
            || $this->responsible_person_id === Auth::user()->id
            || $this->created_user_id === Auth::user()->id;
    }

    public function hasDeletePolicy()
    {
        $project = Project::select('responsible_person_id')
        ->where('id', $this->project_id)->first();
        
        return Auth::user()->admin 
            || $project->responsible_person_id === Auth::user()->id
            || $this->responsible_person_id === Auth::user()->id
            || $this->created_user_id === Auth::user()->id;
    }
}
