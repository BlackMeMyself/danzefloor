<?php

namespace App\Models;

use CodeIgniter\Model;

class Files extends Model
{
    protected $table = "files";
    protected $primaryKey = "id";
    protected $allowedFields = ["name", "upload_date", "id_user", "length", "format", "genre", "type","image"];
}
?>