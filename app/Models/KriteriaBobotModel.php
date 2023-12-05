<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaBobotModel extends Model
{
    use HasFactory;

    protected $table = 'kriteriabobot';

    protected $fillable = [
        'nama',
        'tipe',
        'bobot',
        'description'
    ];

    public function alternatifSkor()
    {
        return $this->hasMany(AlternatifSkor::class, 'kriteriabobot_id');
    }
}
