<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLatih extends Model
{
    use HasFactory;

    protected $table = 'data_latih';
    protected $primaryKey = 'id_latih';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_latih',
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
        'kelas'
    ];
}
