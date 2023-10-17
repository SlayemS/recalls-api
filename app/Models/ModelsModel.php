<?php

namespace Vanier\Api\Models;

class ModelsModel extends BaseModel
{
    private string $table_name = 'models';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(array $filters)
    {
        
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";

        if(isset($filters['vehicle_type'])){
            $sql .= "AND vehicle_type LIKE CONCAT('%', :vehicle_type, '%')";    
            $query_values[':vehicle_type'] = $filters['vehicle_type'];
        }
        if(isset($filters['year'])){
            $sql .= "AND year LIKE CONCAT(:year, '%')";    
            $query_values[':year'] = $filters['year'];
        }
        return $this->paginate($sql,$query_values);
    }
}
