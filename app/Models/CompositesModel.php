<?php

namespace Vanier\Api\Models;
use Vanier\Api\Models\BaseModel;

class CompositesModel extends BaseModel
{
    private string $table_name = 'composites';

    public function __construct() {
        parent::__construct();
    }

    public function getManufacturerDetails(array $filters) {
        $query_values = [];

        $sql = "SELECT * FROM $this->table_name WHERE 1 ";
        if (isset($filters['dealership'])) {
            $sql .= " AND dealership LIKE CONCAT('%', :dealership, '%') ";
            $query_values[':dealership'] = $filters['dealership'];
        }
        if (isset($filters['color'])) {
            $sql .= " AND color LIKE CONCAT('%', :color, '%') ";
            $query_values[':color'] = $filters['color'];
        }
        if (isset($filters['max_mileage'])) {
            $sql .= " AND mileage < :max_mileage ";
            $query_values[':max_mileage'] = $filters['max_mileage'];
        }
        if (isset($filters['min_mileage'])) {
            $sql .= " AND mileage > :min_mileage ";
            $query_values[':min_mileage'] = $filters['min_mileage'];
        }
        if(isset($filters['customer_id'])){
            $sql .= "AND customer_id LIKE CONCAT('%', :customer_id, '%')";    
            $query_values[':customer_id'] = $filters['customer_id'];
        }
        return $this->paginate($sql, $query_values);
    }

}
