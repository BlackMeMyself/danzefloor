<?php  
    namespace App\Models;
    use CodeIgniter\Model;

    class Events extends Model{
        protected $table="events";
        protected $primaryKey="id";
        protected $allowedFields=["id_user","place","time"];        
}
    

?>