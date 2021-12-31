<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Penjamin Integrasi</title>
    <style type="text/css">
        .TNR {
            font-family: 'Times New Roman'
        }

        .arial {
            font-family: 'Arial'
        }

        .coverbook {
            padding: 1cm;
            font-size: 14px;
            width: 16.5cm !important;
            height: 23.5cm;
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

        .img-tengah {
            margin-left: auto;
            margin-right: auto;
        }
    </style>

    <style>
        body {
            font-family: 'Roboto';
            font-size: 7px;
        }

        .info {
            font-size: 12px;
        }

        html {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
        }

        .gridtable {
            font-size: 11px;
            color: #333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }

        .gridtable th,
        .gridtable tr {
            border-width: 1px;
            padding: 15px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }

        .gridtable td,
        .gridtable th {
            border-width: 1px;
            padding: 10px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }

        table.header {
            font-size: 11px;
            color: #333333;
            border-width: 0px;
            border-color: #666666;
            border-collapse: collapse;
        }

        table.header th {
            border-width: 0px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }

        table.header td {
            border-width: 0px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <!-- HALAMAN PERTAMA -->
    <div class="">

        <table class="header table gridtable" style=" width: 100%; padding-right: 75px">
            <tbody>
                <tr>
                    <td width="80px"><img src="<?= base_url('assets/images/silaki/logo_fix.png') ?>" alt="tidak ada gambar" width="70px" height="90px"></td>
                    <td align="center">
                        <b style="font-size:14px;font-weight:bold;margin-top:-12px;margin-top:2px;" class="arial">KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA RI</b><br>
                        <b style="font-size:14px;font-weight:bold;margin-top:-12px;margin-top:2px" class="hunlam">KANTOR WILAYAH KALIMANTAN SELATAN</b><br>
                        <b style="font-size:14px;font-weight:bold;margin-top:-12px;margin-top:2px" class="hunlam">LEMBAGA PEMASYARAKATAN KLAS IIA NARKOTIKA KARANG INTAN</b><br>
                        <p style="font-size:14px;margin-top:0px">Jl. Ir. Pangeran M. Noor, Ds. Lihung, Kec. KarangIntan, Kab. Banjar, Kalsel</p>
                        <p style="font-size:14px;margin-top:-12px;margin-bottom:0px">Email :lpnarkotikakalsel@gmail.com / Blog :lpkarangintan.com</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table width="100%">
            <tbody>
                <tr>
                    <td align="center" style="font-size:14px;font-weight:bold;margin-top:-12px;margin-top:1px" id="d_cetak_semester">SURAT JAMINAN KESANGGUPAN KELUARGA</td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <p style="font-size:12px;margin-top:0px;margin-bottom:0px">Yang bertanda tangan dibawah ini, kami :</p>
        <table width="100%" class="info" style="font-size:12px;">
            <tbody>
                <tr>
                    <td width="140px">Nama</td>
                    <td width="2px">:</td>
                    <td width="auto"><?= $user->nama ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?= hitungUmur($user->tanggalLahir) ?> Tahun</td>
                </tr>
                <tr>
                    <td>Pekerjaan/Jabatan</td>
                    <td>:</td>
                    <td><?= $user->pekerjaan ?></td>
                </tr>
                <tr>
                    <td>Hubungan dgn Narapidana </td>
                    <td>:</td>
                    <td><?= $hubungan ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= $user->alamat ?></td>
                </tr>
                <tr>
                    <td>No. Telp/HP</td>
                    <td>:</td>
                    <td><?= $user->noHp ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>

        <p style="font-size:12px;margin-top:0px;margin-bottom:0px">Adalah sebagai penjamin dari narapidana :</p>
        <table width="100%" class="info" style="font-size:12px;">
            <tbody>
                <tr>
                    <td width="100px">Nama</td>
                    <td width="2px">:</td>
                    <td width="auto"><?= $napi->nama ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?= hitungUmur($napi->tanggalLahir) ?> Tahun</td>
                </tr>
                <tr>
                    <td>Menjalani Pidana di </td>
                    <td>:</td>
                    <td><?= $napi->uptAsal ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>

        <p style="font-size:12px;margin-top:0px;margin-bottom:0px">Dengan ini menyatakan :</p>
        <br>
        <ul style="font-size:12px;margin-top:0px;margin-bottom:0px">
            <li>Sanggup menjamin sepenuhnya bahwa apabila narapidana tersebut diberikan izin Pembebasan Bersyarat, narapidana yang
                bersangkutan tidak akan melarikan diri dan/atau tidak melakukan perbuatan melanggar hukum lagi; dan</li>
            <li>Sanggup membantu dalam membimbing dan turut mengawasi narapidana yang bersangkutan selama mengikuti program Pembebasan
                Bersyarat.</li>
        </ul>
        <br>
        <br>

        <p style="font-size:12px;margin-top:0px;margin-bottom:0px">Demikian surat jaminan ini dibuat dengan sesungguhnya untuk dipergunakan seperlunya.</p>
        <br>
        <br>

        <p align="center" style="font-size:12px;margin-top:0px;margin-bottom:0px">Karang Intan, <?= date_convert(date('Y-m-d'))->default ?></p><br>
        <p align="center" style="font-size:12px;margin-top:-5px;margin-bottom:0px">PENJAMIN,</p><br>
        <br>
        <br>
        <br>
        <br>

        <p align="center"><b style="font-size:9px;font-weight:bold;margin-left:-100px" class="hunlam">Materai 6000</b></p><br>
        <br>
        <br>
        <br>
        <br>

        <p align="center" style="font-size:12px;margin-top:0px;margin-bottom:0px"><?= $user->nama ?></p>
        <br>
        <br>
        <br>
        <br>
        <br>

        <table width="100%" class="info" style="font-size:12px;">
            <tbody>
                <tr>
                    <td align="center" width="50%">an. KEPALA<br><?= $pegawai['jabatan']->nama ?></td>
                    <td align="center" width="50%">LURAH/KEPALA DESA<br>............................................,</td>
                </tr>
                <tr>
                    <td align="center"><br><br><br><br></td>
                    <td align="center"><br><br><br><br></td>
                </tr>
                <tr>
                    <td align="center"><?= $pegawai['nama'] ?><br>NIP.<?= $pegawai['nip'] ?></td>
                    <td align="center">............................................<br>.......................................</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>