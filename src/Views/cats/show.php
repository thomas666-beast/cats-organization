<?php ob_start(); ?>
    <h2>Cat Details: <?= htmlspecialchars($cat['name']); ?></h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($cat['name']); ?></h5>
            <p class="card-text">
                <strong>Gender:</strong> <?= htmlspecialchars($cat['gender']); ?><br>
                <strong>Age:</strong> <?= htmlspecialchars($cat['age']); ?> years<br>
                <strong>Mother:</strong> <?= htmlspecialchars($cat['mother_name']); ?><br>
                <strong>Fathers:</strong>
                <strong>Fathers:</strong>
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
            <a href="/cats" class="btn btn-primary">Back to List</a>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../../templates/main.php'; ?>
