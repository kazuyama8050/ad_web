<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const IS_STOPPED = 1;
    const NO_STOPPED = 0;
    const IS_RETIRE = 1;
    const NO_RETIRE = 0;
    const ADVANCE_PAYMENT = 0;  //前払い
    const REFERRED_PAYMENT = 1;  //後払い

    private $id;
    private $examinationId;
    private $password;
    private $lastName;
    private $firstName;
    private $phone;
    private $email;
    private $zipcode;
    private $address;
    private $paymentWay;
    private $budget;
    private $isStopped;
    private $isRetire;

    public function __construct(
        int $id, int $examinationId, string $password = null, string $lastName, string $firstName, 
        string $phone, string $email, string $zipcode = null, 
        string $address = null, int $paymentWay, int $budget, int $isStopped, int $isRetire) {

        $this->id = $id;
        $this->examinationId = $examinationId;
        $this->password = $password;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->phone = $phone;
        $this->email = $email;
        $this->zipcode = $zipcode;
        $this->address = $address;
        $this->paymentWay = $paymentWay;
        $this->budget = $budget;
        $this->isStopped = $isStopped;
        $this->isRetire = $isRetire;
    }

    public function getId() {
        return $this->id;
    }

    public function getExaminationId() {
        return $this->examinationId;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function getAddress() {
        return $this->address;
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
}