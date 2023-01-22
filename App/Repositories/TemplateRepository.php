<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TemplateRepositoryInterface;
use App\Models\Template\Template;

class TemplateRepository implements TemplateRepositoryInterface
{
    public function getById($id) {
        $template = DB::table('templates')->where('id', $id)->first();
        return $this->rowMapper($template);
    }

    public function create($url, $imagePath, $bannerText) {
        $templateId = DB::table('templates')->insertGetId([
            'url' => $url,
            'text' => $bannerText,
            'image_path' => $imagePath,
        ]);

        return $templateId;
    }

    /**
     * Summary of rowMapper
     * @param mixed $row
     * @return Template|null
     */
    private function rowMapper($row) {
        if (empty($row)) {
            return null;
        }
        return new Template(
            (int) $row->id,
            $row->url,
            $row->text,
            $row->image_path,
        );
    }
}