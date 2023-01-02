<?php
namespace App\Models\UserExamination;

use Illuminate\Database\Eloquent\Model;

class UserExamination extends Model
{
    const MaxNameLength = 30;
    const EmailPattern = "/^[a-zA-Z0-9!#\$%&`\+\*\-\/\^\{\}_\.]+@[a-zA-Z0-9!#\$%&`\+\*\-\/\^\{\}_\.]+\.[a-zA-Z0-9!#\$%&`\+\*\-\/\^\{\}_\.]+$/";
    const PhonePattern = "/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/";
    const REVIEW_BEFORE = 0;
    const REVIEW_OK = 1;
    const REVIEW_NG = 2;
    private $id;
    private $lastName;
    private $firstName;
    private $phone;
    private $email;
    private $siteDomein;
    private $category;
    private $reviewFlag;

    public function __construct(int $id, string $lastName, string $firstName, 
                                string $phone, string $email, string $siteDomein, 
                                string $category, int $reviewFlag) {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->phone = $phone;
        $this->email = $email;
        $this->siteDomein = $siteDomein;
        $this->category = $category;
        $this->reviewFlag = $reviewFlag;
    }

    protected $fillable = [
        'last_name',
        'first_name',
        'phone',
        'email',
        'site_domein',
        'category',
        'review_flag',
    ];

    public function getId() {
        return $this->id;
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

    public function getSiteDomein() {
        return $this->siteDomein;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getReviewFlag() {
        return $this->reviewFlag;
    }

    public function isBeforeReview() {
        return $this->reviewFlag == 0;
    }

    public function isRegister() {
        return $this->reviewFlag == 1;
    }

    public function isNonRegister() {
        return $this->reviewFlag == 2;
    }

}