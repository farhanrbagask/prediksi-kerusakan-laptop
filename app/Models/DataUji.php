<?php

namespace App\Models;

use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUji extends Model
{
    use HasFactory;

    protected $table = 'data_uji';
    protected $primaryKey = 'id_uji';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_uji',
        'layar_blank',
        'layar_bergaris',
        'auto_restart',
        'boot_loop',
        'alarm_bios',
        'error_disk',
        'keyboard_touchpad_mati',
        'baterai_cepat_habis',
        'overheat',
        'hang',
        'kelas',
        'hasil_prediksi'
    ];

    public function hasilPrediksi()
    {
        return $this->hasOne(HasilPrediksi::class, 'data_uji_id', 'id_uji');
    }
}