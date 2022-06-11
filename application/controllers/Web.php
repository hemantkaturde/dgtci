<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Web extends BaseController
{
    public function index()
    {
        $this->global['pageTitle'] = 'DGT College';
        $this->webloadViews("web/index", $this->global, '', NULL);
    }

    public function about_sanshta(){
        $this->global['pageTitle'] = 'About Sanshta';
        $this->webloadViews("web/about_sanshta", $this->global, '', NULL);
    }
    
    public function about_college(){
        $this->global['pageTitle'] = 'About College';
        $this->webloadViews("web/about_college", $this->global, '', NULL);
    }

    public function founder(){
        $this->global['pageTitle'] = 'Founder';
        $this->webloadViews("web/founder", $this->global, '', NULL);
    }

    public function vision_mission(){
        $this->global['pageTitle'] = 'Founder';
        $this->webloadViews("web/vision_mission", $this->global, '', NULL);
    }

    public function executive_committee(){
        $this->global['pageTitle'] = 'Library';
        $this->webloadViews("web/executive_committee", $this->global, '', NULL);
    }

    public function college_development_committee(){
        $this->global['pageTitle'] = 'College Developement Committee';
        $this->webloadViews("web/executive_committee", $this->global, '', NULL);
    }

    public function library(){
        $this->global['pageTitle'] = 'Library';
        $this->webloadViews("web/library", $this->global, '', NULL);
    }

    public function contact_us(){
        $this->global['pageTitle'] = 'Contact Us';
        $this->webloadViews("web/contact_us", $this->global, '', NULL);
    }

    public function gallery(){
        $this->global['pageTitle'] = 'Gallery';
        $this->webloadViews("web/gallery", $this->global, '', NULL);
    }

    public function aqar_report(){
        $this->global['pageTitle'] = 'Contact Us';
        $this->webloadViews("web/aqar_report", $this->global, '', NULL);
    }

    public function atr_report(){
        $this->global['pageTitle'] = 'ATR Report';
        $this->webloadViews("web/atr_report", $this->global, '', NULL);
    }

    public function rti_report(){
        $this->global['pageTitle'] = 'RTI Report';
        $this->webloadViews("web/rti_report", $this->global, '', NULL);
    }

    public function ssr(){
        $this->global['pageTitle'] = 'SSR';
        $this->webloadViews("web/ssr", $this->global, '', NULL);
    }

}
?>