<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    private $id;
    private $name;
    private $level;
    private $parentId;
    private $floorPrice;
    private $averageBidPrice;

    // protected $fillable = [
    //     'id',
    //     'name',
    //     'level',
    //     'parent_id',
    //     'floor_price',
    //     'average_bid_price',
    // ];

    public function __construct(int $id, string $name, int $level, int $parentId, int $floorPrice, $averageBidPrice) {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->parentId = $parentId;
        $this->floorPrice = $floorPrice;
        $this->averageBidPrice = $averageBidPrice;
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
}