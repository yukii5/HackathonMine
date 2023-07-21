<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function CreatedAt()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('Y/m/d H:i:s');
    }
}
