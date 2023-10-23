<?php

namespace Vanier\Api\Models;

class RecallsModel extends BaseModel
{
    private string $table_name = 'recalls';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(array $filters)
    {
        
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";

        if(isset($filters['subject'])){
            $sql .= "AND subject LIKE CONCAT('%', :subject, '%')";    
            $query_values[':subject'] = $filters['subject'];
        }
        if(isset($filters['issue_date'])){
            $sql .= "AND issue_date LIKE CONCAT('%', :issue_date, '%')";    
            $query_values[':issue_date'] = $filters['issue_date'];
        }
        if(isset($filters['component'])){
            $sql .= "AND component LIKE CONCAT('%', :component, '%')";    
            $query_values[':component'] = $filters['component'];
        }
        return $this->paginate($sql,$query_values);
    }

    public function getInstanceByRecallId(array $filters)
    {
        $query_values = [];
        $query_values[':recall_id'] = $filters['recall_id'];

        $sql = "SELECT * FROM `instances` WHERE recall_id = :recall_id";

        return $this->paginate($sql, $query_values);
    }

}
