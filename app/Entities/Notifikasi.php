<?php namespace App\Entities;
use App\Entities\MyEntity;

class Notifikasi extends MyEntity
{
    protected $datamap = [
        'd' => 'noitfId',
        'judul' => 'notifJudul',
        'pesan' => 'notifPesan',
        'tanggal' => 'notifTanggal',
    ];

    protected $show = [
		'd',
		'judul',
		'pesan',
		'tanggal',
    ];
}