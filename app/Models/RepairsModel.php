<?php

namespace Vanier\Api\Models;

class RepairsModel extends BaseModel
{
    private string $table_name = 'repairs';
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
        
        // create filters for repairs table
        if(isset($filters['make'])){
            $sql .= "AND make LIKE CONCAT('%', :make, '%')";    
            $query_values[':make'] = $filters['make'];
        }


        return $this->paginate($sql,$query_values);
    }
}
