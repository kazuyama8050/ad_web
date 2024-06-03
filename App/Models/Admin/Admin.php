<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    private $id;
    private $password;
    private $email;
    private $authority;

    public function __construct(
        int $id, string $password = null, string $email, int $authority) {

        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->authority = $authority;
    }

    public function getId() {
        return $this->id;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAuthority() {
        return $this->authority;
    }

}