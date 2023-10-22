<?php

namespace Vanier\Api\Models;
use Vanier\Api\Models\BaseModel;

class InstancesModel extends BaseModel
{
    private string $table_name = 'instances';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $filters) {
        $query_values = [];

        $sql = "SELECT * FROM $this->table_name WHERE 1 ";
        if (isset($filters['job_done'])) {
            $job_state = ($filters['job_done'] == 'true') ? '1' : '0';
            $sql .= " AND job_done LIKE CONCAT('%', :job_state, '%') ";

            $query_values[':job_state'] = $job_state;
        }
        return $this->paginate($sql, $query_values );
    }

    public function getRepairsByInstanceId(array $filters) {
        $query_values = [];
        $query_values[':instance_id'] = $filters['instance_id'];

        $sql = "SELECT * FROM `repairs` WHERE instance_id = :instance_id";

        return $this->paginate($sql, $query_values);
    }
}
