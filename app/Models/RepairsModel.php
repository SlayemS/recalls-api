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

        // filters for repairs
        if(isset($filters['make'])){
            $sql .= "AND make LIKE CONCAT('%', :make, '%')";    
            $query_values[':make'] = $filters['make'];
        }


        return $this->paginate($sql,$query_values);
    }
}
