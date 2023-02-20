<?= $this->extend('layouts'); ?>
<?= $this->section('content'); ?>
<section class="section">
    <div class="section-header">
        <h1 class="text-<?= userColor() ?>">Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12 order-md-2 order-sm-2 order-xs-2 order-lg-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-<?= userColor() ?>">Statistik Bulanan</h4>
                        <div class="card-header-action">
                            <select name="tahun" id="tahun" class="custom-select">
                                <?php foreach ($tahun as $t) : ?>
                                    <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="statistikBulanan"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 order-md-1 order-sm-1 order-xs-1 order-lg-2">
                <div class="card card-statistic-2" data-toggle='tooltip' title="Semua">
                    <div class="card-icon bg-<?= userColor() ?>">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Aduan Saya</h4>
                        </div>
                        <div class="card-body">
                            <?= count($aduan) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body card-success">
                            <?php $as = [] ?>
                            <?php foreach ($aduan as $a) : ?>
                                <?php if ($a->status == 'selesai') : ?>
                                    <?php $as[] = $a->status ?>
                                <?php endif ?>
                            <?php endforeach ?>

                            <div class="text-center mb-3 capitalize">Selesai Diproses</div>
                            <h3 class="text-center"><?= count($as) ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body card-info">
                            <?php $as = [] ?>
                            <?php foreach ($aduan as $a) : ?>
                                <?php if ($a->status == 'dalam proses') : ?>
                                    <?php $as[] = $a->status ?>
                                <?php endif ?>
                            <?php endforeach ?>

                            <div class="text-center mb-3">Dalam Proses</div>
                            <h3 class="text-center"><?= count($as) ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body card-warning">
                            <?php $as = [] ?>
                            <?php foreach ($aduan as $a) : ?>
                                <?php if ($a->status == 'belum diproses') : ?>
                                    <?php $as[] = $a->status ?>
                                <?php endif ?>
                            <?php endforeach ?>

                            <div class="text-center mb-3 capitalize">Belum Diproses</div>
                            <h3 class="text-center"><?= count($as) ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body card-danger">
                            <?php $as = [] ?>
                            <?php foreach ($aduan as $a) : ?>
                                <?php if ($a->status == 'dibatalkan') : ?>
                                    <?php $as[] = $a->status ?>
                                <?php endif ?>
                            <?php endforeach ?>

                            <div class="text-center mb-3 capitalize">Dibatalkan</div>
                            <h3 class="text-center"><?= count($as) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12 order-md-2 order-sm-2 order-xs-2 order-lg-1"></div>
            <div class="col-lg-4 col-md-12 col-sm-12 order-md-1 order-sm-1 order-xs-1 order-lg-2"></div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('bottomLibrary'); ?>
<script src="<?= base_url('assets/modules/chart.min.js') ?>"></script>

<script>
    // ready
    $(document).ready(function() {
        getYearly($('#tahun').val());

        const ctx = document.getElementById('statistikBulanan').getContext('2d');
        var yearlyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    label: 'Aduan',
                    borderColor: '<?= userColorHex() ?>',
                    backgroundColor: '#fff',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '<?= userColorHex() ?>',
                    hoverRadius: 10,
                    borderWidth: 3,
                    lineTension: 0,
                    radius: 5,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                ticks: {
                    beginAtZero: true,
                    stepSize: 1,
                }
            }
        });

        $('#tahun').on('change', function() {
            getYearly($(this).val());
        });

        function toMonthName(monthNumber) {
            const date = new Date();
            date.setMonth(monthNumber - 1);

            return date.toLocaleString('en-US', {
                month: 'short',
            });
        }

        async function getYearly(year) {
            const url = `<?= base_url('api/aduan/chart/year') ?>/${year}`
            const response = await fetch(url);
            const data = await response.json();

            yearlyChart.data.labels = [];
            yearlyChart.data.datasets[0].data = [];

            if (data.success) {
                data.data.map((item, index) => {
                    yearlyChart.data.labels.push(toMonthName(item.bulan));
                    yearlyChart.data.datasets[0].data.push(item.total);
                })
                yearlyChart.update();
            }
        }
    });
</script>
<?= $this->endSection(); ?>