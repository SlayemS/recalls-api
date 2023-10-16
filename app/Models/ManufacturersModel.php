<?php

namespace Vanier\Api\Models;

class ManufacturersModel extends BaseModel
{
    private string $table_name = 'manufacturers';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(array $filters)
    {
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";
        if(isset($filters['title'])){
            $sql .= "AND title LIKE CONCAT('%', :title, '%')";    
            $query_values[':title'] = $filters['title'];
        }
        if(isset($filters['descr'])){
            $sql .= "AND description LIKE CONCAT('%', :descr, '%')";    
            $query_values[':descr'] = $filters['descr'];
        }
        //Doesn't work ↓
        if(isset($filters['special_features'])){
            $sql .= "AND 'special_features' LIKE CONCAT('%', :special_features, '%')";    
            $query_values[':special_features'] = $filters['special_features'];
        }
        if(isset($filters['rating'])){
            $sql .= "AND rating LIKE CONCAT('%',:rating, '%')";    
            $query_values[':rating'] = $filters['rating'];
        }
        return $this->paginate($sql,$query_values);
    }

}
