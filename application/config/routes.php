<?php
defined('BASEPATH') OR exit('No direct script access allowed');



/*********** WEB ROUTES *******************/
$route['default_controller'] = "web";
$route['about_sanshta'] = "web/about_sanshta";
$route['about_college'] = "web/about_college";
$route['founder'] = "web/founder";
$route['vision_mission'] = "web/vision_mission";
$route['library'] = "web/library";
$route['gallery'] = "web/gallery";
$route['executive_committee'] = "web/executive_committee";
$route['college_development_committee'] = "web/college_development_committee";
$route['contact_us'] = "web/contact_us";

$route['aqar_report'] = "web/aqar_report";
$route['atr_report'] = "web/atr_report";
$route['rti_report'] = "web/rti_report";

/*********** END WEB ROUTES *******************/


$route['404_override'] = 'login/error';

/*********** USER DEFINED ROUTES *******************/
$route['Login'] = 'login';
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';

$route['banner'] = 'admin/banner';
$route['addBanner'] = 'admin/addBanner';
$route['addNewBanner'] = 'admin/addNewBanner';
$route['editBanner/(:num)'] = "admin/editBanner/$1";
$route['updateBanner'] = "admin/updateBanner";

$route['events'] = 'admin/events';
$route['addEvents'] = 'admin/addEvents';
$route['addNewEvents'] = 'admin/addNewEvents';
$route['editEvents/(:num)'] = "admin/editEvents/$1";
$route['updateEvents'] = "admin/updateEvents";

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['noaccess'] = 'login/noaccess';
$route['userListing'] = 'admin/userListing';
$route['userListing/(:num)'] = "admin/userListing/$1";
$route['addNew'] = "admin/addNew";
$route['addNewUser'] = "admin/addNewUser";
$route['editOld'] = "admin/editOld";
$route['editOld/(:num)'] = "admin/editOld/$1";
$route['editUser'] = "admin/editUser";
$route['deleteUser'] = "admin/deleteUser";
$route['log-history'] = "admin/logHistory";
$route['log-history-backup'] = "admin/logHistoryBackup";
$route['log-history/(:num)'] = "admin/logHistorysingle/$1";
$route['log-history/(:num)/(:num)'] = "admin/logHistorysingle/$1/$2";
$route['backupLogTable'] = "admin/backupLogTable";
$route['backupLogTableDelete'] = "admin/backupLogTableDelete";
$route['log-history-upload'] = "admin/logHistoryUpload";
$route['logHistoryUploadFile'] = "admin/logHistoryUploadFile";
$route['addDocuments'] = "admin/addDocuments";
$route['deleteDocument'] = "admin/deleteDocument";

// ====
$route['sendEmail/(:num)'] = "admin/sendEmail/$1";
$route['addCompany'] = "admin/addCompany";
$route['addNewCompany'] = "admin/addNewCompany";
$route['companyListing'] = "admin/companyListing";
$route['editcompany/(:num)'] = "admin/editcompany/$1";
$route['editCompUser'] = "admin/editCompUser";
$route['attachmentcompany/(:num)'] = "admin/attachmentcompany/$1";


$route['vendorListing'] = "admin/vendorListing";
$route['addVendor'] = "admin/addVendor";
$route['addNewVendor'] = "admin/addNewVendor";
$route['deleteVendor'] = "admin/deleteVendor";
$route['editVendor/(:num)'] = "admin/editVendor/$1";
$route['editVendorRecord'] = "admin/editVendorRecord";
$route['vendorView/(:num)'] = "admin/vendorView/$1";

/*********** USER CONTROLLER ROUTES *******************/
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['endTask/(:num)'] = "user/endTask/$1";
$route['etasks'] = "user/etasks";
$route['userEdit'] = "user/loadUserEdit";
$route['updateUser'] = "user/updateUser";


/*********** LOGIN CONTROLLER ROUTES *******************/
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";



/*********** ROLE CONTROLLER ROUTES *******************/
$route['roleListing'] = "role/roleListing";
$route['addRole'] = "role/addRole";
$route['addNewRole'] = "role/addNewRole";
$route['editRole/(:num)'] = "role/editRole/$1";
$route['editRoleRecord'] = "role/editRoleRecord";
$route['deleteRole'] = "role/deleteRole";

/* End of file routes.php */
/* Location: ./application/config/routes.php */