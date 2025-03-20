<?php ob_start(); ?>
    <h2>All Cats</h2>

    <!-- Search Form -->
<!--    <form method="GET" action="/cats" class="mb-4">-->
<!--        <div class="input-group">-->
<!--            <input type="text" name="search" class="form-control" placeholder="Search by name..." value="--><?php //= $_GET['search'] ?? ''; ?><!--">-->
<!--            <button type="submit" class="btn btn-primary">Search</button>-->
<!--        </div>-->
<!--    </form>-->

    <!-- Filter Form -->
    <form method="GET" action="/cats" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="minAge" class="form-label">Min Age:</label>
                <input type="number" id="minAge" name="minAge" class="form-control" value="<?= $_GET['minAge'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="maxAge" class="form-label">Max Age:</label>
                <input type="number" id="maxAge" name="maxAge" class="form-control" value="<?= $_GET['maxAge'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="gender" class="form-label">Gender:</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="">All</option>
                    <option value="male" <?= ($_GET['gender'] ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?= ($_GET['gender'] ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/cats" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Cats Table -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Mother</th>
            <th>Actions</th>
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
                    <a href="/cats/show/<?= $cat['id']; ?>" class="btn btn-sm btn-info">View</a>
                    <a href="/cats/edit/<?= $cat['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/cats/delete/<?= $cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
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
