<?php
/* 
 *Yemen Sounds 2026 
 */


class save_file {
  var $last_error = '' ;
  var $last_error_description = '' ;
  var $saved_filename = '' ;
  var $status = false;

    function __construct($filename,$save_path,$save_name=''){
        $this->save_file($filename,$save_path,$save_name);
    }

    function normalize_path($path){
        return str_replace("\\","/",trim($path));
    }

    function sanitize_filename($filename){
        $filename = basename(urldecode($filename));
        $filename = convert2en($filename);
        $filename = strtolower($filename);
        $filename = preg_replace('/[^a-z0-9._-]/','_',$filename);
        $filename = preg_replace('/_+/','_',$filename);
        $filename = trim($filename,'._-');
        return $filename;
    }

    function is_allowed_extension($extension){
        global $upload_types;
        $extension = strtolower(trim($extension));
        $blocked_extensions = array('php','php3','php4','php5','php7','php8','phtml','phar','cgi','pl','py','asp','aspx','js','sh','bat','cmd','com','exe','scr','msi','htaccess','htpasswd','ini');
        if($extension === '' || in_array($extension,$blocked_extensions)){
            return false;
        }
        return in_array($extension,$upload_types);
    }

    function is_image_extension($extension){
        return in_array(strtolower($extension), array('jpg','jpeg','png','gif','bmp','webp'));
    }

    function validate_image_source($source,$extension,$is_content=false){
        if(!$this->is_image_extension($extension)){
            return true;
        }
        if($is_content){
            if(function_exists('getimagesizefromstring')){
                return (bool) @getimagesizefromstring($source);
            }
            return true;
        }
        return (bool) @getimagesize($source);
    }
    
    function save_file($filename,$save_path,$save_name=''){
     global $phrases,$settings ;
     
      $this->last_error_description = '' ;
     $this->saved_filename = '' ;
  $this->status = false;
  if($settings['uploader']){
     $save_path = $this->normalize_path($save_path);
     $uploader_root = $this->normalize_path($settings['uploader_path']);
     $root_prefix = trim($uploader_root,'/') . '/';
     if($save_path !== trim($uploader_root,'/') && strpos(trim($save_path,'/').'/',$root_prefix) !== 0){
     $this->last_error_description = iif($phrases['err_wrong_uploader_folder'],$phrases['err_wrong_uploader_folder'],"Invalid Uplaod Folder") ;    
     $this->status=false;
     }elseif(!file_exists($save_path)){
     $this->last_error_description = iif($phrases['err_wrong_uploader_folder'],$phrases['err_wrong_uploader_folder'],"Invalid Uplaod Folder") ;    
     $this->status=false;    
     }else{
    
    $save_name = iif($save_name,$save_name,basename(urldecode($filename)));
    $save_name = $this->sanitize_filename($save_name);
    if(!$save_name){
        $save_name = rand_string(20);
    }
    
    $imtype = file_extension($save_name);
    $imtype = strtolower($imtype);
    if(!$this->is_allowed_extension($imtype)){
     $this->last_error_description = iif($phrases['this_filetype_not_allowed'],$phrases['this_filetype_not_allowed'],"This file type is not allowed");
     $this->status=false;
     return;
    }
    
    
    while(file_exists(CWD . "/" .$save_path."/".$save_name)){
    $save_name = str_replace(".$imtype","",$save_name)."_".rand(0,999).".$imtype";    
    }
    
          
     //------------ External File ---------//     
    if(strchr($filename,'http://') || strchr($filename,'https://')){
        
  // --------------- using curl --------//      
    if (function_exists('curl_init')) {
   
   if($this->curl_check_url($filename)){    
   $ch = curl_init(); 
   curl_setopt($ch, CURLOPT_URL, $filename); 
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
   curl_setopt($ch, CURLOPT_USERAGENT, 'ALLOMANI PHP AGENT v'.phpversion()); 

   $content = curl_exec($ch); 

   curl_close($ch);
   }else{
   $this->last_error_description =  str_replace("{url}",$filename,iif($phrases['err_url_x_invalid'],$phrases['err_url_x_invalid'],"URL {url} is Invalid"));
              $this->status=false;    
   }
} else {
  //----------- using fopen ----------//
   if (ini_get('allow_url_fopen') == 0){
 $this->last_error_description = iif($phrases['cp_url_fopen_disabled_msg'],$phrases['cp_url_fopen_disabled_msg'],"url fopen is disabled") ;    
 $this->status=false;
    }else{
    /* if ($filesize = fetch_remote_filesize($filename))
            {
                 */
               @ini_set('user_agent', 'PHP');
                    if (!($handle = @fopen($filename, 'rb')))
                    {
                    $this->last_error_description =  str_replace("{url}",$filename,iif($phrases['err_url_x_invalid'],$phrases['err_url_x_invalid'],"URL {url} is Invalid"));
              $this->status=false;
                    }else{
                    while (!feof($handle))
                    {
                        $content .= fread($handle, 8192);
                    }
                    @fclose($handle);
                    }
             /*   
            }else{
              $this->last_error_description =  str_replace("{url}",$filename,$phrases['err_url_x_invalid']);
              $this->status=false;
            } */   
        
    }
} 

if($content){ 
if(!$this->validate_image_source($content,$imtype,true)){
 $this->last_error_description = iif($phrases['this_filetype_not_allowed'],$phrases['this_filetype_not_allowed'],"This file type is not allowed");
 $this->status=false;
 return;
}
$fp = @fopen(CWD . "/" .$save_path."/".$save_name, 'wb');
if($fp){
    @fwrite($fp, $content);
    @fclose($fp);
  $this->saved_filename = $save_path."/".$save_name ;  
     $this->status=true;
}else{
 $this->last_error_description = iif($phrases['err_wrong_uploader_folder'],$phrases['err_wrong_uploader_folder'],"Invalid Uplaod Folder or none Writable") ;    
 $this->status=false;
}
}else{
   $this->last_error_description = iif($this->last_error_description,$this->last_error_description,'Unknown Error') ; 
    $this->status=false;
}

    }else{
     //----------- internal uploaded file ------------//   
    if(!$this->validate_image_source($filename,$imtype,false)){
    $this->last_error_description = iif($phrases['this_filetype_not_allowed'],$phrases['this_filetype_not_allowed'],"This file type is not allowed");
    $this->status=false;
    return;
    }
    
    @move_uploaded_file($filename, CWD . "/" . $save_path."/".$save_name);
   
   if(file_exists(CWD . "/" . $save_path."/".$save_name)){ 
   $this->saved_filename = $save_path."/".$save_name ;
   $this->status=true;  
   }else{
    $this->last_error_description = iif($this->last_error_description,$this->last_error_description,'Unknown Error') ; 
    $this->status=false;
   }        
    } 
     }
    }else{
    $this->last_error_description = $settings['uploader_msg'] ; 
    $this->status=false;    
    }
        
    }
    
    
 function curl_check_url($url) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_HEADER, 1); // get the header
    curl_setopt($c, CURLOPT_NOBODY, 1); // and *only* get the header
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); // get the response as a string from curl_exec(), rather than echoing it
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1); // don't use a cached version of the url
    if (!curl_exec($c)) { return false; }
    $httpcode = curl_getinfo($c, CURLINFO_HTTP_CODE);
    return ($httpcode < 400);
}    
    
}
