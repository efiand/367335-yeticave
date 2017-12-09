
<?= $data['categories']; ?>
<?php
if (! isset($data['blank'])) :
    require 'templates/lots_list.php';
else : ?>

		<section class="lots container">
            <div class="lots__header">
                <h2><?= $data['blank']; ?></h2>
            </div>
        </section><?php endif; ?>

