<?php

namespace Vanier\Api\Models;

class CustomersModel extends BaseModel
{
    private string $table_name = 'customers';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(array $filters)
    {
        
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";

        if(isset($filters['first_name'])){
            $sql .= "AND first_name LIKE CONCAT('%', :first_name, '%')";    
            $query_values[':first_name'] = $filters['first_name'];
        }
        if(isset($filters['last_name'])){
            $sql .= "AND last_name LIKE CONCAT('%', :last_name, '%')";    
            $query_values[':last_name'] = $filters['last_name'];
        }
        return $this->paginate($sql,$query_values);
    }

    public function getCarByCustomerId(array $filters)
    {
        $query_values = [];
        $query_values[':customer_id'] = $filters['customer_id'];

        $sql = "SELECT * FROM `cars` WHERE customer_id = :customer_id";

        return $this->paginate($sql, $query_values);
    }

}
