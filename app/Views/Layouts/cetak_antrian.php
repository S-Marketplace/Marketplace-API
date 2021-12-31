<html>

<head>
    <title>ANTRIAN</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto';

        }

        html {
            font-family: verdana, arial, sans-serif;

        }

        page[size='A4'] {
            background: white;
            width: 72mm;
            height: auto;
            display: block;
            margin: 0 auto;
            padding-left: 25px;
            padding-right: 25px;
            padding-top: 25px;
            margin-bottom: 0.5cm;
            border: 1px solid #dadada
        }

        @media print {

            body,
            page[size='A4'] {
                margin: 0;
                padding-left: 0px;
                padding-right: 0px;
                border: 0px
            }
        }
    </style>
</head>

<body>
    <page size='A4'>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="font-size: 13px;">Selasa, 14 September 2021</td>
                    <td style="text-align:right;font-size: 13px;">ID Antrian : <?= $data['id'] ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table width="100%" style="text-align:left">
            <tbody>
                <tr>
                    <th style="font-size: 13px;">Nama Pengunjung</th>
                    <td rowspan="5" style="margin-top:10px;text-align:center">
                        <table width="100%" style="text-align:left">
                            <tbody>
                                <tr>
                                    <td rowspan="5" style="margin-top:10px;text-align:center">
                                        <h2 style="margin:0px;font-size: 22px;">NO ANTRIAN</h2>
                                        <h1 style="font-size: 65px;margin:0px">
                                            <?php
                                            $no = $data['no'];
                                            if ($no < 10) {
                                                echo '00' . $no;
                                            } else if ($no < 100) {
                                                echo '0' . $no;
                                            }
                                            ?>
                                        </h1>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 13px;" id="namaPengunjung"><?= $data['pengunjung']->nama ?></td>
                </tr>
                <tr>
                    <th style="font-size: 13px;">NIK</th>
                </tr>
                <tr>
                    <td style="font-size: 13px;" id="nik"><?= $data['pengunjung']->nik ?></td>
                </tr>
                <tr>
                    <th style="font-size: 13px;">Keterangan</th>
                </tr>
                <tr>
                    <td style="font-size: 13px;" id="keterangan"><?= $data['keterangan'] ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table width="100%" style="text-align:left">
            <tbody>
                <tr>
                    <th style="vertical-align: top;font-size: 13px;" width="50%">Nama Narapidana</th>
                    <td align="right" style="font-size: 13px;">
                        <div style="text-align: right;" id="namaNarapidana"><?= $data['napi']->nama ?></div>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: top;font-size: 13px;">Blok Kamar</th>
                    <td style="font-size: 13px;">
                        <div style="text-align: right;" id="blokKamar"><?= $data['napi']->blokKamar ?></div>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: top;font-size: 13px;">No Registrasi</th>
                    <td style="font-size: 13px;">
                        <div style="text-align: right;" id="noRegis"><?= $data['napi']->noReg ?></div>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: top;font-size: 13px;">UU</th>
                    <td style="font-size: 13px;">
                        <div style="text-align: right;" id="uu"><?= $data['napi']->uu ?></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div style="text-align: center;font-size: 13px;">
            <h4><b>Waktu Kunjungan <span id="waktuKunjungan"><?= $data['waktuKunjungan'] ?></span></b></h4>
        </div>
    </page>
</body>
<script>
    // window.print();
    // setTimeout(function() {
    //     window.close();
    // }, 3000);
    window.onafterprint = window.close;
    window.print();
</script>

</html>