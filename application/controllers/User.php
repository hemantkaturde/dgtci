<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'ADMIN : Home page';

        $this->loadViews("dashboard", $this->global, '' , NULL);
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to load edit user view
     */
    function loadUserEdit()
    {
        $this->global['pageTitle'] = 'ADMIN : EDIT LOGIN';
        
        $data['userInfo'] = $this->user_model->getUserInfo($this->vendorId);

        $this->loadViews("userEdit", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the of the user info
     */
    function updateUser()
    {
        $this->load->library('form_validation');
            
        $userId = $this->input->post('userId');
        
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('oldpassword','Old password','max_length[20]');
        $this->form_validation->set_rules('cpassword','Password','matches[cpassword2]|max_length[20]');
        $this->form_validation->set_rules('cpassword2','Confirm Password','matches[cpassword]|max_length[20]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadUserEdit();
        }
        else
        {
            $name = $this->security->xss_clean($this->input->post('fname'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('cpassword');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $oldPassword = $this->input->post('oldpassword');

            $userInfo = array();

            if(empty($password))
            {
            $userInfo = array('email'=>$email,'name'=>$name,
                            'mobile'=>$mobile, 'status'=>1, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            }
            else
            {
                $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
                if(empty($resultPas))
                {
                $this->session->set_flashdata('nomatch', 'Your Old Password do??ru de??il');
                redirect('userEdit');
                }
                else
                {
                $userInfo = array('email'=>$email, 'password'=>$password,
                    'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>1, 'updatedBy'=>$this->vendorId, 
                    'updatedDtm'=>date('Y-m-d H:i:s'));
                }
            }
            
            $result = $this->user_model->editUser($userInfo, $userId);
            
            if($result == true)
            {
                $process = 'Hesap Ayarlar?? G??ncelleme';
                $processFunction = 'User/updateUser';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'Hesap Ayarlar??n??z ba??ar??yla g??ncellendi');
            }
            else
            {
                $this->session->set_flashdata('error', 'Hesap Ayarlar??n?? g??ncelleme ba??ar??s??z');
            }
            
            redirect('userEdit');
        }
    }


    
    /**
     * This function is used to load the change password view
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'ADMIN : Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your Old Password do??ru de??il');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>$newPassword,'status'=>1, 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) {

                    $process = 'Change Passwordme';
                    $processFunction = 'User/changePassword';
                    $this->logrecord($process,$processFunction);

                     $this->session->set_flashdata('success', 'Change Passwordme ba??ar??l??');
                     }
                else {
                     $this->session->set_flashdata('error', 'Change Passwordme ba??ar??s??z'); 
                    }
                
                redirect('loadChangePass');
            }
        }
    }

    /**
     * This function is used to open 404 view
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'ADMIN : 404 - Sayfa Bulunamad??';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function is used to finish tasks.
     */
    function endTask($taskId)
    {
            $taskInfo = array('statusId'=>2,'endDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->endTask($taskId, $taskInfo);
            
            if ($result > 0) {
                 $process = 'G??rev Bitirme';
                 $processFunction = 'User/endTask';
                 $this->logrecord($process,$processFunction);
                 $this->session->set_flashdata('success', 'G??rev ba??ar??yla tamamland??');
                 if ($this->role != ROLE_EMPLOYEE){
                    redirect('tasks');
                 }
                 else{
                    redirect('etasks');
                 }
                }
            else {
                $this->session->set_flashdata('error', 'G??rev tamamlama ba??ar??s??z');
                if ($this->role != ROLE_EMPLOYEE){
                    redirect('tasks');
                 }
                 else{
                    redirect('etasks');
                 }
            }
    }

    /**
     * This function is used to open the tasks page for users (no edit/delete etc)
     */
    function etasks()
    {
            $data['taskRecords'] = $this->user_model->getTasks();

            $process = 'User All Missions';
            $processFunction = 'User/etasks';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : All Missions';
            
            $this->loadViews("etasks", $this->global, $data, NULL);
    }


}

?>