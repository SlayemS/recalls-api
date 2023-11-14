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

        if(isset($filters['year'])){
            $sql .= "AND year LIKE CONCAT(:year, '%')";    
            $query_values[':year'] = $filters['year'];
        }
        if(isset($filters['vehicle_type'])){
            $sql .= "AND vehicle_type LIKE CONCAT('%', :vehicle_type, '%')";    
            $query_values[':vehicle_type'] = $filters['vehicle_type'];
        }
        if(isset($filters['fuel_type'])){
            $sql .= "AND fuel_type LIKE CONCAT('%', :fuel_type, '%')";    
            $query_values[':fuel_type'] = $filters['fuel_type'];
        }
        if(isset($filters['transmission_type'])){
            $sql .= "AND transmission_type LIKE CONCAT('%', :transmission_type, '%')";    
            $query_values[':transmission_type'] = $filters['transmission_type'];
        }
        if(isset($filters['engine'])){
            $sql .= "AND engine LIKE CONCAT(:engine, '%')";    
            $query_values[':engine'] = $filters['engine'];
        }
        if(isset($filters['power_type'])){
            $sql .= "AND power_type LIKE CONCAT('%', :power_type, '%')";    
            $query_values[':power_type'] = $filters['power_type'];
        }

        if(isset($filters['sort_by'])){
            if ($filters['sort_by'] == 'asc') {
                $sql .= "ORDER BY model_id ASC";    
            }
            else if ($filters['sort_by'] == 'desc') {
                $sql .= "ORDER BY model_id DESC";
            }
        }
        
        return $this->paginate($sql,$query_values);
    }

    // Need to fix db first
    public function getCarsByModelId(array $filters) {
        $query_values = [];
        $query_values[':model_id'] = $filters['model_id'];

        $sql = "SELECT * FROM `cars` WHERE model_id = :model_id";

        return $this->paginate($sql, $query_values);
    }

    public function getRecallsByModelId(array $filters) {
        $query_values = [];
        $query_values[':model_id'] = $filters['model_id'];

        $sql = "SELECT * FROM `recalls` WHERE model_id = :model_id";

        return $this->paginate($sql, $query_values);
    }

    public function createModel(array $newModel){
        $this->insert($this->table_name,$newModel);
    }

    public function deleteModel($model_id){
        $this->delete($this->table_name,$model_id);
    }

    public function updateModel($model_data,$where){
        $this->update($this->table_name,$model_data,$where);
    }
}
