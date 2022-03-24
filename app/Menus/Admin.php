<?php

namespace App\Menus;


class Admin implements MenuInterface
{

    public function getMenu()
    {
        return [
            [
                'title' => 'Menu',
                'class' => 'sidebar-main-title',
            ],
            [
                'title' => 'Beranda',
                'url' => 'Beranda',
                'icon' => 'home',
            ],
            [
                'title' => 'Master',
                'url' => '#',
                'icon' => 'book-open',
                'children' => [
                    [
                        'title' => 'Banner',
                        'url' => 'Banner'
                    ],
                    [
                        'title' => 'Kategori',
                        'url' => 'Kategori'
                    ],
                    [
                        'title' => 'Produk',
                        'url' => 'Produk'
                    ],
                    [
                        'title' => 'Produk Beranda',
                        'url' => 'ProdukBeranda'
                    ],
                ]
            ],
            [
                'title' => 'User',
                'url' => '#',
                'icon' => 'user',
                'children' => [
                    [
                        'title' => 'User Terdaftar',
                        'url' => 'User'
                    ],
                ]
            ],
            [
                'title' => 'Transaksi',
                'url' => '#',
                'icon' => 'user',
                'children' => [
                    [
                        'title' => 'Top Up Saldo',
                        'url' => 'TransaksiTopUpSaldo'
                    ],
                    [
                        'title' => 'Pembelian Produk',
                        'url' => 'TransaksiPembelianProduk'
                    ],
                ]
            ],
            // [
            //     'title' => 'Jadwal Kunjungan',
            //     'url' => '#',
            //     'icon' => 'calendar',
            //     'children' => [
            //         [
            //             'title' => 'Umum',
            //             'url' => 'JadwalUmum'
            //         ],
            //         [
            //             'title' => 'Khusus',
            //             'url' => 'JadwalKhusus'
            //         ],
            //     ]
            // ],
            // [
            //     'title' => 'User Integrasi',
            //     'url' => 'UserIntegrasi',
            //     'icon' => 'user',
            // ],
            // [
            //     'title' => 'Pengajuan Integrasi',
            //     'url' => 'PengajuanIntegrasi',
            //     'icon' => 'archive',
            // ],
            // [
            //     'title' => 'Jumlah Penghuni',
            //     'url' => 'JumlahPenghuni',
            //     'icon' => 'user',
            // ],
            // [
            //     'title' => 'Master',
            //     'url' => '#',
            //     'icon' => 'box',
            //     'children' => [
            //         [
            //             'title' => 'Layanan Pengaduan',
            //             'url' => 'LayananPengaduan'
            //         ],
            //         [
            //             'title' => 'Narapidana',
            //             'url' => 'Napi'
            //         ],
            //         [
            //             'title' => 'Foto Beranda',
            //             'url' => 'FotoBeranda'
            //         ],
            //         [
            //             'title' => 'Mekanisme',
            //             'url' => 'Mekanisme'
            //         ],
            //         [
            //             'title' => 'Mekanisme Pengajuan Integrasi',
            //             'url' => 'MekanismePengajuanIntegrasi'
            //         ],
            //     ]
            // ],
            // [
            //     'title' => 'Setting',
            //     'url' => 'Setting',
            //     'icon' => 'settings',
            // ],
        ];
    }
}
