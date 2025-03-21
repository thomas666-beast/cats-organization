<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cats Organization</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
    <body>
        <div class="container">
            <header class="my-4">
                <h1><?= \App\Core\Translator::trans('Cat Organization') ?></h1>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/cats"><?= \App\Core\Translator::trans('Home') ?></a>
                        <a class="nav-link" href="/cats/create"><?=\App\Core\Translator::trans('Add a New Cat')?></a>
                    </div>
                </nav>

                <div class="language-switcher mt-3">
                    <a href="/change-locale/en" class="btn btn-sm btn-outline-primary">English</a>
                    <a href="/change-locale/ru" class="btn btn-sm btn-outline-primary">Русский</a>
                </div>
            </header>

            <!-- Display Notifications -->
            <div class="notifications">
                <?php displayNotifications(); ?>
            </div>

            <main>
                <?= $content; ?>
            </main>
            <footer class="my-4">
                <p>&copy; <?= date('Y'); ?> Cat Organization</p>
            </footer>
        </div>
        <script src="/assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>