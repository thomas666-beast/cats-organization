<?php ob_start(); ?>
<h2><?= \App\Core\Translator::trans('Edit Cat'); ?>: <?= htmlspecialchars($cat['name']); ?></h2>
<?php
$action = "/cats/edit/{$cat['id']}";
$buttonText = \App\Core\Translator::trans('Update Cat');
include __DIR__ . '/../components/cat_form.php';
?>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../../templates/main.php'; ?>
