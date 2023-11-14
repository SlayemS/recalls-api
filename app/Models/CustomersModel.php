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
        if(isset($filters['customer_id'])){
            $sql .= "AND customer_id LIKE CONCAT('%', :customer_id, '%')";    
            $query_values[':customer_id'] = $filters['customer_id'];
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
    
    public function checkIfCustomerExists(int $customer_id) {
        $sql = "SELECT * FROM $this->table_name WHERE customer_id = :customer_id";

        return $this->fetchSingle($sql, [':customer_id' => $customer_id]);
    }

    public function deleteCustomer(int $customer_id) {
        $this->delete($this->table_name, ['customer_id' => $customer_id]);
    }

}
