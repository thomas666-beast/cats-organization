<?php ob_start(); ?>
<h2><?= \App\Core\Translator::trans('Cat Details'); ?>: <?= htmlspecialchars($cat['name']); ?></h2>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($cat['name']); ?></h5>
        <p class="card-text">
            <strong><?= \App\Core\Translator::trans('Gender'); ?>:</strong> <?= htmlspecialchars($cat['gender']); ?><br>
            <strong><?= \App\Core\Translator::trans('Age'); ?>:</strong> <?= htmlspecialchars($cat['age']); ?> <?= \App\Core\Translator::trans('years'); ?><br>
            <strong><?= \App\Core\Translator::trans('Mother'); ?>:</strong> <?= htmlspecialchars($cat['mother_name']); ?><br>
            <strong><?= \App\Core\Translator::trans('Fathers'); ?>:</strong>
            <?php if (!empty($cat['fathers'])): ?>
        <ul>
            <?php foreach ($cat['fathers'] as $father): ?>
                <li><?= htmlspecialchars($father['name']); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            N/A
        <?php endif; ?>
        </p>
        <a href="/cats" class="btn btn-primary"><?= \App\Core\Translator::trans('Back to List'); ?></a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../../templates/main.php'; ?>
