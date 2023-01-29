<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AdvertisementRepositoryInterface;
use App\Models\Advertisement\Advertisement;

class AdvertisementRepository implements AdvertisementRepositoryInterface {

    public function create($advertiserId, $categoryId, $templateId, $name, $price) {
        $advertisementId = DB::table('advertisements')->insertGetId([
            'advertiser_id' => $advertiserId,
            'category_id' => $categoryId,
            'template_id' => $templateId,
            'name' => $name,
            'bid_price' => $price,
            'is_stopped' => Advertisement::NO_STOPPED,
            'review_flag' => Advertisement::REVIEW_BEFORE,
        ]);

        return $advertisementId;
    }

    public function getByIdForAdvertiser($advertisementId, $advertiserId) {
        $advertisement = DB::table('advertisements')
            ->where([['id', $advertisementId], ['advertiser_id', $advertiserId]])->first();

        return $this->rowMapper($advertisement);
    }

    /**
     * Summary of rowMapper
     * @param mixed $row
     * @return Advertisement|null
     */
    private function rowMapper($row) {
        if (empty($row)) {
            return null;
        }
        return new Advertisement(
            (int) $row->id,
            (int) $row->advertiser_id,
            (int) $row->category_id,
            (int) $row->template_id,
            $row->name,
            (int) $row->bid_price,
            (int) $row->is_stopped,
            (int) $row->review_flag,
        );
    }
}