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
            $sql .= " AND `status` LIKE CONCAT('%', :status, '%') ";
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

    public function createRepair(array $new_repair) {
        $this->insert($this->table_name, $new_repair);
    }

    public function checkIfRepairExists(int $repair_id) {
        $sql = "SELECT * FROM $this->table_name WHERE repair_id = :repair_id";

        return $this->fetchSingle($sql, [':repair_id' => $repair_id]);
    }

    public function updateRepair(int $repair_id, array $updated_repair) {
        $this->update($this->table_name, $updated_repair, ['repair_id' => $repair_id]);
    }
    
    public function deleteRepair($repair_id){
        $this->delete($this->table_name, $repair_id);
    }
}
