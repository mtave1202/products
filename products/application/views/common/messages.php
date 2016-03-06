<?php if (get_danger_message()) : ?>
<div class="alert alert-danger"><?= get_danger_message(); ?></div>
<?php endif; ?>
<?php if (get_success_message()) : ?>
<div class="alert alert-success"><?= get_success_message(); ?></div>
<?php endif; ?>
<?php if (get_info_message()) : ?>
<div class="alert alert-info"><?= get_info_message() ?></div>
<?php endif; ?>