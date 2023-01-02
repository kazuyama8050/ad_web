<?php
namespace App\Interfaces;

use App\Models\UserExamination\UserExamination;
interface UserExaminationRepositoryInterface
{
    /**
     * Summary of getById
     * @param mixed $id
     * @return UserExamination
     */
    public function getById($id);

    /**
     * Summary of getAll
     * @return array(UserExamination)
     */
    public function getAll();

    /**
     * Summary of validateEmail
     * @param mixed $email
     * @return int
     */
    public function validateEmail($email);

    /**
     * Summary of validateEmail
     * @param mixed $phone
     * @return int
     */
    public function validatePhone($phone);

    /**
     * Summary of create
     * @param mixed $lastName
     * @param mixed $firstName
     * @param mixed $phone
     * @param mixed $email
     * @param mixed $siteDomein
     * @param mixed $category
     * @return $id
     */
    public function create($lastName, $firstName, $phone, $email, $siteDomein, $category);
}