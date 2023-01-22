<?php
namespace App\Models\Advertiser;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    const MAX_STORE_ACCOUNT_LENGTH = 10;
    const MAX_NAME_LENGTH = 30;
    const IS_STOPPED = 1;
    const NO_STOPPED = 0;
    const IS_RETIRE = 1;
    const NO_RETIRE = 0;
    const ADVANCE_PAYMENT = 0;  //前払い
    const REFERRED_PAYMENT = 1;  //後払い

    private $id;
    private $password;
    private $storeAccount;
    private $companyName;
    private $companyZipcode;
    private $companyAddress;
    private $companySiteUrl;
    private $managerLastName;
    private $managerFirstName;
    private $managerPhone;
    private $managerEmail;
    private $paymentWay;
    private $budget;
    private $isStopped;
    private $isRetire;

    public function __construct(
        int $id, string $password = null, string $storeAccount, string $companyName, string $companyZipcode, string $companyAddress, string $companySiteUrl, string $managerLastName, string $managerFirstName, 
        string $managerPhone, string $managerEmail, int $paymentWay, int $budget, int $isStopped, int $isRetire) {

        $this->id = $id;
        $this->password = $password;
        $this->storeAccount = $storeAccount;
        $this->companyName = $companyName;
        $this->companyZipcode = $companyZipcode;
        $this->companyAddress = $companyAddress;
        $this->companySiteUrl = $companySiteUrl;
        $this->managerLastName = $managerLastName;
        $this->managerFirstName = $managerFirstName;
        $this->managerPhone = $managerPhone;
        $this->managerEmail = $managerEmail;
        $this->paymentWay = $paymentWay;
        $this->budget = $budget;
        $this->isStopped = $isStopped;
        $this->isRetire = $isRetire;
    }

    public function getId() {
        return $this->id;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getStoreAccount() {
        return $this->storeAccount;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function getCompanyZipcode() {
        return $this->companyZipcode;
    }

    public function getCompanyAddress() {
        return $this->companyAddress;
    }

    public function getCompanySiteUrl() {
        return $this->companySiteUrl;
    }

    public function getManagerLastName() {
        return $this->managerLastName;
    }

    public function getManagerFirstName() {
        return $this->managerFirstName;
    }

    public function getManagerPhone() {
        return $this->managerPhone;
    }

    public function getManagerEmail() {
        return $this->managerEmail;
    }

    public function getPaymentWay() {
        return $this->paymentWay;
    }

    public function isAdvancePayment() {
        return $this->paymentWay == self::ADVANCE_PAYMENT;
    }

    public function isReferredPayment() {
        return $this->paymentWay == self::REFERRED_PAYMENT;
    }

    public function getBudget() {
        return $this->budget;
    }

    public function getIsStopped() {
        return $this->isStopped;
    }

    public function getIsRetire() {
        return $this->isRetire;
    }

    public function isAdvertiserStopped() {
        return $this->isStopped == self::IS_STOPPED;
    }

    public function isAdvertiserRetire() {
        return $this->isRetire == self::IS_RETIRE;
    }
}