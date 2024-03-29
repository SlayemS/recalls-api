<?php

namespace Vanier\Api\Models;

class RecallsModel extends BaseModel
{
    private string $table_name = 'recalls';
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * getAll
     * gets everything from the recalls table
     * @param  mixed $filters
     * @return void
     */
    public function getAll(array $filters)
    {
        
        $query_values = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1 ";

        if(isset($filters['subject'])){
            $sql .= "AND `subject` LIKE CONCAT('%', :subject, '%')";    
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
        // sort by model_id
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
    
    /**
     * getInstanceByRecallId
     * gets the instances of a recall_id
     * @param  mixed $filters
     * @return void
     */
    public function getInstanceByRecallId(array $filters)
    {
        $query_values = [];
        $query_values[':recall_id'] = $filters['recall_id'];

        $sql = "SELECT * FROM `instances` WHERE recall_id = :recall_id";

        return $this->paginate($sql, $query_values);
    }
    
    /**
     * createRecall
     * creates a recall in the database
     * @param  mixed $new_recall
     * @return void
     */
    public function createRecall(array $new_recall) {
        $this->insert($this->table_name, $new_recall);
    }
    
    /**
     * checkIfRecallExists
     * checks if a recall_id exists
     * @param  mixed $recall_id
     * @return void
     */
    public function checkIfRecallExists(int $recall_id) {
        $sql = "SELECT * FROM $this->table_name WHERE recall_id = :recall_id";

        return $this->fetchSingle($sql, [':recall_id' => $recall_id]);
    }
    
    /**
     * updateRecall
     * updates values of a recall in the database
     * @param  mixed $recall_id
     * @param  mixed $updated_recall
     * @return void
     */
    public function updateRecall(int $recall_id, array $updated_recall) {
        $this->update($this->table_name, $updated_recall, ['recall_id' => $recall_id]);
    }
}
