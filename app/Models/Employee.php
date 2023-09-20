<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["affiliate_id", "user_id"];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($consumer) {
            // Exclua o relacionamento com usuário e marque-o como excluído (soft delete)
            $consumer->user()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
