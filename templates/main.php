<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Accounting</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
    <body>
        <div class="container">
            <header class="my-4">
                <h1>Cat Accounting</h1>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/cats">Home</a>
                        <a class="nav-link" href="/cats/create">Add Cat</a>
                    </div>
                </nav>
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
        <script>
            // Automatically dismiss alerts after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                });
            }, 5000);
        </script>
    </body>
</html>