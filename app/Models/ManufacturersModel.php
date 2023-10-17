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

        if(isset($filters['manufacturer_name'])){
            $sql .= "AND manufacturer_name LIKE CONCAT('%', :manufacturer_name, '%')";    
            $query_values[':manufacturer_name'] = $filters['manufacturer_name'];
        }
        return $this->paginate($sql,$query_values);
    }

}
