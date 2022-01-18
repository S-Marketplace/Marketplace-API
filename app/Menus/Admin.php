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
                'title' => 'Produk',
                'url' => '#',
                'icon' => 'book-open',
                'children' => [
                    [
                        'title' => 'Produk',
                        'url' => 'Produk'
                    ],
                    [
                        'title' => 'Kategori',
                        'url' => 'Kategori'
                    ],
                ]
            ],
            [
                    'title' => 'Master',
                    'url' => '#',
                    'icon' => 'box',
                    'children' => [
                        [
                            'title' => 'User Aplikasi Web',
                            'url' => 'UserWeb'
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
