<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = "user";
    protected $primaryKey = "id";
    protected $allowedFields = ["user", "password", "email", "avatar","genres","city","country","debut","bio","recovery_token","expiration_token"];
    protected $validationRules = [
        "user" => "is_unique[user.user]",
        "email" => "valid_email|is_unique[user.email]"
    ];
    protected $validationMessages = [
        "user" => [
            "is_unique" => "THE USER IS ALREADY IN USE"
        ],
        "email" => [
            "valid_email" => "INVALID EMAIL",
            "is_unique" => "THE EMAIL IS ALREADY IN USE"
        ]
    ];
}
?>