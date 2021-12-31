<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Penjamin Integrasi</title>
    <style>
        body {
            font-family: 'Roboto';
            font-size: 13px;
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
                    <td width="60px"><img src="<?= base_url('assets/images/silaki/logo_fix.png') ?>" alt="tidak ada gambar" width="80px"></td>
                    <td align="center" style="font-family: 'Roboto'">
                        <b style="font-size:16px;font-weight:bold;margin-top:0px" class="hfakultas">KEMENTRIAN HUKUM DAN HAK ASASI MANUSIA RI</b><br>
                        <b style="font-size:16px;font-weight:bold;margin-top:0px" class="hfakultas">KANTOR WILAYAH KALIMANTAN SELATAN</b><br>
                        <b style="font-size:16px;font-weight:bold;margin-top:0px" class="hfakultas">LEMBAGA PERMASYARAKATAN KLAS II A NARKOTIKA KARANG INTAN</b><br>
                        <span style="font-size: 16px">Jl. Ir. Pangeran M. Noor, Ds. Lihung, Kec. KarangIntan, Kab. Banjar, Kalsel</span><br>
                        <span style="font-size: 16px">Email :lpnarkotikakalsel@gmail.com / Blog :lpkarangintan.com</span><br>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table width="100%">
            <tbody>
                <tr>
                    <td align="center" id="d_cetak_semester"><b>SURAT JAMINAN KESANGGUPAN KELUARGA</b></td>
                </tr>
            </tbody>
        </table>
        <p>Yang bertanda tangan dibawah ini, kami :</p>
        <table width="100%" class="info">
            <tbody>
                <tr>
                    <td width="30%">Nama</td>
                    <td width="5px">:</td>
                    <td><?= $data['uinNama']  ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?= round((time()-strtotime($data['uinTanggalLahir']))/(3600*24*365.25)).' Tahun'  ?></td>
                </tr>
                <tr>
                    <td>Pekerjaan / Jabatan</td>
                    <td>:</td>
                    <td><?= $data['uinPekerjaan']  ?></td>
                </tr>
                <tr>
                    <td>Hubungan dgn Narapidana</td>
                    <td>:</td>
                    <td><?= $data['pintHubunganNapi']  ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= $data['uinAlamat']  ?></td>
                </tr>
                <tr>
                    <td>No. Telp/HP</td>
                    <td>:</td>
                    <td><?= $data['uinNoHp']  ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <p>Adalah sebagai penjamin dari narapidana :</p>
        <table width="100%" class="info">
            <tbody>
                <tr>
                    <td width="30%">Nama</td>
                    <td width="5px">:</td>
                    <td><?= $data['napiNama']  ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?= round((time()-strtotime($data['napiTanggalLahir']))/(3600*24*365.25)).' Tahun'  ?></td>
                </tr>
                <tr>
                    <td>Menjalani Pidana di </td>
                    <td>:</td>
                    <td><?= 'LAPAS KELAS II A NARKOTIKA KARANG INTAN'  ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <p>Dengan ini menyatakan :</p>
        <ul>
            <li>Sanggup menjamin sepenuhnya bahwa apabila narapidana tersebut diberikan izin Pembebasan Bersyarat, narapidana yang
                bersangkutan tidak akan melarikan diri dan/atau tidak melakukan perbuatan melanggar hukum lagi; dan
            </li>
            <li>Sanggup membantu dalam membimbing dan turut mengawasi narapidana yang bersangkutan selama mengikuti program Pembebasan
                Bersyarat.
            </li>
        </ul>
        <p>Demikian surat jaminan ini dibuat dengan sesungguhnya untuk dipergunakan seperlunya.</p>

        <table width="100%" style="margin: auto;text-align: center;" class="info">
            <tbody>
                <tr>
                    <td>Karang Intan, <?=  date_convert($data['pintTanggal'])->default ?></td>
                </tr>
                <tr>
                    <td>PENJAMIN,</td>
                </tr>
                <tr>
                    <td style="width: 100px; height: 100px"><b>Materai Rp.6000</b></td>
                </tr>
                <tr>
                    <td><?= $data['uinNama']  ?></td>
                </tr>
            </tbody>
        </table>
         
         <br>
         <br>
        <table width="100%" style="margin: auto;text-align: center;" class="info">
            <tbody>
                <tr>
                    <td width="5%"></td>
                    <td width="40%">an. KEPALA</td>
                    <td width="10%"></td>
                    <td width="40%">LURAH/KEPALA DESA</td>
                    <td width="5%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?= $pj['jbtnNama']; ?></td>
                    <td></td>
                    <td>............................................,</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 100px; height: 80px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?= $pj['pgwNama']; ?></td>
                    <td></td>
                    <td>............................................,</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>NIP.<?= $pj['pgwNip']; ?></td>
                    <td></td>
                    <td>............................................,</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        

    </div>

    </div>

</body>

</html>