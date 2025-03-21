<?php ob_start(); ?>
<h2><?= \App\Core\Translator::trans('All cats'); ?></h2>
<form method="GET" action="/cats" class="mb-4">
    <div class="row g-3">
        <div class="col-md-3">
            <label for="minAge" class="form-label"><?= \App\Core\Translator::trans('Min Age'); ?>:</label>
            <input type="number" id="minAge" name="minAge" class="form-control" value="<?= $_GET['minAge'] ?? ''; ?>">
        </div>
        <div class="col-md-3">
            <label for="maxAge" class="form-label"><?= \App\Core\Translator::trans('Max Age'); ?>:</label>
            <input type="number" id="maxAge" name="maxAge" class="form-control" value="<?= $_GET['maxAge'] ?? ''; ?>">
        </div>
        <div class="col-md-3">
            <label for="gender" class="form-label"><?= \App\Core\Translator::trans('Gender'); ?>:</label>
            <select id="gender" name="gender" class="form-select">
                <option value=""><?= \App\Core\Translator::trans('All'); ?></option>
                <option value="male" <?= ($_GET['gender'] ?? '') === 'male' ? 'selected' : ''; ?>><?= \App\Core\Translator::trans('Male'); ?></option>
                <option value="female" <?= ($_GET['gender'] ?? '') === 'female' ? 'selected' : ''; ?>><?= \App\Core\Translator::trans('Female'); ?></option>
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary"><?= \App\Core\Translator::trans('Filter'); ?></button>
            <a href="/cats" class="btn btn-secondary"><?= \App\Core\Translator::trans('Reset'); ?></a>
        </div>
    </div>
</form>
<table class="table table-striped">
    <thead>
    <tr>
        <th><?= \App\Core\Translator::trans('Name'); ?></th>
        <th><?= \App\Core\Translator::trans('Gender'); ?></th>
        <th><?= \App\Core\Translator::trans('Age'); ?></th>
        <th><?= \App\Core\Translator::trans('Mother'); ?></th>
        <th><?= \App\Core\Translator::trans('Actions'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($cats as $cat): ?>
        <tr>
            <td><?= htmlspecialchars($cat['name']); ?></td>
            <td><?= htmlspecialchars($cat['gender']); ?></td>
            <td><?= htmlspecialchars($cat['age']); ?></td>
            <td>
                <?php if ($cat['mother_id']): ?>
                    <?= htmlspecialchars($this->service->getCatById($cat['mother_id'])['name'] ?? 'Unknown'); ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <a href="/cats/show/<?= $cat['id']; ?>" class="btn btn-sm btn-info"><?= \App\Core\Translator::trans('View'); ?></a>
                <a href="/cats/edit/<?= $cat['id']; ?>" class="btn btn-sm btn-warning"><?= \App\Core\Translator::trans('Edit'); ?></a>
                <a href="/cats/delete/<?= $cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('<?= \App\Core\Translator::trans('Are you sure?'); ?>')"><?= \App\Core\Translator::trans('Delete'); ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="/cats?page=<?= $i; ?>&search=<?= $_GET['search'] ?? ''; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../../templates/main.php'; ?>
