<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    public $timestamps = false; // タイムスタンプのカラムが存在しないため、falseに設定します

    protected $fillable = [
        'project_name',
        'responsible_person_id',
        'start_date',
        'end_date',
        'status_code'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function hasPolicy()
    {
        return Auth::user()->admin 
            || $this->leader_id === Auth::user()->id
            || $this->created_user_id === Auth::user()->id;
    }
}
