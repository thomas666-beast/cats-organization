<?php

namespace App\Models;

use App\Interfaces\CatRepositoryInterface;
use PDO;

class CatRepository implements CatRepositoryInterface
{
    private Model $model;

    public function __construct() {
        $this->model = new Model('cats');
    }

    public function all(): array
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data): false|string
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): int
    {
        return $this->model->update($id, $data);
    }

    public function delete($id): int
    {
        return $this->model->delete($id);
    }

    public function filterByAgeAndGender($minAge, $maxAge, $gender, $page = 1, $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM cats WHERE age >= :minAge AND age <= :maxAge";
        $params = [
            'minAge' => $minAge,
            'maxAge' => $maxAge
        ];

        if (!empty($gender)) {
            $sql .= " AND gender = :gender";
            $params['gender'] = $gender;
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = $perPage;
        $params['offset'] = $offset;

        $stmt = $this->model->getConnection()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginate($page = 1, $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM cats LIMIT :limit OFFSET :offset";

        $stmt = $this->model->getConnection()->prepare($sql);
        $stmt->bindValue(':limit', (int) $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function count()
    {
        $stmt = $this->model->getConnection()->prepare("SELECT COUNT(*) as total FROM cats");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function searchByName($name, $page = 1, $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM cats WHERE name LIKE :name LIMIT :limit OFFSET :offset";
        $stmt = $this->model->getConnection()->prepare($sql);
        $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int) $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByName($name)
    {
        $stmt = $this->model->getConnection()->prepare("SELECT COUNT(*) as total FROM cats WHERE name LIKE :name");
        $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function findFathers($catId): array
    {
        $sql = "SELECT c.* FROM cats c
            JOIN cat_fathers cf ON c.id = cf.father_id
            WHERE cf.cat_id = :catId";
        $stmt = $this->model->getConnection()->prepare($sql);
        $stmt->execute(['catId' => $catId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFather($catId, $fatherId): void
    {
        $sql = "INSERT INTO cat_fathers (cat_id, father_id) VALUES (:catId, :fatherId)";
        $stmt = $this->model->getConnection()->prepare($sql);
        $stmt->execute(['catId' => $catId, 'fatherId' => $fatherId]);
    }

    public function updateFathers($catId, array $fatherIds): void
    {
        $this->model->getConnection()->prepare("DELETE FROM cat_fathers WHERE cat_id = :catId")
            ->execute(['catId' => $catId]);

        foreach ($fatherIds as $fatherId) {
            $this->addFather($catId, $fatherId);
        }
    }

    public function countFilteredCats($minAge, $maxAge, $gender) {
        $sql = "SELECT COUNT(*) as total FROM cats WHERE age >= :minAge AND age <= :maxAge";
        $params = [
            'minAge' => $minAge,
            'maxAge' => $maxAge
        ];

        if (!empty($gender)) {
            $sql .= " AND gender = :gender";
            $params['gender'] = $gender;
        }

        // Execute the query
        $stmt = $this->model->getConnection()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
