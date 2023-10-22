<?php

namespace Vanier\Api\Models;

class CustomersModel extends BaseModel
{
    private string $table_name = 'customers
    ';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(array $filters)
    {
        
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";

        if(isset($filters['subject'])){
            $sql .= "AND subject LIKE CONCAT('%', :subject, '%')";    
            $query_values[':subject'] = $filters['subject'];
        }
        if(isset($filters['component'])){
            $sql .= "AND component LIKE CONCAT('%', :component, '%')";    
            $query_values[':component'] = $filters['component'];
        }
        return $this->paginate($sql,$query_values);
    }

}
