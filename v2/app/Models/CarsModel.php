<?php

namespace Vanier\Api\Models;
use Vanier\Api\Models\BaseModel;

class CarsModel extends BaseModel
{
    private string $table_name = 'cars';

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * getAll
     * gets all the car models from the db 
     * and applies filters if entered
     * @param  mixed $filters
     * @return void
     */
    public function getAll(array $filters) {
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
     * getInstanceByCarId
     * gets the instances by the provided car_id
     * @param  mixed $filters
     * @return void
     */
    public function getInstanceByCarId(array $filters) {
        $query_values = [];
        $query_values[':car_id'] = $filters['car_id'];

        $sql = "SELECT * FROM `instances` WHERE car_id = :car_id";

        return $this->paginate($sql, $query_values);
    }
    
    /**
     * createCar
     * creates a car in the database
     * @param  mixed $new_car
     * @return void
     */
    public function createCar(array $new_car) {
        $this->insert($this->table_name, $new_car);
    }
    
    /**
     * checkIfCarExists
     * checks whether a car exits from the provided car_id
     * @param  mixed $car_id
     * @return void
     */
    public function checkIfCarExists(int $car_id) {
        $sql = "SELECT * FROM $this->table_name WHERE car_id = :car_id";

        return $this->fetchSingle($sql, [':car_id' => $car_id]);
    }
    
    /**
     * updateCar
     * updates values of a car with the provided car_id
     * and new values in the cars table
     * @param  mixed $car_id
     * @param  mixed $updated_car
     * @return void
     */
    public function updateCar(int $car_id, array $updated_car) {
        $this->update($this->table_name, $updated_car, ['car_id' => $car_id]);
    }
    
    /**
     * deleteCar
     * deletes a car from the database with the provided car_id
     * @param  mixed $car_id
     * @return void
     */
    public function deleteCar($car_id){
        $this->delete($this->table_name, $car_id);
    }
}
