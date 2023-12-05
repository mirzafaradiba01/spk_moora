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
        'score',
    ];

    public function kriteriabobot()
    {
        return $this->belongsTo(KriteriaBobotModel::class, 'kriteriabobot_id');
    }

    public function alternatif()
    {
        return $this->belongsTo(AlternatifModel::class, 'ida', 'id');
    }

}
