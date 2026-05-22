<?php
/* 
 *Yemen Sounds 2026 
 */

 if(!defined("GLOBAL_LOADED")){die("Access Denied");}

 
 //--------------- Load freamwork Plugins --------------------------
  $pls = load_plugins("end_".CFN);
  if(is_array($pls)){foreach($pls as $pl){include($pl);}}
  
  
  
//---------------------  Footer Banners ------------------------------------------------------
//$qr = db_query("select * from songs_banners where type='footer' and active=1 and pages like '%$pg_view,%' order by ord");
$footer_banners = allomani_array_path($banners, array('footer','x',0));
if(count($footer_banners)){
 foreach($footer_banners as $data){
db_query("update songs_banners set views=views+1 where id='$data[id]'");

if($data['c_type']=="code"){
    compile_template($data['content']);
    }else{
        compile_template(get_template("center_banners"));     
}
        }
 print "<br>";
}

//---------------------------Right Content--------------------------------------
print "</td>" ;



  if(count(allomani_array_path($blocks, array('r',0)))){
print "<td width='$blocks_width' valign=\"top\" align=\"center\" dir=\"$global_dir\">";

print "<table width=100%>";


             $adv_c= 1 ;
       foreach(allomani_array_path($blocks, array('r',0)) as $zdata){
        print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                
          $right_sub_blocks = allomani_array_path($blocks, array('r',$zdata['id']));
          $sub_count = count($right_sub_blocks);      
          
        
            open_block(iif(!$zdata['hide_title'] && !$sub_count,$zdata['title']),$zdata['template']);    
            
           if($sub_count){
              
               $tabs = new tabs("block_".$zdata['id']);
 
        $tabs->start($zdata['title']);
           run_php($zdata['file']);
          $tabs->end();  
          
          foreach($right_sub_blocks as $sub_data){    

           $tabs->start($sub_data['title']);
           run_php($sub_data['file']);
          $tabs->end();     
          }
          
           $tabs->run(); 
         
          
           }else{
               
               run_php($zdata['file']);           
                     
           } 
          close_block($zdata['template']);  

                print "</td>
        </tr>";

              //---------------------------------------------------

         $right_menu_banners = allomani_array_path($banners, array('menu','r',$adv_c));
         if(count($right_menu_banners)){
           
       print_block_banners($right_menu_banners);  
        unset($banners['menu']['r'][$adv_c]);
               }
            ++$adv_c ;
        //----------------------------------------------------
           }
           
//------- print remaining blocks banners --------//
if(count(allomani_array_path($banners, array('menu','r')))){
    foreach(allomani_array_path($banners, array('menu','r')) as $data_array){
         print_block_banners($data_array); 
    }
}
   
print "</table></center></td>" ;
unset($zdata,$data,$adv_c); 
}
unset($zqr);
print "</tr></table>\n";


print_copyrights();

compile_hook('site_before_footer'); 
site_footer();
compile_hook('site_after_footer');                         
           
if($debug){ 
print "<br><div dir=ltr><b>Excution Time :</b> " .  (microtime()-$start_time)." Sec";                                                          
print "<br><b>Memory Usage :</b> " .  convert_number_format(memory_get_usage(),2,true,true);
print "<br><div dir=ltr><b>Queries :</b> " .  $queries."<br>"; 
print "</div>";
}

?>
