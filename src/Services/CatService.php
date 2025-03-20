<?php

namespace App\Services;

use App\Models\CatRepository;
use App\Core\Validator;
use PDO;

class CatService {
    private $repository;

    public function __construct(CatRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllCats() {
        return $this->repository->all();
    }

    public function getCatById($id) {
        return $this->repository->find($id);
    }

    public function createCat(array $data)
    {
        // Validate required fields
        Validator::validateRequired($data, ['name', 'gender', 'age']);

        // Validate unique name
        Validator::validateUnique('cats', 'name', $data['name']);

        // Validate age is an integer
        Validator::validateInteger($data['age'], 'age');

        // Create the cat
        return $this->repository->create($data);
    }

    public function updateCat($id, array $data): void
    {
        // Validate required fields
        Validator::validateRequired($data, ['name', 'gender', 'age']);

        // Validate age is an integer
        Validator::validateInteger($data['age'], 'age');

        // Update the cat
        $this->repository->update($id, $data);
    }

    public function deleteCat($id): int
    {
        return $this->repository->delete($id);
    }

    public function getFilteredCats($minAge, $maxAge, $gender, $page = 1, $perPage = 10): array
    {
        return $this->repository->filterByAgeAndGender($minAge, $maxAge, $gender, $page = 1, $perPage = 10);
    }

    public function addFather($catId, $fatherId): void
    {
        $this->repository->addFather($catId, $fatherId);
    }

    public function updateFathers($catId, array $fatherIds): void
    {
        $this->repository->updateFathers($catId, $fatherIds);
    }

    public function getFathers($catId): array
    {
        return $this->repository->findFathers($catId);
    }

    public function searchByName($name, $page = 1, $perPage = 10): array
    {
        return $this->repository->searchByName($name, $page, $perPage);
    }

    public function countByName($name)
    {
        return $this->repository->countByName($name);
    }

    public function countFilteredCats($minAge, $maxAge, $gender)
    {
        return $this->repository->countFilteredCats($minAge, $maxAge, $gender);
    }
}
