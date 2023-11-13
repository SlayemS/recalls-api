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

        if(isset($filters['country'])){
            $sql .= "AND country LIKE CONCAT('%', :country, '%')";    
            $query_values[':country'] = $filters['country'];
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

    public function getModelsByManufacturerId(array $filters) {
        $query_values = [];
        $query_values[':manufacturer_id'] = $filters['manufacturer_id'];

        $sql = "SELECT * FROM `models` WHERE manufacturer_id = :manufacturer_id";

        return $this->paginate($sql, $query_values);
    }

    public function createManufacturer(array $newManufacturer){
        $this->insert($this->table_name,$newManufacturer);
    }

    public function updateManufacturer(array $data, $where){
        $this->update($this->table_name,$data, $where);
    }

    public function deleteManufacturer($manufacturer_id){
        $this->delete($this->table_name,$manufacturer_id);
    }
}
