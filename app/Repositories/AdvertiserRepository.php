<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AdvertiserRepositoryInterface;
use App\Models\Advertiser\Advertiser;

class AdvertiserRepository implements AdvertiserRepositoryInterface
{
    public function create($passwordHash, $storeAccount, $companyName, $companyZipcode, $companyAddress, $companySiteUrl,
                            $managerLastName, $managerFirstName, $managerPhone, $managerEmail) {
        $advertiserId = DB::table('advertisers')->insertGetId([
            'store_account' => $storeAccount,
            'password' => $passwordHash,
            'company_name' => $companyName,
            'company_zipcode' => $companyZipcode,
            'company_address' => $companyAddress,
            'company_site_url' => $companySiteUrl,
            'manager_last_name' => $managerLastName,
            'manager_first_name' => $managerFirstName,
            'manager_phone' => $managerPhone,
            'manager_email' => $managerEmail,
            'is_stopped' => Advertiser::NO_STOPPED,
            'is_retire' => Advertiser::NO_RETIRE,
        ]);

        return $advertiserId;
    }

    public function getAll() {
        $advertisers = DB::table('advertisers')->where(['is_stopped'=>Advertiser::NO_STOPPED, 'is_retire'=>Advertiser::NO_RETIRE])->get();
        $advertiserList = [];
        foreach ($advertisers as $advertiser) {
            $advertiserList[] = $this->rowMapper($advertiser);
        }
        return $advertiserList;
    }

    public function getById($advertiserId) {
        $advertiser = DB::table('advertisers')->where('id', $advertiserId)->first();
        return $this->rowMapper($advertiser);
    }

    public function getByStoreAccount($storeAccount) {
        $advertiser = DB::table('advertisers')->where('store_account', $storeAccount)->first();
        return $this->rowMapper($advertiser, true);
    }

    public function getByManagerEmail($managerEmail) {
        $advertiser = DB::table('advertisers')->where('manager_email', $managerEmail)->first();
        return $this->rowMapper($advertiser, true);
    }

    private function rowMapper($row, $pass = false) {
        if (empty($row)) {
            return null;
        }

        $password = null;
        if ($pass) {
            $password = $row->password;
        }

        return new Advertiser(
            (int) $row->id,
            $password,
            $row->store_account,
            $row->company_name,
            $row->company_zipcode,
            $row->company_address,
            $row->company_site_url,
            $row->manager_last_name,
            $row->manager_first_name,
            $row->manager_phone,
            $row->manager_email,
            (int) $row->payment_way,
            (int) $row->budget,
            (int) $row->is_stopped,
            (int) $row->is_retire,
        );
    }
}