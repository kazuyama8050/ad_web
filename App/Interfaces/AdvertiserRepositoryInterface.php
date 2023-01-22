<?php
namespace App\Interfaces;

use App\Models\Advertiser\Advertiser;

interface AdvertiserRepositoryInterface
{

    /**
     * Summary of getAll
     * @return array(Advertiser)
     */
    public function getAll();

    /**
     * Summary of getById
     * @param mixed $advertiserId
     * @return Advertiser
     */
    public function getById($advertiserId);

    /**
     * Summary of getByStoreAccount
     * @param mixed $storeAccount
     * @return Advertiser
     */
    public function getByStoreAccount($storeAccount);

    /**
     * Summary of getByEmail
     * @param mixed $managerEmail
     * @return Advertiser
     */
    public function getByManagerEmail($managerEmail);


    /**
     * Summary of create
     * @param mixed $passwordHash
     * @param mixed $storeAccount
     * @param mixed $companyName
     * @param mixed $companyZipcode
     * @param mixed $companyAddress
     * @param mixed $managerLastName
     * @param mixed $managerFirstName
     * @param mixed $managerPhone
     * @param mixed $managerEmail
     * @return int
     */
    public function create(
        $passwordHash,
        $storeAccount,
        $companyName,
        $companyZipcode,
        $companyAddress,
        $companySiteUrl,
        $managerLastName,
        $managerFirstName,
        $managerPhone,
        $managerEmail
    );
}