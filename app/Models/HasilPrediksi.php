<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPrediksi extends Model
{
    use HasFactory;

    protected $table = 'hasil_prediksi';
    protected $primaryKey = 'id_prediksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_prediksi',
        'data_uji_id',
        'akurasi',
        'presisi',
        'recall',
        'f1_score'
    ];

    public function dataUji()
    {
        return $this->belongsTo(DataUji::class, 'data_uji_id', 'id_uji');
    }

    public function getHasilPrediksiAttribute()
    {
        return $this->dataUji ? $this->dataUji->hasil_prediksi : null;
    }

    public function getKelasAktualAttribute()
    {
        return $this->dataUji ? $this->dataUji->kelas : null;
    }
}
