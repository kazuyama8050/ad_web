<?php
namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    const IS_STOPPED = 1;
    const NO_STOPPED = 0;
    const REVIEW_BEFORE = 0;
    const REVIEW_OK = 1;
    const REVIEW_NG = 2;
    private $id;
    private $advertiserId;
    private $categoryId;
    private $templateId;
    private $name;
    private $price;
    private $isStopped;
    private $reviewFlag;

    public function __construct(int $id, int $advertiserId, int $categoryId, int $templateId, string $name, int $price, int $isStopped, int $reviewFlag) {
        $this->id = $id;
        $this->advertiserId = $advertiserId;
        $this->categoryId = $categoryId;
        $this->templateId = $templateId;
        $this->name = $name;
        $this->price = $price;
        $this->isStopped = $isStopped;
        $this->reviewFlag = $reviewFlag;
    }

    public function getId() {
        return $this->id;
    }

    public function getAdvertiserId() {
        return $this->advertiserId;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function getTemplateId() {
        return $this->templateId;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getIsStopped() {
        return $this->isStopped;
    }

    public function getReviewFlag() {
        return $this->reviewFlag;
    }

    public function isStopped() {
        return $this->isStopped == self::IS_STOPPED;
    }

    public function isReviewBefore() {
        return $this->reviewFlag == self::REVIEW_BEFORE;
    }

    public function isReviewOk() {
        return $this->reviewFlag == self::REVIEW_OK;
    }

    public function isReviewNg() {
        return $this->reviewFlag == self::REVIEW_NG;
    }

}