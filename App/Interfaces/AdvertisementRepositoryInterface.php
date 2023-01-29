<?php
namespace App\Interfaces;

use App\Models\Advertisement\Advertisement;
interface AdvertisementRepositoryInterface
{
    /**
     * Summary of getByIdForAdvertiser
     * @param mixed $advertisementId
     * @param mixed $advertiserId
     * @return Advertisement
     */
    public function getByIdForAdvertiser($advertisementId, $advertiserId);

    /**
     * Summary of create
     * @param mixed $advertiserId
     * @param mixed $categoryId
     * @param mixed $templateId
     * @param mixed $name
     * @param mixed $price
     * @return int
     */
    public function create($advertiserId, $categoryId, $templateId, $name, $price);
}