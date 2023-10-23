<?php

namespace Vanier\Api\Models;

class RepairsModel extends BaseModel
{
    private string $table_name = 'repairs';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(array $filters)
    {
        
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";

        if (isset($filters['status'])) {
            $sql .= " AND `status` LIKE CONCAT('%', :`status`, '%') ";
            $query_values[':status'] = $filters['status'];
        }
        if (isset($filters['max_cost'])) {
            $sql .= " AND cost < :max_cost ";
            $query_values[':max_cost'] = $filters['max_cost'];
        }
        if (isset($filters['min_cost'])) {
            $sql .= " AND cost > :min_cost ";
            $query_values[':min_cost'] = $filters['min_cost'];
        }

        return $this->paginate($sql,$query_values);
    }
}
