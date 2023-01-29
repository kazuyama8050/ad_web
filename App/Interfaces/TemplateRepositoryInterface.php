<?php
namespace App\Interfaces;

use App\Models\Template\Template;
interface TemplateRepositoryInterface
{
    /**
     * Summary of getById
     * @return Template
     */
    public function getById($advertiserId, $id);

    /**
     * Summary of getByAdvertiserId
     * @return array(Template)
     */
    public function getByAdvertiserId($advertiserId);

    /**
     * Summary of create
     * @return int
     */
    public function create($advertiserId, $url, $imagePath, $bannerText);

    /**
     * Summary of deleteByTemplateId
     * @return 
     */
    public function deleteByTemplateId($templateId);
}