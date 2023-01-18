<?php
namespace App\Interfaces;

use App\Models\Template\Template;
interface TemplateRepositoryInterface
{
    /**
     * Summary of getById
     * @return Template
     */
    public function getById($id);
    /**
     * Summary of create
     * @return int
     */
    public function create($url, $imagePath, $bannerText);
}