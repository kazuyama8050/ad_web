<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TemplateRepositoryInterface;
use App\Models\Template\Template;

class TemplateRepository implements TemplateRepositoryInterface
{
    public function getById($advertiserId, $id) {
        $template = DB::table('templates')->where([['id', $id], ['advertiser_id', $advertiserId]])->first();
        return $this->rowMapper($template);
    }
    public function getByAdvertiserId($advertiserId) {
        $templates = DB::table('templates')->where('advertiser_id', $advertiserId)->get();
        if (empty($templates)) {
            return [];
        }
        $templateList = [];
        foreach ($templates as $template) {
            $templateList[] = $this->rowMapper($template);
        }
        return $templateList;
    }

    public function create($advertiserId, $url, $imagePath, $bannerText) {
        $templateId = DB::table('templates')->insertGetId([
            'advertiser_id' => $advertiserId,
            'url' => $url,
            'text' => $bannerText,
            'image_path' => $imagePath,
        ]);

        return $templateId;
    }

    public function deleteByTemplateId($templateId) {
        DB::table('templates')->where('id', $templateId)->delete();
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
            (int) $row->advertiser_id,
            $row->url,
            $row->text,
            $row->image_path,
        );
    }
}