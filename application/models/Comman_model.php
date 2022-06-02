<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Comman_model extends CI_Model
{
    //  Banner Master
    function bannerListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.banner_id, BaseTbl.banner_title, BaseTbl.banner_description, BaseTbl.banner_image, BaseTbl.banner_status');
        $this->db->from('tbl_banner as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.banner_title LIKE '%".$searchText."%'
                            OR  BaseTbl.banner_description  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if($this->session->userdata('roleText')=='Admin'){
        }else{
            $this->db->where('BaseTbl.banner_userId', $this->session->userdata('userId'));
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.banner_id', 'DESC');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    // ========
    function bannerListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.banner_id, BaseTbl.banner_title, BaseTbl.banner_description, BaseTbl.banner_image, BaseTbl.banner_status');
        $this->db->from('tbl_banner as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.banner_title LIKE '%".$searchText."%'
                            OR  BaseTbl.banner_description  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        if($this->session->userdata('roleText')=='Admin'){

        }else{
            $this->db->where('BaseTbl.banner_userId', $this->session->userdata('userId'));
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.banner_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    // ========
    public function addNewBanner($bannerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_banner', $bannerInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    // ========
    function getBannerInfo($banner_id)
    {
        $this->db->select('BaseTbl.banner_id, BaseTbl.banner_title, BaseTbl.banner_description, BaseTbl.banner_image, BaseTbl.banner_status');
        $this->db->from('tbl_banner as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.banner_id', $banner_id);
        $query = $this->db->get();
        
        return $query->result();
    }

    function editBanner($bannerInfo, $bannerId)
    {
        $this->db->where('banner_id', $bannerId);
        $this->db->update('tbl_banner', $bannerInfo);
        
        return TRUE;
    }

    //  Banner Master
    function eventListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.event_id, BaseTbl.event_title, BaseTbl.event_description, BaseTbl.event_image, BaseTbl.event_status');
        $this->db->from('tbl_event as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.event_title LIKE '%".$searchText."%'
                            OR  BaseTbl.event_description  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if($this->session->userdata('roleText')=='Admin'){
        }else{
            $this->db->where('BaseTbl.event_userId', $this->session->userdata('userId'));
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.event_id', 'DESC');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    // ========
    function eventListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.event_id, BaseTbl.event_title, BaseTbl.event_description, BaseTbl.event_image, BaseTbl.event_status');
        $this->db->from('tbl_event as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.event_title LIKE '%".$searchText."%'
                            OR  BaseTbl.event_description  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        if($this->session->userdata('roleText')=='Admin'){

        }else{
            $this->db->where('BaseTbl.event_userId', $this->session->userdata('userId'));
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.event_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    // ========
    public function addNewEvent($eventInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_event', $eventInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    // ========
    function getEventInfo($event_id)
    {
        $this->db->select('BaseTbl.event_id, BaseTbl.event_title, BaseTbl.event_description, BaseTbl.event_image, BaseTbl.event_status');
        $this->db->from('tbl_event as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.event_id', $event_id);
        $query = $this->db->get();
        
        return $query->result();
    }

    function editEvent($eventInfo, $eventId)
    {
        $this->db->where('event_id', $eventId);
        $this->db->update('tbl_event', $eventInfo);
        
        return TRUE;
    }

    // ==============================   
}