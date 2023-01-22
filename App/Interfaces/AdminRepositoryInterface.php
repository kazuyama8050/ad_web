<?php
namespace App\Interfaces;

use App\Models\Admin\Admin;

interface AdminRepositoryInterface
{
    /**
     * Summary of getByEmail
     * @param mixed $email
     * @return Admin
     */
    public function getByEmail($email);
}