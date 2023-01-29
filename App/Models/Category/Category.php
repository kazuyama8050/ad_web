<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    const MAX_PRICE = 1000;

    private $id;
    private $name;
    private $level;
    private $parentId;
    private $floorPrice;
    private $averageBidPrice;
    private $isDelete;

    // protected $fillable = [
    //     'id',
    //     'name',
    //     'level',
    //     'parent_id',
    //     'floor_price',
    //     'average_bid_price',
    // ];

    public function __construct(int $id, string $name, int $level, int $parentId, int $floorPrice, $averageBidPrice, $isDelete) {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->parentId = $parentId;
        $this->floorPrice = $floorPrice;
        $this->averageBidPrice = $averageBidPrice;
        $this->isDelete = $isDelete;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLevel() {
        return $this->level;
    }

    public function isLevel1() {
        return $this->level == 1;
    }

    public function isLevel2() {
        return $this->level == 2;
    }

    public function isLevel3() {
        return $this->level == 3;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function getFloorPrice() {
        return $this->floorPrice;
    }

    public function getAverageBidPrice() {
        return $this->averageBidPrice;
    }

    public function hasAverageBidPrice() {
        return !empty($this->averageBidPrice);
    }

    public function getIsDelete() {
        return $this->isDelete;
    }

    public function isDeleted() {
        return $this->isDelete == 1;
    }
}