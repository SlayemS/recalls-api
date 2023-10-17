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

        if(isset($filters['name'])){
            $sql .= "AND manufacturer_name LIKE CONCAT('%', :name, '%')";    
            $query_values[':name'] = $filters['name'];
        }
        if(isset($filters['city'])){
            $sql .= "AND city LIKE CONCAT('%', :city, '%')";    
            $query_values[':city'] = $filters['city'];
        }
        if(isset($filters['year'])){
            $sql .= "AND founded_year LIKE CONCAT(:year, '%')";    
            $query_values[':year'] = $filters['year'];
        }
        return $this->paginate($sql,$query_values);
    }

}
