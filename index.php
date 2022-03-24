<?php

require 'helper/functions.php';

if (isset($_GET['city']) && isset($_GET['month']) && isset($_GET['year'])) {
    $kota = $_GET['city'];
    $month = $_GET['month'];
    $year = $_GET['year'];

    $period = $year . '-' . $month;

    $url    = "https://jadwal-shalat-api.herokuapp.com/monthly?month=" . $period . "&cityId=" . $kota;
    $jadwal   = http_request($url);

    $jadwal   = json_decode($jadwal, true);
} else {
    $kota = '';
    $month = '';
    $year = '';
}

$citiesUrl = "https://jadwal-shalat-api.herokuapp.com/cities";

$cities  = http_request($citiesUrl);

$cities  = json_decode($cities, true);

// var_dump($cities['data']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Jadwal Sholat Indonesia</title>
</head>

<body>
    <div class="container">
        <div class="card my-5">
            <div class="card-body">
                <h5 class="card-title">Jadwal Sholat Indonesia</h5>
                <form action="" method="GET">
                    <div class="mb-3">
                        <label for="inputCity" class="form-label">Kota</label>
                        <select class="form-select" id="inputCity" name="city">
                            <option> - Pilih Kota - </option>
                            <?php foreach ($cities['data'] as $city) : ?>
                                <option value="<?= $city['cityId']; ?>" <?= ($kota == $city['cityId']) ? 'selected' : ''; ?>><?= $city['cityName']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <div class="row">
                            <div class="col">
                                <select class="form-select" name="month">
                                    <option> - Pilih Bulan - </option>
                                    <option value="01" <?= ($month == "01") ? 'selected' : '' ?>>Januari</option>
                                    <option value="02" <?= ($month == "02") ? 'selected' : '' ?>>Februari</option>
                                    <option value="03" <?= ($month == "03") ? 'selected' : '' ?>>Maret</option>
                                    <option value="04" <?= ($month == "04") ? 'selected' : '' ?>>April</option>
                                    <option value="05" <?= ($month == "05") ? 'selected' : '' ?>>Mei</option>
                                    <option value="06" <?= ($month == "06") ? 'selected' : '' ?>>Juni</option>
                                    <option value="07" <?= ($month == "07") ? 'selected' : '' ?>>Juli</option>
                                    <option value="08" <?= ($month == "08") ? 'selected' : '' ?>>Agustus</option>
                                    <option value="09" <?= ($month == "09") ? 'selected' : '' ?>>September</option>
                                    <option value="10" <?= ($month == "10") ? 'selected' : '' ?>>Oktober</option>
                                    <option value="11" <?= ($month == "11") ? 'selected' : '' ?>>November</option>
                                    <option value="12" <?= ($month == "12") ? 'selected' : '' ?>>Desember</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" name="year">
                                    <option> - Pilih Tahun - </option>
                                    <?php for ($tahun = 2020; $tahun <= 2022; $tahun++) { ?>
                                        <option value="<?= $tahun; ?>" <?= ($year == $tahun) ? 'selected' : '' ?>><?= $tahun; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <?php if (isset($_GET['city']) && isset($_GET['month']) && isset($_GET['year'])) { ?>
                    <div class="my-5">
                        <h5><?= str_replace('(Untuk', '', str_replace(')', '', $jadwal['data']['region'])) . ' (' . $jadwal['data']['month'] . ')'; ?></h5>
                        <table class="table table-striped table-inverse table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Subuh</th>
                                    <th>Dhuhur</th>
                                    <th>Asar</th>
                                    <th>Maghrib</th>
                                    <th>Isya'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwal['data']['data'] as $tanggal) : ?>
                                    <tr>
                                        <td><?= $tanggal['date'] ?></td>
                                        <?php foreach ($tanggal['dataRow'] as $waktu) : ?>
                                            <td><?= $waktu['time']; ?></td>
                                        <?php endforeach ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>