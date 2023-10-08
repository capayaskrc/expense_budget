<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `categories` where `category` = '{$category}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `categories` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Category successfully saved.");
			else
				$this->settings->set_flashdata('success',"Category successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `categories` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_balance($category_id){
		$budget = $this->conn->query("SELECT SUM(amount) as total FROM `running_balance` where `balance_type` = 1 and `category_id` = '{$category_id}' ")->fetch_assoc()['total'];
		$expense = $this->conn->query("SELECT SUM(amount) as total FROM `running_balance` where `balance_type` = 2 and `category_id` = '{$category_id}' ")->fetch_assoc()['total'];
		$balance = $budget - $expense;
		$update  = $this->conn->query("UPDATE `categories` set `balance` = '{$balance}' where `id` = '{$category_id}' ");
		if($update){
			return true;
		}else{
			return $this->conn;
		}
	}
	function save_budget(){
		extract($_POST);
		$_POST['amount'] = str_replace(',','',$_POST['amount']);
		$_POST['remarks'] = addslashes(htmlentities($_POST['remarks']));
		$data = "";
		foreach($_POST as $k =>$v){
			if($k == 'id')
				continue;
			if(!empty($data)) $data .=",";
			$data .= " `{$k}`='{$v}' ";
		}
		if(!empty($data)) $data .=",";
			$data .= " `user_id`='{$this->settings->userdata('id')}' ";
		if(empty($id)){
			$sql = "INSERT INTO `running_balance` set $data";
		}else{
			$sql = "UPDATE `running_balance` set $data WHERE id ='{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$update_balance =$this->update_balance($_POST['category_id']);
			
			if($update_balance == 1){
				$resp['status'] ='success';
				$this->settings->set_flashdata('success'," Budget successfully saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = $update_balance;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn;
		}
		return json_encode($resp);
	}

	function delete_budget(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `running_balance` where id = '{$id}'");
		if($del){
			$update_balance =$this->update_balance($category_id);
			if($update_balance == 1){
				$resp['status'] ='success';
				$this->settings->set_flashdata('success',"Budget successfully deleted.");
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = $update_balance;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
    function save_expense()
    {
        extract($_POST);
        $_POST['amount'] = str_replace(',', '', $_POST['amount']);
        $_POST['remarks'] = addslashes(htmlentities($_POST['remarks']));
        $_POST['expense_title'] = addslashes(htmlentities($_POST['expense_title']));

        $data = array(); // Create an array to store column-value pairs

        // Add the expense_title to the data array
        $data['expense_title'] = $_POST['expense_title'];

        // Loop through other POST data and add to the data array
        foreach ($_POST as $k => $v) {
            if ($k == 'id' || $k == 'expense_title') {
                continue;
            }
            $data[$k] = $v;
        }

        // Include user_id in the data array
        $data['user_id'] = $this->settings->userdata('id');

        if (empty($id)) {
            // Check if an expense with the same title exists for the current user
            $existingExpense = $this->conn->query("SELECT * FROM `running_balance` WHERE `expense_title` = '{$data['expense_title']}' AND `user_id` = '{$data['user_id']}' LIMIT 1");
            if ($existingExpense->num_rows > 0) {
                // An expense with the same title exists, update it instead of inserting a new one
                $row = $existingExpense->fetch_assoc();
                $id = $row['id'];
            }
        }

        if (empty($id)) {
            // Construct the SQL query using the data array for a new record
            $sql = "INSERT INTO `running_balance` SET ";
            foreach ($data as $key => $value) {
                $sql .= "`$key`='$value', ";
            }
            $sql = rtrim($sql, ', '); // Remove the trailing comma and space
        } else {
            // Construct the SQL query for an update
            $sql = "UPDATE `running_balance` SET ";
            foreach ($data as $key => $value) {
                $sql .= "`$key`='$value', ";
            }
            $sql = rtrim($sql, ', '); // Remove the trailing comma and space
            $sql .= " WHERE id ='{$id}'";
        }

        $save = $this->conn->query($sql);
        if ($save) {
            $update_balance = $this->update_balance($_POST['category_id']);

            if ($update_balance == 1) {
                $resp['status'] = 'success';
                $this->settings->set_flashdata('success', "Expense successfully saved.");
            } else {
                $resp['status'] = 'failed';
                $resp['error'] = $update_balance;
            }
        } else {
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }


    function delete_expense() {
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `running_balance` WHERE id = '{$id}'");

        if ($del) {
            // Check if this is the last record with the same category_id
            $expenseCount = $this->conn->query("SELECT COUNT(*) as count FROM `running_balance` WHERE `category_id` = '{$category_id}'");

            if ($expenseCount->num_rows > 0) {
                $countRow = $expenseCount->fetch_assoc();
                $count = (int) $countRow['count'];

                if ($count === 0) {
                    // Update the expense based on the category_id if it's the last record with the same category_id
                    $update_balance = $this->update_balance($category_id);

                    if ($update_balance != 1) {
                        $resp['status'] = 'failed';
                        $resp['error'] = $update_balance;
                        return json_encode($resp);
                    }
                }
            }

            $resp['status'] = 'success';
            $this->settings->set_flashdata('success', "Expense successfully deleted.");
        } else {
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }

        return json_encode($resp);
    }
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_budget':
		echo $Master->save_budget();
	break;
	case 'delete_budget':
		echo $Master->delete_budget();
	break;
	case 'save_expense':
		echo $Master->save_expense();
	break;
	case 'delete_expense':
		echo $Master->delete_expense();
	break;
	default:
		// echo $sysset->index();
		break;
}