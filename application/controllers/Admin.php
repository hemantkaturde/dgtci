<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('comman_model');
        $this->load->config('additional');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        else
        {
            // isAdmin / Admin role control function / This function used admin role control
            // if($this->isAdmin() == TRUE)
            // {
            //     $this->accesslogincontrol();
            // }
        }
    }
	
     /**
     * This function is used to load the user list
     */
    function userListing()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $process = 'User Listeleme';
            $processFunction = 'Admin/userListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : User List';
            
            $this->loadViews("users", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
            $data['roles'] = $this->user_model->getUserRoles();

            $this->global['pageTitle'] = 'ADMIN : ADD USER';

            $this->loadViews("addNew", $this->global, $data, NULL);
    }


    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('user_name','user_name','trim|required|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $user_name = $this->input->post('user_name');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array('email'=>$user_name,'email_address'=>$email ,'password'=>$password, 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'), 'user_flag' => "user",);
                                    
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $process = 'User Ekleme';
                    $processFunction = 'Admin/addNewUser';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'User başarıyla oluşturuldu');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User oluşturma başarısız');
                }
                
                redirect('userListing');
            }
       }

     /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    
     function editOld($userId = NULL)
    {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $this->global['pageTitle'] = 'ADMIN : User Edit';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
    }


    /**
     * This function is used to edit the user informations
     */
    function editUser()
    {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('user_name','user_name','trim|required|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $user_name = $this->input->post('user_name');
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$user_name,'email_address'=>$email,'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'status'=>0, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$user_name,'email_address'=>$email,'password'=>$password, 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>0, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $process = 'User Update';
                    $processFunction = 'Admin/editUser';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'User başarıyla güncellendi');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User Update başarısız');
                }
                
                redirect('userListing');
            }
    }

     /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'User Silme';
                 $processFunction = 'Admin/deleteUser';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
    }

     /**
     * This function used to show log history
     * @param number $userId : This is user id
     */
    function logHistory($userId = NULL)
    {
            $data['dbinfo'] = $this->user_model->gettablemb('tbl_log','cias');
            if(isset($data['dbinfo']->total_size))
            {
                if(($data['dbinfo']->total_size)>1000){
                    $this->backupLogTable();
                }
            }
            $data['userRecords'] = $this->user_model->logHistory($userId);

            $process = 'Log Görüntüleme';
            $processFunction = 'Admin/logHistory';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : User Giriş Geçmişi';
            
            $this->loadViews("logHistory", $this->global, $data, NULL);
    }

    /**
     * This function used to show specific user log history
     * @param number $userId : This is user id
     */
    function logHistorysingle($userId = NULL)
    {       
            $userId = ($userId == NULL ? $this->session->userdata("userId") : $userId);
            $data["userInfo"] = $this->user_model->getUserInfoById($userId);
            $data['userRecords'] = $this->user_model->logHistory($userId);
            
            $process = 'Tekil Log Görüntüleme';
            $processFunction = 'Admin/logHistorysingle';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : User Giriş Geçmişi';
            
            $this->loadViews("logHistorysingle", $this->global, $data, NULL);      
    }
    
    /**
     * This function used to backup and delete log table
     */
    function backupLogTable()
    {
        $this->load->dbutil();
        $prefs = array(
            'tables'=>array('tbl_log')
        );
        $backup=$this->dbutil->backup($prefs) ;

        date_default_timezone_set('Europe/Istanbul');
        $date = date('d-m-Y H-i');

        $filename = './backup/'.$date.'.sql.gz';
        $this->load->helper('file');
        write_file($filename,$backup);

        $this->user_model->clearlogtbl();

        if($backup)
        {
            $this->session->set_flashdata('success', 'Backup and Table cleanup successful');
            redirect('log-history');
        }
        else
        {
            $this->session->set_flashdata('error', 'Yedekleme ve Tablo temizleme işlemi başarısız');
            redirect('log-history');
        }
    }

    /**
     * This function used to open the logHistoryBackup page
     */
    function logHistoryBackup()
    {
            $data['dbinfo'] = $this->user_model->gettablemb('tbl_log_backup','cias');
            if(isset($data['dbinfo']->total_size))
            {
            if(($data['dbinfo']->total_size)>1000){
                $this->backupLogTable();
            }
            }
            $data['userRecords'] = $this->user_model->logHistoryBackup();

            $process = 'Yedek Log Görüntüleme';
            $processFunction = 'Admin/logHistoryBackup';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : User Yedek Giriş Geçmişi';
            
            $this->loadViews("logHistoryBackup", $this->global, $data, NULL);
    }

    /**
     * This function used to delete backup_log table
     */
    function backupLogTableDelete()
    {
        $backup=$this->user_model->clearlogBackuptbl();

        if($backup)
        {
            $this->session->set_flashdata('success', 'Tablo temizleme işlemi başarılı');
            redirect('log-history-backup');
        }
        else
        {
            $this->session->set_flashdata('error', 'Tablo temizleme işlemi başarısız');
            redirect('log-history-backup');
        }
    }

    /**
     * This function used to open the logHistoryUpload page
     */
    function logHistoryUpload()
    {       
            $this->load->helper('directory');
            $map = directory_map('./backup/', FALSE, TRUE);
        
            $data['backups']=$map;

            $process = 'Upload Backup Logme';
            $processFunction = 'Admin/logHistoryUpload';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : User Log Yükleme';
            
            $this->loadViews("logHistoryUpload", $this->global, $data, NULL);      
    }

    /**
     * This function used to upload backup for backup_log table
     */
    function logHistoryUploadFile()
    {
        $optioninput = $this->input->post('optionfilebackup');

        if ($optioninput == '0' && $_FILES['filebackup']['name'] != '')
        {
            $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "gz|sql|gzip",
            'overwrite' => TRUE,
            'max_size' => "20048000", // Can be set to particular file size , here it is 20 MB(20048 Kb)
            );

            $this->load->library('upload', $config);
            $upload= $this->upload->do_upload('filebackup');
                $data = $this->upload->data();
                $filepath = $data['full_path'];
                $path_parts = pathinfo($filepath);
                $filetype = $path_parts['extension'];
                if ($filetype == 'gz')
                {
                    // Read entire gz file
                    $lines = gzfile($filepath);
                    $lines = str_replace('tbl_log','tbl_log_backup', $lines);
                }
                else
                {
                    // Read in entire file
                    $lines = file($filepath);
                    $lines = str_replace('tbl_log','tbl_log_backup', $lines);
                }
        }

        else if ($optioninput != '0' && $_FILES['filebackup']['name'] == '')
        {
            $filepath = './backup/'.$optioninput;
            $path_parts = pathinfo($filepath);
            $filetype = $path_parts['extension'];
            if ($filetype == 'gz')
            {
                // Read entire gz file
                $lines = gzfile($filepath);
                $lines = str_replace('tbl_log','tbl_log_backup', $lines);
            }
            else
            {
                // Read in entire file
                $lines = file($filepath);
                $lines = str_replace('tbl_log','tbl_log_backup', $lines);
            }
        }
                // Set line to collect lines that wrap
                $templine = '';
                
                // Loop through each line
                foreach ($lines as $line)
                {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '')
                    continue;
                    // Add this line to the current templine we are creating
                    $templine .= $line;

                    // If it has a semicolon at the end, it's the end of the query so can process this templine
                    if (substr(trim($line), -1, 1) == ';')
                    {
                        // Perform the query
                        $this->db->query($templine);

                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
            if (empty($lines) || !isset($lines))
            {
                $this->session->set_flashdata('error', 'Backup installation failed');
                redirect('log-history-upload');
            }
            else
            {
                $this->session->set_flashdata('success', 'Backup installation successful');
                redirect('log-history-upload');
            }
    }

    
    /** ===== COMPANY DETAILS START ======= **/
    /* COMPANY LIST VIEW  */
    function companyListing()
        {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress ( "companyListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $process = 'Company Listing';
            $processFunction = 'Admin/companyListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Client List';
            
            $this->loadViews("company/viewCompany", $this->global, $data, NULL);
        }
    
     /**
     * ADD NEW COMPANY MASTER
     */
    function addCompany()
    {
        $data['roles'] = $this->user_model->getUserRolesForcompany();
        $data['ustatus'] = $this->config->item('status');
        $data['vendor'] = $this->user_model->getVendor();
        $data['country'] = $this->login_model->getCountryData();
        $this->global['pageTitle'] = 'ADMIN : ADD CLIENT';
        $this->loadViews("company/addCompany", $this->global, $data, NULL);
    }

        /* ADD NEW COMPANY  */
    function addNewCompany()
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('comp_name','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('username','Username','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        $this->form_validation->set_rules('role','Role','trim|required|numeric');
        $this->form_validation->set_rules('vendor','Vendor','trim|required|numeric');
        $this->form_validation->set_rules('pincode','Pincode','required|min_length[6]');
        $this->form_validation->set_rules('adhar_no','Addhar Number','required|min_length[12]');  
        $this->form_validation->set_rules('email_address','Email Address','required');  
            
        if($this->form_validation->run() == FALSE)
        {
            $this->addCompany();
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('comp_name'))));
            $username = $this->security->xss_clean($this->input->post('username'));
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            $vendorId = $this->input->post('vendor');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $email_address = $this->security->xss_clean($this->input->post('email_address'));

            $gst_number = $this->security->xss_clean($this->input->post('gst_number'));
            $address = $this->security->xss_clean($this->input->post('address'));
            $pincode = $this->security->xss_clean($this->input->post('pincode'));
            $country = $this->security->xss_clean($this->input->post('country'));
            $state = $this->security->xss_clean($this->input->post('state'));
            $district = $this->security->xss_clean($this->input->post('district'));
            $city = $this->security->xss_clean($this->input->post('city'));
            
            $status = $this->security->xss_clean($this->input->post('status'));
            $adhar_no = $this->security->xss_clean($this->input->post('adhar_no'));
            $pan_no = $this->security->xss_clean($this->input->post('pan_no'));

            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
            $bank_branch = $this->security->xss_clean($this->input->post('bank_branch'));
            $ifsc_code = $this->security->xss_clean($this->input->post('ifsc_code'));
            $ac_number = $this->security->xss_clean($this->input->post('ac_number'));
            $userInfo = array(
                'email'=>$username, 
                //'password'=>$this->randomPassword(), 
                'email_address'=>$email_address,
                'password'=> $password,
                'roleId'=>$roleId, 
                'name'=> $name,
                'mobile'=>$mobile,
                'c_vendorId' => $vendorId,
                'c_gst_number'=>$gst_number,
                'c_address'=>$address,
                'c_pincode'=>$pincode,
                'c_country' => $country,
                'c_district' => $district,
                'c_city'=>$city,
                'c_state'=>$state,
                'status' => $status,
                'adhar_no' => $adhar_no,
                'pan_no' => $pan_no,
                'comp_bank_name' => $bank_name, 'comp_bank_branch' => $bank_branch, 'comp_ifsc_code' => $ifsc_code, 'comp_ac_number' => $ac_number,
                'user_flag' => "comp_user",
                'createdBy'=>$this->vendorId, 
                'createdDtm'=>date('Y-m-d H:i:s'));
            
                $check = $this->user_model->companyCheck();
            if($check == 0){
                $result = $this->user_model->addNewUser($userInfo);
                if($result > 0)
                {
                    $process = 'Client Adding';
                    $processFunction = 'Admin/addNewCompany';
                    $this->logrecord($process,$processFunction);
                    $this->session->set_flashdata('success', 'Client Successfully Created');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Client Failed to Create');
                }
            }else{
                $this->session->set_flashdata('error', 'Client Already Exist');
            }
                
            redirect('companyListing');
        }
    }

        /* UPDATE COMPANY  */
        
        function editcompany($userId = NULL)
        {
                if($userId == null)
                {
                    redirect('companyListing');
                }

                $data['roles'] = $this->user_model->getUserRolesForcompany();
                $data['stat'] = $this->config->item('status');
                $data['vendor'] = $this->user_model->getVendor();
                $data['country'] = $this->login_model->getCountryData();
                $data['state'] = $this->login_model->getAllStateData();
                $data['dist'] = $this->login_model->getAllDistrictData();
                $data['city'] = $this->login_model->getAllCityData();
                $data['userInfo'] = $this->user_model->getUserInfo($userId);

                $this->global['pageTitle'] = 'ADMIN : Client Edit';
                
                $this->loadViews("company/editcompany", $this->global, $data, NULL);
        }

        // SEND EMAIL ====
        function sendEmail($userId = NULL)
        {
            if($userId == null)
            {
                redirect('companyListing');
            }
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            //  print_r($data['userInfo'][0]->name); exit;
            $name = $data['userInfo'][0]->name;
            $to = $data['userInfo'][0]->email_address;
            $username = $data['userInfo'][0]->email;
            $password = $data['userInfo'][0]->password;
            $Subject = 'ParcelBhej Registration Email -'.date('Y-m-d H:i:s');

            $Body  = '<html>';
            $Body .= '<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">';
            $Body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
            
            $Body .= '<tr>';
            //$Body .= '<td bgcolor="#FFA73B" align="center">';
            $Body .= '<td bgcolor="#f4f4f4" align="center">';
            $Body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
            $Body .= '<tr>';
            $Body .= '<td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';


            $Body .= '<tr>';
            //$Body .= '<td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">';
            $Body .= '<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">';
            $Body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;">';
            // $Body .= '<h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1> <img src="https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120" style="display: block; border: 0px;" />';
            $Body .= '<h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1> <img src="https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120" style="display: block; border: 0px;" />';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';


            $Body .= '<tr>';
            $Body .= '<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">';
            $Body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666;">';
            $Body .= '<p style="margin: 0;">Were excited to have you get started. First, you need to confirm your account. Just press the button below.</p>';
            $Body .= '<p style="margin: 0;">Username  :'.$username.'</p>';
            $Body .= '<p style="margin: 0;">Password  :'.$password.'</p>';
            $Body .= '</td>';
            $Body .= '</tr>';
           
           
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="left">';
            $Body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">';
            $Body .= '<table border="0" cellspacing="0" cellpadding="0">';
            $Body .= '<tr>';
            $Body .= '<td align="center" style="border-radius: 3px;" bgcolor="#FFA73B"><a href="'.ADMIN_URL.'" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">Login to your Account</a></td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';


            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666;">';
            $Body .= '<p style="margin: 0;">If that doesnt work, copy and paste the following link in your browser:</p>';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666;">';
            $Body .= '<p style="margin: 0;"><a href="#" target="_blank" style="color: #FFA73B;">'.ADMIN_URL.'</a></p>';
            $Body .= '</td>';
            $Body .= '</tr>';


            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666;">';
            $Body .= '<p style="margin: 0;">If you have any questions, just reply to this email were always happy to help out.</p>';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;">';
            $Body .= '<p style="margin: 0;">Thank You,<br>Parcelbhej Team</p>';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';


            $Body .= '<tr>';
            $Body .= '<td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">';
            $Body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
            $Body .= '<tr>';
            //$Body .= '<td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;">';
            //$Body .= '<h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>';
            //$Body .= '<p style="margin: 0;"><a href="#" target="_blank" style="color: #FFA73B;">We&rsquo;re here to help you out</a></p>';
            //$Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';

            $Body .= '<tr>';
            $Body .= '<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">';
            $Body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
            $Body .= '<tr>';
            $Body .= '<td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666;"> <br>';
           // $Body .= '<p style="margin: 0;">If these emails get annoying, please feel free to <a href="#" target="_blank" style="color: #111111; font-weight: 700;">unsubscribe</a>.</p>';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</td>';
            $Body .= '</tr>';
            $Body .= '</table>';
            $Body .= '</body>';
            $Body .= '</html>';
            
            $sendmail= $this->mail->sendMail($name,$to,$Subject,$Body);


            if($sendmail){
                $process = 'Send Email';
                $processFunction = 'Admin/sendEmail - Send Email to .'.$name.'('.$to.')';
                $this->logrecord($process,$processFunction);
                
               // $this->session->set_flashdata('success', 'Email Successfully Sent');
                echo 1;
            }else{
               // $this->session->set_flashdata('error', $sendmail);
                echo 0;
            }

            // redirect('companyListing');
        }

        // ===========
        function editCompUser()
        {
                $this->load->library('form_validation');
                
                $userId = $this->input->post('userId');
                $this->form_validation->set_rules('comp_name','Full Name','trim|required|max_length[128]');
                //$this->form_validation->set_rules('username','Email','trim|required|valid_email|max_length[128]');
                 $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
                // $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
                // $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
                $this->form_validation->set_rules('role','Role','trim|required|numeric');
                $this->form_validation->set_rules('pincode','Pincode','required|min_length[6]');
                $this->form_validation->set_rules('adhar_no','Addhar Number','required|min_length[12]'); 
                $this->form_validation->set_rules('email_address','Addhar Number','required'); 
                if($this->form_validation->run() == FALSE)
                {
                    $this->editcompany($userId);
                }
                else
                {
                    $name = ucwords(strtolower($this->security->xss_clean($this->input->post('comp_name'))));
                    $username = $this->security->xss_clean($this->input->post('username'));
                    $password = $this->input->post('password');
                    $roleId = $this->input->post('role');
                    $vendorId = $this->input->post('vendor');
                    $mobile = $this->security->xss_clean($this->input->post('mobile'));

                    $gst_number = $this->security->xss_clean($this->input->post('gst_number'));
                    $address = $this->security->xss_clean($this->input->post('address'));
                    $pincode = $this->security->xss_clean($this->input->post('pincode'));
                    $country = $this->security->xss_clean($this->input->post('country'));
                    $state = $this->security->xss_clean($this->input->post('state'));
                    $district = $this->security->xss_clean($this->input->post('district'));
                    $city = $this->security->xss_clean($this->input->post('city'));
                    $status = $this->security->xss_clean($this->input->post('status'));
                    $adhar_no = $this->security->xss_clean($this->input->post('adhar_no'));
                    $pan_no = $this->security->xss_clean($this->input->post('pan_no'));

                    $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
                    $bank_branch = $this->security->xss_clean($this->input->post('bank_branch'));
                    $ifsc_code = $this->security->xss_clean($this->input->post('ifsc_code'));
                    $ac_number = $this->security->xss_clean($this->input->post('ac_number'));

                    $email_address = $this->security->xss_clean($this->input->post('email_address'));
                    
                    $userInfo = array();
                    
                    if(empty($password))
                    {
                        $userInfo = array(
                        // 'email'=>$username, 
                        'roleId'=>$roleId, 
                        'email_address'=>$email_address,
                        'name'=> ucwords($name),
                        'mobile'=>$mobile,
                        'c_vendorId' => $vendorId,
                        'c_gst_number'=>$gst_number,
                        'c_address'=>$address,
                        'c_pincode'=>$pincode,
                        'c_country' => $country,
                        'c_district' => $district,
                        'c_city'=>$city,
                        'c_state'=>$state,
                        'status' => $status,
                        'adhar_no' => $adhar_no,
                        'pan_no' => $pan_no, 
                        'comp_bank_name' => $bank_name, 'comp_bank_branch' => $bank_branch, 'comp_ifsc_code' => $ifsc_code, 'comp_ac_number' => $ac_number,
                        'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    }
                    else
                    {
                        $userInfo = array(
                        // 'email'=>$username, 
                        // 'password'=>$password, 
                        'roleId'=>$roleId, 
                        'name'=>ucwords($name),
                        'email_address'=>$email_address,
                        'mobile'=>$mobile,
                        'c_vendorId' => $vendorId,
                        'c_gst_number'=>$gst_number,
                        'c_address'=>$address,
                        'c_pincode'=>$pincode,
                        'c_country' => $country,
                        'c_district' => $district,
                        'c_city'=>$city,
                        'c_state'=>$state,
                        'c_city'=>$city,
                        'c_state'=>$state,
                        'status' => $status,
                        'adhar_no' => $adhar_no,
                        'pan_no' => $pan_no,
                        'comp_bank_name' => $bank_name, 'comp_bank_branch' => $bank_branch, 'comp_ifsc_code' => $ifsc_code, 'comp_ac_number' => $ac_number,
                        'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                    }
                    
                    $result = $this->user_model->editUser($userInfo, $userId);
                    
                    if($result == true)
                    {
                        $process = 'User Update';
                        $processFunction = 'Admin/editUser';
                        $this->logrecord($process,$processFunction);
    
                        $this->session->set_flashdata('success', 'Company Successfully Updated');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Please Check Details Properly');
                    }
                    
                    if($this->session->userdata('user_flag')=='comp_user' && $this->session->userdata('loginvendorId')!=NULL){
                        
                        
                        redirect('editcompany/'.$userId);
                        
                    }else{
                        redirect('companyListing');
                    }
                      
                }
        }

        /** ===== COMPANY DETAILS START ======= **/
    /* VENDOR LIST VIEW  */
    function vendorListing()
    {   
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        
        $this->load->library('pagination');
        
        $count = $this->user_model->vendorListingCount($searchText);

        $returns = $this->paginationCompress ( "vendorListing/", $count, 10 );
        
        $data['vendorRecords'] = $this->user_model->vendorListing($searchText, $returns["page"], $returns["segment"]);
        
        $process = 'Vendor Listing';
        $processFunction = 'Admin/vendorListing';
        $this->logrecord($process,$processFunction);

        $this->global['pageTitle'] = 'ADMIN : Vendor List';
        
        $this->loadViews("vendor/viewVendor", $this->global, $data, NULL);
    }

    /**
     * ADD NEW VENDOR MASTER
     */
    function addVendor()
    {
        $this->global['pageTitle'] = 'ADMIN : ADD VENDOR';

        $this->loadViews("vendor/addVendor", $this->global, NULL);
    }
    
    // function rolekey_exists($key) {
    //     $check = $this->user_model->vendorCheck($key);
    //   }
    function addNewVendor()
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('vmobile','Mobile Number','required|min_length[10]');   
        // $this->form_validation->set_rules('email1', 'Email', 'callback_rolekey_exists');

        if($this->form_validation->run() == FALSE)
        {
            $this->addVendor();
        }
        else
        {
            $name = $this->security->xss_clean($this->input->post('vendor_name'));
            $vcperson = $this->security->xss_clean($this->input->post('vcperson'));
            $email1 = $this->security->xss_clean($this->input->post('email1'));
            $email2 = $this->security->xss_clean($this->input->post('email2'));
            $vmobile = $this->security->xss_clean($this->input->post('vmobile'));
            $tel_no = $this->security->xss_clean($this->input->post('tel_no'));

            $vpan_no = $this->security->xss_clean($this->input->post('vpan_no'));
            $GST_no = $this->security->xss_clean($this->input->post('GST_no'));
            $tds = $this->security->xss_clean($this->input->post('tds'));
            $gumasta_no = $this->security->xss_clean($this->input->post('gumasta_no'));
            $notes = $this->security->xss_clean($this->input->post('notes'));

            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
            $bank_branch = $this->security->xss_clean($this->input->post('bank_branch'));
            $ifsc_code = $this->security->xss_clean($this->input->post('ifsc_code'));
            $ac_number = $this->security->xss_clean($this->input->post('ac_number'));
            
            $config['upload_path'] 	='./uploads/vendor/';
		    $config['allowed_types']= 'jpg|png|jpeg|pdf|doc|docx|';
	  	    $config['file_name']    = 'vendor_'.$GST_no;
	  	    $this->load->library('upload', $config);
	  	    $this->upload->initialize($config);
		    if(!is_dir($config['upload_path'])){  mkdir($config['upload_path'],0755,TRUE); }	 
	  	    if($this->upload->do_upload('vendor_pic'))
	  	    {               
	  		    $info =  $this->upload->data();
	  		    $filepath= 'vendor_'.$GST_no.$info['file_ext'];
	  	    }else{ $filepath = "";}

            $vendorInfo = array(
                'vendor_name'=>$name, 
                'contact_person'=>$vcperson, 
                'email1'=> $email1,
                'email2'=>$email2,
                'contact_no'=>$vmobile,
                'tel_no'=>$tel_no,
                'vm_pan_no'=>$vpan_no,
                'vm_GST'=>$GST_no,
                'vm_TDS'=>$tds,
                'gumasta_no' => $gumasta_no,
                'notes' => $notes,
                'bank_name' => $bank_name,
                'bank_branch' => $bank_branch,
                'ifsc_code' => $ifsc_code,
                'account_no' => $ac_number,
                'vendor_picture' => $filepath,
                'createdBy'=>$this->vendorId, 
                'createdDtm'=>date('Y-m-d H:i:s'));
            $check = $this->user_model->vendorCheck();
            if($check == 0){

                $result = $this->user_model->addNewVendor($vendorInfo);                
                if($result > 0)
                {
                    $process = 'Vendor / Vendor Adding';
                    $processFunction = 'Admin/addNewVendor';
                    $this->logrecord($process,$processFunction);
                    $this->session->set_flashdata('success', 'Vendor Successfully Created');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vendor Failed to Create');
                }
                redirect('vendorListing');
            }else{
                $this->session->set_flashdata('error', 'Vendor Already Exist');
                // redirect('addVendor');
                redirect('vendorListing');
            }
            
        }
    }
    // === DELETE VENDOR ======

    function deleteVendor()
    {
        $vendorId = $this->input->post('vendorId');
        $vendorInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
        
        $result = $this->user_model->deleteVendor($vendorId, $vendorInfo);
        
        if ($result > 0) {
                echo(json_encode(array('status'=>TRUE)));

                $process = 'Vendor Deletion';
                $processFunction = 'Admin/deleteVendor';
                $this->logrecord($process,$processFunction);

            }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // ======= EDIT VENDOR =========
    
    function editVendor($vendorId = NULL)
    {
        if($vendorId == null)
        {
            redirect('vendorListing');
        }
                
        $data['vendorInfo'] = $this->user_model->getVendorInfo($vendorId);
        $this->global['pageTitle'] = 'ADMIN : Vendor Edit';
        $this->loadViews("vendor/editVendor", $this->global, $data, NULL);
    }

    // UPDATE RECORD 
    function editVendorRecord()
    {
        $this->load->library('form_validation');
                
        $vendorId = $this->input->post('vendorId');
        $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('email1','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('email2','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('vmobile','Mobile Number','required|min_length[10]');   

        if($this->form_validation->run() == FALSE)
        {
            $this->editVendor($Id);
        }
        else
        {
            $name = $this->security->xss_clean($this->input->post('vendor_name'));
            $vcperson = $this->security->xss_clean($this->input->post('vcperson'));
            $email1 = $this->security->xss_clean($this->input->post('email1'));
            $email2 = $this->security->xss_clean($this->input->post('email2'));
            $vmobile = $this->security->xss_clean($this->input->post('vmobile'));
            $tel_no = $this->security->xss_clean($this->input->post('tel_no'));

            $vpan_no = $this->security->xss_clean($this->input->post('vpan_no'));
            $GST_no = $this->security->xss_clean($this->input->post('GST_no'));
            $tds = $this->security->xss_clean($this->input->post('tds'));
            $gumasta_no = $this->security->xss_clean($this->input->post('gumasta_no'));
            $notes = $this->security->xss_clean($this->input->post('notes'));

            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
            $bank_branch = $this->security->xss_clean($this->input->post('bank_branch'));
            $ifsc_code = $this->security->xss_clean($this->input->post('ifsc_code'));
            $ac_number = $this->security->xss_clean($this->input->post('ac_number'));
            $vendor_picture = $this->input->post('vendor_pic1');

            $config['upload_path'] 	='./uploads/vendor/';
		    $config['allowed_types']= 'jpg|png|jpeg|pdf|doc|docx|';
            // $config['overwrite'] = TRUE;
	  	    $config['file_name']    = 'vendor_'.$GST_no;
	  	    $this->load->library('upload', $config);
	  	    $this->upload->initialize($config);
	  	    if($this->upload->do_upload('vendor_pic'))
	  	    {   
                $filename = $config['upload_path'] . $vendor_picture.$info['file_ext']; 
                if (file_exists($filename))
                {
                    unlink($filename);
                }            
	  		    $info =  $this->upload->data();
	  		    $filepath = 'vendor_'.$GST_no.$info['file_ext'];
	  	    }else{ 
                $filepath= $vendor_picture;
            }
            $vendorInfo = array(
            'vendor_name'=>$name, 
            'contact_person'=>$vcperson, 
            'email1'=> $email1,
            'email2'=>$email2,
            'contact_no'=>$vmobile,
            'tel_no'=>$tel_no,
            'vm_pan_no'=>$vpan_no,
            'vm_GST'=>$GST_no,
            'vm_TDS'=>$tds,
            'gumasta_no' => $gumasta_no,
            'notes' => $notes,
            'bank_name' => $bank_name,
            'bank_branch' => $bank_branch,
            'ifsc_code' => $ifsc_code,
            'account_no' => $ac_number,
            'vendor_picture' => $filepath,
            'updatedBy'=>$this->vendorId, 
            'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->user_model->editVendor($vendorInfo, $vendorId);    
            if($result == true)
            {
                        $process = 'Vendor Update';
                        $processFunction = 'Admin/editVendor';
                        $this->logrecord($process,$processFunction);
    
                        $this->session->set_flashdata('success', 'Vendor Successfully Updated');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Please Check Details Properly');
                    }
                    
                    redirect('vendorListing');
                }
        }


     public function vendorView($vendorId = NULL) {  

                $data['vendorInfo'] = $this->user_model->getVendorInfo($vendorId);
                $this->global['pageTitle'] = 'ADMIN : Vendor View';
                $this->loadViews("vendor/vendorView", $this->global, $data, NULL);
        }


      public function randomPassword() {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
     
        /*This function is use to open attachment */
        public function attachmentcompany($userId = NULL){

            if($userId == null)
            {
                redirect('companyListing');
            }

            $data['clientInfo']=$this->user_model->getClientInfo($userId);
            $data['docInfo']=$this->user_model->getDocumentInfo($userId);
            $this->global['pageTitle'] = 'ADMIN : Attchetment View';
            $this->loadViews("company/attachmentCompany", $this->global, $data, NULL);        
        }

        public function addDocuments()
        {
            $clientid = $this->input->post('clientid');
            $file_data = $_FILES;
            $attach_name = $this->input->post('attach_name');
            // print_r($attach_name);
            // exit;

            $flag = 0;

            if($file_data['file']['error'] == 0)
            {
                unset($config);
                $config = array();
                $config['upload_path']   = 'uploads/documents/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf|gif|xlsx|csv';
                $config['detect_mime']   = 'TRUE';
                $config['remove_spaces'] = 'TRUE';
                
                
                $file_name = $file_data['file']['name'];
                $filename = time().'_'.$file_name;
                
                $filename = str_replace(" ","_",$filename);
                $filename = str_replace("-","_",$filename);
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('file'))
                {
                    $errors = $this->upload->display_errors();
                    $record_array['error'] = $errors;
                }
                else
                {
                    $inputFileName = "./uploads/documents/".$filename;
                    // print_r($inputFileName);
                }

                $docInfo = array(
                    'client_id' => $clientid,
                    'attachment_name' => $attach_name,
                    'document' => $filename,
                    'doc_status' => 1,
                    'createdBy'=>$this->vendorId, 
                    'createdDtm'=>date('Y-m-d H:i:s')
                );
                $resultDoc = $this->db->insert('tbl_document',$docInfo);
                // print_r($resultDoc)
                if($resultDoc == 1)
                {
                    echo 1;
                }
                else
                {
                   echo 0;
                }
            }
        }

        function deleteDocument()
        {
            $docId = $this->input->post('docId');
            $docInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteDocument($docId, $docInfo);
            
            if ($result > 0) {
                    echo(json_encode(array('status'=>TRUE)));

                    $process = 'Document Deletion';
                    $processFunction = 'Admin/deleteDocument';
                    $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

    // ============================================
    function banner()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->comman_model->bannerListingCount($searchText);

			$returns = $this->paginationCompress ( "banner/", $count, 10 );
            
            $data['bannerRecords'] = $this->comman_model->bannerListing($searchText, $returns["page"], $returns["segment"]);
            
            $process = 'banner List';
            $processFunction = 'Admin/banner';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Banner List';
            
            $this->loadViews("admin/bannerList", $this->global, $data, NULL);
    }

    function addBanner()
    {
            $this->global['pageTitle'] = 'ADMIN : ADD BANNER';
            $this->loadViews("admin/addBanner", $this->global, '', NULL);
    }

    function addNewBanner()
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('title','Banner Title','trim|required|max_length[128]');
        if($this->form_validation->run() == FALSE)
        {
            $this->addBanner();
        }
        else
        {
            $title = $this->security->xss_clean($this->input->post('title'));
            $desc = $this->security->xss_clean($this->input->post('desc'));
            $status = $this->security->xss_clean($this->input->post('status'));
            
            $config['upload_path'] 	='./uploads/banner/';
		    $config['allowed_types']= 'jpg|png|jpeg|pdf|doc|docx|';
	  	    $config['file_name']    = 'banner_'.time();
	  	    $this->load->library('upload', $config);
	  	    $this->upload->initialize($config);
		    if(!is_dir($config['upload_path'])){  mkdir($config['upload_path'],0755,TRUE); }	 
	  	    if($this->upload->do_upload('photo'))
	  	    {               
	  		    $info =  $this->upload->data();
	  		    $filepath= 'banner_'.time().$info['file_ext'];
	  	    }else{ $filepath = "";}

            $bannerInfo = array(
                'banner_title'=>$title,
                'banner_description'=>$desc,
                'banner_status' => $status,
                'banner_image' => $filepath,
                'banner_userId'=>$this->vendorId, 
                'banner_createDtm'=>date('Y-m-d H:i:s'));
            
                $result = $this->comman_model->addNewBanner($bannerInfo);                
                if($result > 0)
                {
                    $process = 'Banner / Banner Addded';
                    $processFunction = 'Admin/addNewBanner';
                    $this->logrecord($process,$processFunction);
                    $this->session->set_flashdata('success', 'Banner Successfully Created');
                
                redirect('banner');
            }else{
                $this->session->set_flashdata('error', 'Banner Already Exist');
                // redirect('addbanner');
                redirect('banner');
            } 
        }
    }

    function editBanner($banner_id = NULL)
    {
        if($banner_id == null)
        {
            redirect('banner');
        }
        $data['bannerInfo'] = $this->comman_model->getBannerInfo($banner_id);
        $this->global['pageTitle'] = 'ADMIN : Banner Edit';    
        $this->loadViews("admin/editBanner", $this->global, $data, NULL);
    }

    function updateBanner()
    {
        $this->load->library('form_validation');
                
        $bannerId = $this->input->post('bannerId');
        $this->form_validation->set_rules('title','Banner Title','trim|required|max_length[128]');
        $this->form_validation->set_rules('desc','Description','trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $this->editBanner($bannerId);
        }
        else
        {
            $title = $this->security->xss_clean($this->input->post('title'));
            $desc = $this->security->xss_clean($this->input->post('desc'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $banner_image = $this->input->post('photo1');

            $config['upload_path'] 	='./uploads/banner/';
		    $config['allowed_types']= 'jpg|png|jpeg|pdf';
            // $config['overwrite'] = TRUE;
	  	    $config['file_name']    = 'banner_'.time();
	  	    $this->load->library('upload', $config);
	  	    $this->upload->initialize($config);
              
	  	    if($this->upload->do_upload('photo'))
	  	    {   
                $filename = $config['upload_path'] . $banner_image.$info['file_ext'];
                if (file_exists($filename))
                {
                    unlink($filename);
                }            
	  		    $info =  $this->upload->data();
	  		    $filepath = 'banner_'.time().$info['file_ext'];
	  	    }else{ 
                $filepath= $banner_image;
            }
            $bannerInfo = array(
            'banner_title'=>$title, 
            'banner_description'=>$desc, 
            'banner_status'=> $status,
            'banner_image' => $filepath,
            'banner_updateId'=>$this->vendorId, 
            'banner_updateDtm'=>date('Y-m-d H:i:s'));
            $result = $this->comman_model->editBanner($bannerInfo, $bannerId);    
            if($result == true)
            {
                        $process = 'Banner Update';
                        $processFunction = 'Admin/editBanner';
                        $this->logrecord($process,$processFunction);
    
                        $this->session->set_flashdata('success', 'Banner Successfully Updated');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Please Check Details Properly');
                    }
                    
                    redirect('banner');
        }
    }
    // ===== New & Events =======

    function events()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->comman_model->eventListingCount($searchText);

			$returns = $this->paginationCompress ( "event/", $count, 10 );
            
            $data['eventRecords'] = $this->comman_model->eventListing($searchText, $returns["page"], $returns["segment"]);
            
            $process = 'event List';
            $processFunction = 'Admin/event';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Event List';
            
            $this->loadViews("admin/eventList", $this->global, $data, NULL);
    }

    function addEvents()
    {
            $this->global['pageTitle'] = 'ADMIN : ADD EVENT';
            $this->loadViews("admin/addEvent", $this->global, '', NULL);
    }

    function addNewEvents()
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('title','Event Title','trim|required|max_length[128]');
        if($this->form_validation->run() == FALSE)
        {
            $this->addEvents();
        }
        else
        {
            $title = $this->security->xss_clean($this->input->post('title'));
            $desc = $this->security->xss_clean($this->input->post('desc'));
            $status = $this->security->xss_clean($this->input->post('status'));
       
            $config['upload_path'] 	='./uploads/event/';
		    $config['allowed_types']= 'jpg|png|jpeg|pdf|doc|docx|';
	  	    $config['file_name']    = 'event_'.time();
	  	    $this->load->library('upload', $config);
	  	    $this->upload->initialize($config);
		    if(!is_dir($config['upload_path'])){  mkdir($config['upload_path'],0755,TRUE); }	 
	  	    if($this->upload->do_upload('photo'))
	  	    {               
	  		    $info =  $this->upload->data();
	  		    $filepath= 'event_'.time().$info['file_ext'];
	  	    }else{ $filepath = "";}

            $eventInfo = array(
                'event_title'=>$title,
                'event_description'=>$desc,
                'event_status' => $status,
                'event_image' => $filepath,
                'event_userId'=>$this->vendorId, 
                'event_createDtm'=>date('Y-m-d H:i:s'));
            
                $result = $this->comman_model->addNewEvent($eventInfo);                
                if($result > 0)
                {
                    $process = 'Event / Event Addded';
                    $processFunction = 'Admin/addNewEvents';
                    $this->logrecord($process,$processFunction);
                    $this->session->set_flashdata('success', 'Event Successfully Created');
                
                redirect('events');
            }else{
                $this->session->set_flashdata('error', 'Event Already Exist');
                redirect('events');
            } 
        }
    }

    function editEvents($event_id = NULL)
    {
        if($event_id == null)
        {
            redirect('events');
        }
        $data['eventInfo'] = $this->comman_model->getEventInfo($event_id);
        $this->global['pageTitle'] = 'ADMIN : Event Edit';    
        $this->loadViews("admin/editEvent", $this->global, $data, NULL);
    }

    function updateEvents()
    {
        $this->load->library('form_validation');
                
        $eventId = $this->input->post('eventId');
        $this->form_validation->set_rules('title','Event Title','trim|required|max_length[128]');
        $this->form_validation->set_rules('desc','Description','trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $this->editEvents($eventId);
        }
        else
        {
            $title = $this->security->xss_clean($this->input->post('title'));
            $desc = $this->security->xss_clean($this->input->post('desc'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $banner_image = $this->input->post('photo1');

            $config['upload_path'] 	='./uploads/event/';
		    $config['allowed_types']= 'jpg|png|jpeg|pdf';
            // $config['overwrite'] = TRUE;
	  	    $config['file_name']    = 'events_';
	  	    $this->load->library('upload', $config);
	  	    $this->upload->initialize($config);
              
	  	    if($this->upload->do_upload('photo'))
	  	    {   
                $filename = $config['upload_path'] . $banner_image.$info['file_ext'];
                if (file_exists($filename))
                {
                    unlink($filename);
                }            
	  		    $info =  $this->upload->data();
	  		    $filepath = 'events_'.$info['file_ext'];
	  	    }else{ 
                $filepath= $banner_image;
            }
            $eventInfo = array(
            'event_title'=>$title, 
            'event_description'=>$desc, 
            'event_status'=> $status,
            'event_image' => $filepath,
            'event_updateId'=>$this->vendorId, 
            'event_updateDtm'=>date('Y-m-d H:i:s'));
            $result = $this->comman_model->editEvent($eventInfo, $eventId);    
            if($result == true)
            {
                        $process = 'Event Update';
                        $processFunction = 'Admin/editEvents';
                        $this->logrecord($process,$processFunction);
    
                        $this->session->set_flashdata('success', 'Event Successfully Updated');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Please Check Details Properly');
                    }
                    
                    redirect('events');
        }
    }
    // ============================================
            
}