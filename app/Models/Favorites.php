<?php  
    namespace App\Models;
    use CodeIgniter\Model;

    class Favorites extends Model{
        protected $table="favorites";
        protected $primaryKey="id";
        protected $allowedFields=["id_user","type","name","path","id_artist","id_file"];
        // protected $validationRules=[
        //     "id_file"=>"is_unique[favorites.id_file]"
        // ];
        // protected $validationMessages=[
        //     "id_file"=>[
        //         "is_unique"=>"ALREADY ADDED TO FAVORITES"
        //     ]
        // ];
}
    

?>