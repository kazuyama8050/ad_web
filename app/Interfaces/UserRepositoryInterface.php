<?php
namespace App\Interfaces;

use App\Models\User\User;

interface UserRepositoryInterface
{

    /**
     * Summary of getAll
     * @return array(User)
     */
    public function getAll();

    /**
     * Summary of getById
     * @param mixed $userId
     * @return User
     */
    public function getById($userId);


    /**
     * Summary of create
     * @param mixed $examinationId
     * @param mixed $passwordHash
     * @param mixed $lastName
     * @param mixed $firstName
     * @param mixed $phone
     * @param mixed $email
     * @return int
     */
    public function create($examinationId, $passwordHash, $lastName, $firstName, $phone, $email);
}