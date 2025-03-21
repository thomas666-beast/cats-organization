<?php
$action = $action ?? '/cats/create';
$cat = $cat ?? [];
$cats = $cats ?? [];
$buttonText = $buttonText ?? \App\Core\Translator::trans('Submit');
?>
<form method="POST" action="<?= htmlspecialchars($action); ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <div class="mb-3">
        <label for="name" class="form-label"><?= \App\Core\Translator::trans('Name'); ?>:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($cat['name'] ?? ''); ?>" required>
    </div>
    <div class="mb-3">
        <label for="gender" class="form-label"><?= \App\Core\Translator::trans('Gender'); ?>:</label>
        <select id="gender" name="gender" class="form-select" required>
            <option value="male" <?= ($cat['gender'] ?? '') === 'male' ? 'selected' : ''; ?>><?= \App\Core\Translator::trans('Male'); ?></option>
            <option value="female" <?= ($cat['gender'] ?? '') === 'female' ? 'selected' : ''; ?>><?= \App\Core\Translator::trans('Female'); ?></option>
        </select>
    </div>
    <div class="mb-3">
        <label for="age" class="form-label"><?= \App\Core\Translator::trans('Age'); ?> (<?= \App\Core\Translator::trans('in years'); ?>):</label>
        <input type="number" id="age" name="age" class="form-control" value="<?= htmlspecialchars($cat['age'] ?? ''); ?>" required>
    </div>
    <div class="mb-3">
        <label for="mother_id" class="form-label"><?= \App\Core\Translator::trans('Mother'); ?>:</label>
        <select id="mother_id" name="mother_id" class="form-select">
            <option value=""><?= \App\Core\Translator::trans('Select Mother'); ?></option>
            <?php foreach ($cats as $mother): ?>
                <?php if ($mother['gender'] === 'female' && $mother['id'] != ($cat['id'] ?? '')): ?>
                    <option value="<?= $mother['id']; ?>" <?= ($mother['id'] == ($cat['mother_id'] ?? '')) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($mother['name']); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="father_ids" class="form-label"><?= \App\Core\Translator::trans('Possible Fathers'); ?>:</label>
        <select id="father_ids" name="father_ids[]" class="form-select" multiple>
            <?php foreach ($cats as $father): ?>
                <?php if ($father['gender'] === 'male' && $father['id'] != ($cat['id'] ?? '')): ?>
                    <option value="<?= $father['id']; ?>" <?= in_array($father['id'], $cat['father_ids'] ?? []) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($father['name']); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <small class="form-text text-muted"><?= \App\Core\Translator::trans('Hold Ctrl (Windows) or Command (Mac) to select multiple fathers.'); ?></small>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars($buttonText); ?></button>
</form>
