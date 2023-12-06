<?php

namespace Vanier\Api\Models;
use Vanier\Api\Models\BaseModel;

/**
 * CompositesModel
 * 
 * Model for the composites table
 */
class CompositesModel extends BaseModel
{
    private string $table_name = 'composites';

    public function __construct() {
        parent::__construct();
    }

    /**
     * getManufacturerDetails
     * get everything from manufacturerDetails of the composite resource
     * @param  mixed $filters
     * @return void
     */
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

    /**
     * Get the emissions of a car model
     * 
     * @param array $filters
     * @return array
     */
    public function getEmissions(array $filters) {
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
