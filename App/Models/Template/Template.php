<?php
namespace App\Models\Template;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    const URL_PATTERN = '/https?:\/{2}[\w\/:%#\$&\?\(\)~\.=\+\-]+/';
    const MAX_TEXT_SIZE = 50;
    const MIN_TEXT_SIZE = 10;
    const IMAGE_WIDTH = 30;
    const IMAGE_HEIGHT = 30;


    private $id;
    private $url;
    private $text;
    private $image_path;

    public function __construct(int $id, string $url, string $text, string $image_path) {
        $this->id = $id;
        $this->url = $url;
        $this->text = $text;
        $this->imagePath = $image_path;
    }

    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getText() {
        return $this->text;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

}