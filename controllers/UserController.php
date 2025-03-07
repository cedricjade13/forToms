<?php
require_once '../models/User.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function createUser ($data) {
        return $this->userModel->create($data);
    }

    public function updateUser ($id, $data) {
        return $this->userModel->update($id, $data);
    }

    public function deleteUser ($id) {
        return $this->userModel->delete($id);
    }

    public function displayUsers() {
        return $this->userModel->getAll();
    }

    public function viewUser ($id) {
        return $this->userModel->getById($id);
    }
    
}
?>