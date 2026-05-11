<?php if (session()->getFlashdata('success')): ?>
    <div class="flash flash-success alert alert-success" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flash flash-error alert alert-danger" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>
