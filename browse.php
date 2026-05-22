<?php
/* 
 *Yemen Sounds 2026 
 */

 require("global.php");

require(CWD . "/includes/framework_start.php");   
//----------------------------------------------------
             
print "<div class='browse-page'><div class='browse-page-shell'>";

 compile_hook('singers_start');
     
 //-------- Show Cats -------
 if(!$id && $op !="letter"){
$qr2 = db_query("select * from songs_cats where active=1 order by ord asc");
if(db_num($qr2)){
    print "<section class='browse-content-card browse-cats-card'>";
    open_table($phrases['the_cats']);
  $c=0;
    print  "<table width=100%><tr>";
while($data = db_fetch($qr2)){

    if ($c==$settings['songs_cells']) {
 print  "  </tr><tr>" ;
$c = 0 ;
}
   ++$c ;
   
   print   "<td align=center>".print_link(print_image(get_image($data['img'],"images/folder.gif"),$data['name'])."<br>$data[name]",cat_url($data['id'],$data['page_name'],$data['name']),$data['name'])."</td>";


}
 print  "</tr></table>";

close_table();
print "</section>";
}else{
    print "<center> $phrases[err_no_cats] </center>";
}
}else{
//------------------------
     
   if ($letter){

   
   $qr = db_query("select songs_singers.*,songs_cats.name as cat_name , songs_cats.id as cat_id , songs_cats.page_name as cat_page_name from songs_singers,songs_cats where songs_singers.active=1 and songs_singers.cat=songs_cats.id and songs_cats.active=1 and songs_singers.name like '".db_escape($letter)."%' order by songs_singers.name asc");
     $title = htmlspecialchars($letter) ;
          }else{
  
        $qr = db_query("select songs_singers.* from songs_singers,songs_cats where songs_singers.active=1 and songs_singers.cat=songs_cats.id and songs_cats.active=1 and songs_cats.id='$id' order by  songs_singers.name asc ");
     $data_title = db_qr_fetch("select name from songs_cats where id='$id' and active=1");
     $title = $data_title['name'];
                  }



       if (db_num($qr)){
           
             print "<section class='browse-content-card browse-singers-card'>";
             open_table($title);
if($settings['singers_groups'] && !$letter){
    

//-------- use groups -------------- 

unset($data_arr,$data_arr2);  


while($data = db_fetch($qr)){
 $lt_found = false ;

for($cx=0;$cx < count($letters_groups) ;++$cx){   
if(in_array(utf8_substr(strtoupper($data['name']),0,1),$letters_groups[$cx])){
$data_arr[$cx][] = $data ;
        $lt_found = true ;
        break;
  }
}
if(!$lt_found){
 $data_arr2[] = $data ;  
  }
  
   }
  
  unset($data);  
 //------------------ end sync data -------------------


 for($cy = 0;$cy < count($letters_groups) ;++$cy){

       $data_arr_main = $data_arr[$cy];
      if(count($data_arr_main)){
        
        
        print  "<span align=right class=title>".$letters_groups_names[$cy]."</span><hr class=separate_line 1px\" size=\"1\">";

        print   "<table width=100%><tr>" ;

   $c = 0 ;


   foreach($data_arr_main as $data){  

if ($c==$settings['songs_cells']) {print  "  </tr><tr>" ;$c = 0 ;}

          print  "<td>";
        
       run_template('browse_singers');
       
          print  "</td>";

$c++;


             }

  //  }
   print  "</tr></table>";

     }
    }
    
    unset($data);
    

    //---------------------- others array --------------------
    if(count($data_arr2)){
      print  "<span align=right class=title>$phrases[singers_other_letters]</span><hr class=separate_line size=\"1\">";

        print   "<table width=100%><tr>" ;

   $c = 0 ;

  foreach($data_arr2 as $data){  
      
if ($c==$settings['songs_cells']) {print  "  </tr><tr>" ;$c = 0 ;}

          print  "<td>";
        
        run_template('browse_singers');
        
          print  "</td>";
        
$c++;
             }

  
   print  "</tr></table>";
   }
   
   unset($data);
//---------------------------- END Letters Groups System -------------------
}else{
  print   "<table width=100%><tr>" ;
 while($data = db_fetch($qr)){
        // $singer_songs_count = db_qr_fetch("select count(id) as count from songs_songs where album='$data[id]'");
   //----------

if ($c==$settings['songs_cells']) {
print  "  </tr><TR>" ;
$c = 0 ;
}
   ++$c ;

          print  "<td>";
        
       run_template('browse_singers');
        
          print  "</td>";
   }
    print  "</tr></table>";

        }
        
     close_table();    
     print "</section>";
   
    }else{
        print "<section class='browse-content-card browse-singers-card'>";
        open_table($title);
       print "<center>  $phrases[err_no_singers] </center>";    
       close_table();
       print "</section>";
    }
 
 if($settings['prev_next_cat'] && !$letter){
prev_next_cat($id);
}      


}
 compile_hook('singers_end');                   
 print "</div></div>";
        

//---------------------------------------------------
require(CWD . "/includes/framework_end.php");      
