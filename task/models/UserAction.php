<?php

require_once "UserDB.php";
require_once __DIR__ . "/../settings.php";

class UserAction {

    protected $db;
    protected $min_lvl = MIN_ACC_LVL;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->sess = $sess;
    }

	private function unserializesession($data) {
		$vars = preg_split('/([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff^|]*)\|/',$data,-1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		for( $i=0; $vars[$i]; $i++ ) $result[$vars[$i++]] = unserialize($vars[$i]);
		return $result;
	}


    private function read($row) {
        $result = new User();
        $result->id = $row["id"];
        $result->name = $row["name"];
        $result->email = $row["email"];
        $result->task = $row["task"];
        $result->done = $row["done"] == 1 ? true : false;
        return $result;
    }

    private function lvl($sid=0) {
		$lvl = 1;
		$file = session_save_path() . 'sess_' . $sid;
		if(file_exists($file)) 
		{
			$sess = $this->unserializesession(file_get_contents($file));
			$lvl = $sess['lvl'];
		}
        return $lvl;
    }

    public function getById($id) {
        $q = $this->db->prepare("SELECT * FROM tasks WHERE id = :id");
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $q = $this->db->prepare("SELECT * FROM tasks");
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $q = $this->db->prepare("INSERT INTO tasks (name, email, task) VALUES (:name, :email, :task)");
        $q->bindParam(":name", $data["name"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":task", $data["task"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data,$sid) {
		if( $this->lvl($sid) >= MIN_ACC_LVL )
		{
			if($data)
			{				
				$q = $this->db->prepare("UPDATE tasks SET name = :name, email = :email, task = :task, done = :done WHERE id = :id");
				$q->bindParam(":name", $data["name"]);
				$q->bindParam(":email", $data["email"]);
				$q->bindParam(":task", $data["task"]);
				$q->bindParam(":done", $data["done"]);
				$q->bindParam(":id", $data["id"], PDO::PARAM_INT);
				$q->execute();
			}
			return true;
		} else return false;
    }

    public function remove($id,$sid) {
		if( $this->lvl($sid) >= MIN_ACC_LVL )
		{
			if($id)
			{	
				$q = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
				$q->bindParam(":id", $id, PDO::PARAM_INT);
				$q->execute();
			}
			return true;
		} else return false;
    }

}

?>