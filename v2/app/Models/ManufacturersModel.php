<?php

namespace Vanier\Api\Models;

class ManufacturersModel extends BaseModel
{
    private string $table_name = 'manufacturers';
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * getAll
     * gets everything from the manufacturers table
     * and applies filters if entered
     * @param  mixed $filters
     * @return void
     */
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

        if(isset($filters['sort_by'])){
            if ($filters['sort_by'] == 'asc') {
                $sql .= "ORDER BY manufacturer_id ASC";    
            }
            else if ($filters['sort_by'] == 'desc') {
                $sql .= "ORDER BY manufacturer_id DESC";
            }
        }
        return $this->paginate($sql,$query_values);
    }
    
    /**
     * getModelsByManufacturerId
     * get the models by the provided manufacturer_id
     * @param  mixed $filters
     * @return void
     */
    public function getModelsByManufacturerId(array $filters) {
        $query_values = [];
        $query_values[':manufacturer_id'] = $filters['manufacturer_id'];

        $sql = "SELECT * FROM `models` WHERE manufacturer_id = :manufacturer_id";

        return $this->paginate($sql, $query_values);
    }
    
    /**
     * createManufacturer
     * creates a manufacturer in the database
     * @param  mixed $newManufacturer
     * @return void
     */
    public function createManufacturer(array $newManufacturer){
        $this->insert($this->table_name,$newManufacturer);
    }
    
    /**
     * ifManufacturerExists
     * checks if a manufacturer exists with the provided manufacturer_id
     * @param  mixed $manufacturer_id
     * @return void
     */
    public function ifManufacturerExists(int $manufacturer_id) {
        $sql = "SELECT * FROM $this->table_name WHERE manufacturer_id = :manufacturer_id";

        return $this->fetchSingle($sql, [':manufacturer_id' => $manufacturer_id]);
    }
    
    /**
     * updateManufacturer
     * updates values of a manufacturer based on manufacturer_id
     * and the data provided
     * @param  mixed $data
     * @param  mixed $manufacturer_id
     * @return void
     */
    public function updateManufacturer(array $data, int $manufacturer_id){
        $this->update($this->table_name,$data, ['manufacturer_id' => $manufacturer_id]);
    }
    
    /**
     * deleteManufacturer
     * deletes a manufacturer from the database based on the manufacturer_id
     * @param  mixed $manufacturer_id
     * @return void
     */
    public function deleteManufacturer(int $manufacturer_id){
        $this->delete($this->table_name,['manufacturer_id'=>$manufacturer_id]);
    }
}
