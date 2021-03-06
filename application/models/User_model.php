<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if($this->session->userdata('roleText')=='Admin'){
        }else{
            $this->db->where('BaseTbl.createdBy', $this->session->userdata('userId'));
        }
        //$this->db->where('BaseTbl.createdBy', $this->session->userdata('userId'));
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.email_address,BaseTbl.userId, BaseTbl.c_address,BaseTbl.c_pincode,BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role, BaseTbl.user_flag, BaseTbl.status');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        if($this->session->userdata('roleText')=='Admin'){

        }else{
            $this->db->where('BaseTbl.createdBy', $this->session->userdata('userId'));
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('isDeleted',0);
        $this->db->where('role_type','system');
        $query = $this->db->get();
        
        return $query->result();
    }

    function getUserRolesForcompany()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('isDeleted',0);
        $this->db->where('role_type','company');

        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('email_address,password, userId, name, email, mobile, roleId,c_vendorId, c_address, c_gst_number, c_pincode, c_country,c_district, c_city, c_state, adhar_no,pan_no,comp_bank_name, comp_bank_branch, comp_ifsc_code, comp_ac_number, status, password');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if($oldPassword==$user[0]->password){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get user log history count
     * @param number $userId : This is user id
     */
    	
    function logHistoryCount($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');

        if ($userId == NULL)
        {
            $query = $this->db->get();
            return $query->num_rows();
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $query = $this->db->get();
            return $query->num_rows();
        }
    }

    /**
     * This function is used to get user log history
     * @param number $userId : This is user id
     * @return array $result : This is result
     */
    function logHistory($userId)
    {
        $this->db->select('*');        
        $this->db->from('tbl_log as BaseTbl');

        if ($userId == NULL)
        {
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function is used to get tasks
     */
    function getTasks()
    {
        $this->db->select('*');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.statusId ASC, TaskTbl.priorityId');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get task prioritys
     */
    function getTasksPrioritys()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_prioritys');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get task situations
     */
    function getTasksSituations()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_situations');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to add a new task
     */
    function addNewTasks($taskInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_task', $taskInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function used to get task information by id
     * @param number $taskId : This is task id
     * @return array $result : This is task information
     */
    function getTaskInfo($taskId)
    {
        $this->db->select('*');
        $this->db->from('tbl_task');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = tbl_task.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = tbl_task.priorityId');
        $this->db->where('id', $taskId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to edit tasks
     */
    function editTask($taskInfo, $taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $taskInfo);
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to delete tasks
     */
    function deleteTask($taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->delete('tbl_task');
        return TRUE;
    }

    /**
     * This function is used to return the size of the table
     * @param string $tablename : This is table name
     * @param string $dbname : This is database name
     * @return array $return : Table size in mb
     */
    function gettablemb($tablename,$dbname)
    {
        $this->db->select('round(((data_length + index_length)/1024/1024),2) as total_size');
        $this->db->from('information_schema.tables');
        $this->db->where('table_name', $tablename);
        $this->db->where('table_schema', $dbname);
        $query = $this->db->get($tablename);
        
        return $query->row();
    }

    /**
     * This function is used to delete tbl_log table records
     */
    function clearlogtbl()
    {
        $this->db->truncate('tbl_log');
        return TRUE;
    }

    /**
     * This function is used to delete tbl_log_backup table records
     */
    function clearlogBackuptbl()
    {
        $this->db->truncate('tbl_log_backup');
        return TRUE;
    }

    /**
     * This function is used to get user log history
     * @return array $result : This is result
     */
    function logHistoryBackup()
    {
        $this->db->select('*');        
        $this->db->from('tbl_log_backup as BaseTbl');
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to complete tasks
     */
    function endTask($taskId, $taskInfo)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $taskInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function tasksCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the finished tasks count
     * @return array $result : This is result
     */
    function finishedTasksCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        $this->db->where('BaseTbl.statusId', 2);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the logs count
     * @return array $result : This is result
     */
    function logsCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the users count
     * @return array $result : This is result
     */
    function usersCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $this->db->where('BaseTbl.user_flag', 'user');
        $this->db->where('BaseTbl.createdBy', $this->session->userdata('userId'));
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getUserStatus($userId)
    {
        $this->db->select('BaseTbl.status');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->limit(1);
        $query = $this->db->get('tbl_users as BaseTbl');

        return $query->row();
    }

    // ======= GET VENDOR LIST FOR COMPANY =======
    function getVendor()
    {
        $this->db->select('vendorId, vendor_name');
        $this->db->from('tbl_vendor');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // ======= VENDOR LIST =========
    function vendorListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.vendorId, BaseTbl.email1,BaseTbl.email2, BaseTbl.vendor_name, BaseTbl.contact_no, BaseTbl.vm_GST,BaseTbl.contact_person,BaseTbl.tel_no');
        $this->db->from('tbl_vendor as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email1  LIKE '%".$searchText."%'
                            OR  BaseTbl.vendor_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.contact_no  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function vendorListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.vendorId, BaseTbl.email1, BaseTbl.vendor_name, BaseTbl.contact_no,BaseTbl.contact_person,BaseTbl.tel_no');
        $this->db->from('tbl_vendor as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email1  LIKE '%".$searchText."%'
                            OR  BaseTbl.vendor_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.contact_no  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    // ======= INSERT VENDOR ========

    function addNewVendor($vendorInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_vendor', $vendorInfo);    
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    // ==== DELETE VENDOR ==========
    
    function deleteVendor($vendorId, $vendorInfo)
    {
        $this->db->where('vendorId', $vendorId);
        $this->db->update('tbl_vendor', $vendorInfo);
        
        return $this->db->affected_rows();
    }

    // === GET VENDOR DATA FOR EDIT ===
    function getVendorInfo($vendorId)
    {
        $this->db->select('vendorId, vendor_name, contact_person, email1, email2, contact_no, tel_no, vm_pan_no, vm_GST, vm_TDS, gumasta_no, notes, bank_name, bank_branch, ifsc_code, account_no,vendor_picture');
        $this->db->from('tbl_vendor');
        $this->db->where('isDeleted', 0);
        $this->db->where('vendorId', $vendorId);
        $query = $this->db->get();
        
        return $query->result();
    }

    // =======

    function editVendor($vendorInfo, $vendorId)
    {
        $this->db->where('vendorId', $vendorId);
        $this->db->update('tbl_vendor', $vendorInfo);
        
        return TRUE;
    }
    // ========
    function vendorCheck()
    {
        $key = $this->input->post('email1');
        $this->db->select('BaseTbl.vendorId, BaseTbl.email1');
        $this->db->from('tbl_vendor as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.email1',$key);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    // ========
    function companyCheck()
    {
        $key = $this->input->post('comp_name');
        $this->db->select('BaseTbl.userId, BaseTbl.name');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.name',$key);
        $this->db->where('BaseTbl.user_flag', 'comp_user');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    // ========================

     /**
     * This function is used to get the all orders Count
     * @return array $result : This is result
     */
    function ordersCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_orders as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

     /**
     * This function is used to get the all orders Count
     * @return array $result : This is result
     */
    function warehouseCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_warehouse as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }


    function getClientInfo($userId)
    {
        $this->db->select('userId,name');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getDocumentInfo($userId)
    {
        $this->db->select('BaseTbl.doc_id, BaseTbl.client_id, BaseTbl.attachment_name, BaseTbl.document');
        $this->db->from('tbl_document as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('client_id', $userId);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function deleteDocument($docId, $docInfo)
    {
        $this->db->where('doc_id', $docId);
        $this->db->update('tbl_document', $docInfo);
        return $this->db->affected_rows();
    }

}

  