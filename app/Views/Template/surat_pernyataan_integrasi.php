<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Surat Pernyataan Integrasi</title>
    <style>
        body {
            font-family: 'Roboto';
            font-size: 14px;
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
                    <td width="80px"><img src="<?= base_url('assets/images/silaki/logo_fix.png') ?>" alt="tidak ada gambar" width="80px"></td>
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
                    <td align="center" id="d_cetak_semester">SURAT PERNYATAAN NARAPIDANA</td>
                </tr>
            </tbody>
        </table>
        <p>Yang bertanda tangan dibawah ini:</p>
        <table width="100%" class="info">
            <tbody>
                <tr>
                    <td width="30%">Nama/Umur/Jenis Kelamin</td>
                    <td width="5px">:</td>
                    <td><?= $data['napiNama']  ?></td>
                </tr>
                <tr>
                    <td>Agama/Kewarganegaraan</td>
                    <td>:</td>
                    <td><?= "{$data['agmrNama']} / {$data['napiKewarganegaraan']}"  ?></td>
                </tr>
                <tr>
                    <td>Perkara</td>
                    <td>:</td>
                    <td><?= "{$data['napiJnsKejahatan']} / {$data['napiPasalUtama']} {$data['napiUu']}" ?></td>
                </tr>
                <tr>
                    <td>Pidana</td>
                    <td>:</td>
                    <td><?= "{$data['napiLamaPidanaTahun']} Tahun {$data['napiLamaPidanaBulan']} Bulan"  ?></td>
                </tr>
                <tr>
                    <td>Nama Penjamin </td>
                    <td>:</td>
                    <td><?= $data['uinNama']  ?></td>
                </tr>
                <tr>
                    <td>Alamat Penjamin</td>
                    <td>:</td>
                    <td><?= $data['uinAlamat']  ?></td>
                </tr>
                <tr>
                    <td>No.Tlp/Hp Penjamin</td>
                    <td>:</td>
                    <td><?= $data['uinNoHp']  ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <p>Adalah Warga Binaan Pemasyarakatan pada LAPAS KELAS II A NARKOTIKA KARANG INTAN, dengan ini menyatakan atas kesadaran sendiri dan tanpa paksaan pihak manapun:</p>
        <ul>
            <li>Selama proses pengusulan Pembebasan Bersyarat, saya akan tetap mengikuti program pembinaan dan tetap bekerja sebagai mana
                mestinya.
            </li>
            <li>Menyadari dan menyesali sepenuhnya perbuatan yang pernah saya lakukan dan berjanji tidak akan mengulangi lagi perbuatan yang
                melanggar hukum.
            </li>
        </ul>
        <p>Apabila dikemudian hari baik disengaja maupun tidak disengaja saya melakukan perbuatan yang sama dan/atau melanggar hukum lagi
            ataupun saya melalaikan pernyataan tersebut di atas, maka saya bersedia menerima sanksi berupa pembatalan usulan pembebasan bersyarat
            dan/atau pencabutan surat keputusan pembebasan bersyarat.
        </p>
        <p>Demikian pernyataan ini saya buat dengan penuh kesadaran dan merupakan pengikat diri saya selama menunggu proses pengusulan maupun
            selama menjalani pembebasan bersyarat.
        </p>

        <table width="100%" style="margin: auto;text-align: center;" class="info">
            <tbody>
                <tr>
                    <td>Karang Intan, <?=  date_convert($data['pintTanggal'])->default ?></td>
                </tr>
                <tr>
                    <td>YANG MEMBUAT PERNYATAAN,</td>
                </tr>
                <tr>
                    <td style="width: 100px; height: 100px"><b>Materai Rp.6000</b></td>
                </tr>
                <tr>
                    <td><?= $data['napiNama'] ?></td>
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