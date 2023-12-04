<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifSkor extends Model
{
    use HasFactory;

    protected $table = 'alternatifskor';

    protected $fillable = [
        'alternatif_id',
        'kriteriabobot_id',
    ];
}
