<?php

namespace App\Entities;

use App\Entities\MyEntity;

class CheckoutPulsa extends MyEntity
{

  protected $casts = [
    'pembayaran' => 'json',
  ];

  protected $datamap = [
    'id' => 'cktpId',
    'email' => 'cktpEmail',
    'pmbId' => 'cktpPmbId',
    'idProduk' => 'cktpIdProduk',
    'status' => 'cktpStatus',
    'tujuan' => 'cktpTujuan',
    'createdAt' => 'cktpCreatedAt',
    'updatedAt' => 'cktpUpdatedAt',
    'deletedAt' => 'cktpDeletedAt',
  ];

  protected $show = [
    'id',
    'email',
    'pmbId',
    'idProduk',
    'status',
    'tujuan',
    'pembayaran',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
