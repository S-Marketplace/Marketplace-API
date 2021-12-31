<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Napi extends MyEntity
{
	protected $casts  = [
		'agamaRef' => 'json',
	];

	protected $datamap  = [
		'id' => 'napiId',
		'noReg' => 'napiNoReg',
		'nama' => 'napiNama',
		'blokKamar' => 'napiBlokKamar',
		'uu' => 'napiUu',
		'lamaPidanaHari' => 'napiLamaPidanaHari',
		'lamaPidanaBulan' => 'napiLamaPidanaBulan',
		'lamaPidanaTahun' => 'napiLamaPidanaTahun',
		'jenisKejahatan' => 'napiJnsKejahatan',
		'tanggalEkspirasi' => 'napiTanggalEkspirasi',
		'uptAsal' => 'napiUptAsal',
		'pasalUtama' => 'napiPasalUtama',
		'jenisKejahatanNarkotika' => 'napiJenisKejahatanNarkotika',
		'statusKerjaWali' => 'napiStatusKerjaWali',
		'pasFoto' => 'napiPasFoto',
		'agama' => 'napiAgama',
		// 'umur' => 'napiUmur',
		'jenisKelamin' => 'napiJenisKelamin',
		'kewarganegaraan' => 'napiKewarganegaraan',
		'tanggalLahir' => 'napiTanggalLahir',
		'createdAt' => 'napiCreatedAt',
		'updatedAt' => 'napiUpdatedAt',
		'deletedAt' => 'napiDeletedAt',
	];

	protected $show = [
		'id',
		'noReg',
		'nama',
		'blokKamar',
		'uu',
		'lamaPidanaHari',
		'lamaPidanaBulan',
		'lamaPidanaTahun',
		'jenisKejahatan',
		'tanggalEkspirasi',
		'uptAsal',
		'pasalUtama',
		'jenisKejahatanNarkotika',
		'statusKerjaWali',
		'pasFoto',
		'agama',
		// 'umur',
		'jenisKelamin',
		'kewarganegaraan',
		'tanggalLahir',
		'createdAt',
		'updatedAt',
		'deletedAt',

		'agamaRef',
	];
}
