<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= esc($title ?? 'Espace interne') ?></title>
    <link href="<?= base_url('niceadmin/assets/img/favicon.png') ?>" rel="icon">
    <link href="<?= base_url('niceadmin/assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('niceadmin/assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <?= view('partials/navbar_admin', ['pageTitle' => $title ?? 'Espace interne']) ?>
    <main id="main" class="main">
        <?= $this->renderSection('content') ?>
    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
            Projet Regime Alimentaire
        </div>
        <div class="credits">
            Interface basee sur NiceAdmin pour standardiser l'experience back-office.
        </div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="<?= base_url('niceadmin/assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/chart.js/chart.umd.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/echarts/echarts.min.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/quill/quill.min.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/simple-datatables/simple-datatables.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/tinymce/tinymce.min.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/vendor/php-email-form/validate.js') ?>"></script>
    <script src="<?= base_url('niceadmin/assets/js/main.js') ?>"></script>
</body>
</html>
