<?php ob_start(); ?>
    <h2>Add a New Cat</h2>

<?php
$action = '/cats/create'; // Define the action for the form
include __DIR__ . '/../components/cat_form.php';
?>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../../templates/main.php'; ?>

