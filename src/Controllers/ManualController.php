<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ManualController extends Controller {
    
    public function index() {
        $user = User::getById(1);
        $this->view('pages/admin/manual', ['user' => $user]);
    }
}