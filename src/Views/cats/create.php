<?php ob_start(); ?>
<h2><?= \App\Core\Translator::trans('Add a New Cat'); ?></h2>
<?php
$action = '/cats/create';
$buttonText = \App\Core\Translator::trans('Add Cat');
include __DIR__ . '/../components/cat_form.php';
?>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../../templates/main.php'; ?>

