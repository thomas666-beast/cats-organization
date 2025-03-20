<?php

namespace App\Controllers;

use App\Services\CatService;
use App\Core\Request;

class CatController {
    private CatService $service;

    public function __construct(CatService $service) {
        $this->service = $service;
    }

    public function index() {
        $page = $_GET['page'] ?? 1;
        $perPage = 10;
        $search = $_GET['search'] ?? '';
        $minAge = $_GET['minAge'] ?? 0;
        $maxAge = $_GET['maxAge'] ?? 100;
        $gender = $_GET['gender'] ?? '';

        if ($search) {
            // Handle search
            $cats = $this->service->searchByName($search, $page, $perPage);
            $totalCats = $this->service->countByName($search);
        } else {
            // Handle filtering
            $cats = $this->service->getFilteredCats($minAge, $maxAge, $gender, $page, $perPage);
            $totalCats = $this->service->countFilteredCats($minAge, $maxAge, $gender);
        }

        $totalPages = ceil($totalCats / $perPage);

        include __DIR__ . '/../Views/cats/index.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Request::validateCsrfToken();

                $data = Request::getPostData();
                unset($data['csrf_token']);

                if ($data['mother_id'] === '') {
                    $data['mother_id'] = null;
                }

                $fatherIds = $data['father_ids'] ?? [];
                unset($data['father_ids']);

                $catId = $this->service->createCat($data);

                if (!empty($fatherIds)) {
                    foreach ($fatherIds as $fatherId) {
                        $this->service->addFather($catId, $fatherId);
                    }
                }

                setNotification('success', 'Cat added successfully!');
                header('Location: /cats');
                exit;
            } catch (\Exception $e) {
                setNotification('danger', $e->getMessage());
            }
        }

        $cats = $this->service->getAllCats();
        include __DIR__ . '/../Views/cats/create.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Request::validateCsrfToken();

                $data = Request::getPostData();
                unset($data['csrf_token']);

                if ($data['mother_id'] === '') {
                    $data['mother_id'] = null;
                }

                $fatherIds = $data['father_ids'] ?? [];
                unset($data['father_ids']);

                $this->service->updateCat($id, $data);
                $this->service->updateFathers($id, $fatherIds);

                setNotification('success', 'Cat updated successfully!');
                header('Location: /cats');
                exit;
            } catch (\Exception $e) {
                setNotification('danger', $e->getMessage());
            }
        }

        $cat = $this->service->getCatById($id);
        $cats = array_filter($this->service->getAllCats(), fn($c) => $c['id'] != $id);
        $currentFathers = $this->service->getFathers($id);
        $cat['father_ids'] = array_column($currentFathers, 'father_id');

        include __DIR__ . '/../Views/cats/edit.php';
    }

    public function delete($id) {
        try {
            $this->service->deleteCat($id);
            setNotification('success', 'Cat deleted successfully!');
        } catch (\Exception $e) {
            setNotification('danger', $e->getMessage());
        }

        header('Location: /cats');
        exit;
    }

    public function show($id) {
        $cat = $this->service->getCatById($id);

        if (!$cat) {
            http_response_code(404);
            echo "Cat not found.";
            return;
        }

        if ($cat['mother_id']) {
            $mother = $this->service->getCatById($cat['mother_id']);
            $cat['mother_name'] = $mother['name'] ?? 'Unknown';
        } else {
            $cat['mother_name'] = 'N/A';
        }

        $cat['fathers'] = $this->service->getFathers($id);

        include __DIR__ . '/../Views/cats/show.php';
    }

    public function filter(): void
    {
        $minAge = $_GET['minAge'] ?? 0;
        $maxAge = $_GET['maxAge'] ?? 100;
        $gender = $_GET['gender'] ?? 'male';

        $cats = $this->service->getFilteredCats($minAge, $maxAge, $gender);
        include __DIR__ . '/../Views/cats/index.php';
    }


}
