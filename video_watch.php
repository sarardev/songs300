<?php
/* 
 *Yemen Sounds 2026 
 */

require("global.php");

require(CWD . "/includes/framework_start.php");   
//---------------------------------------------------------

$id= (int) $id;
$cat = iif($cat,intval($cat),1); 

$qr=db_query("select * from songs_videos_data where id='$id'");


if(db_num($qr)){
    
if(video_download_permission($id)){  
   
    
$data = db_fetch($qr);

print "<div class='video-watch-page'><div class='video-watch-shell'><div class='video-watch-path'>";
print_videos_path_links($data['cat'],$data['name']);
print "</div>";

if($data['url']){
db_query("update songs_videos_data set views=views+1 where id='$id'");

$data_song = db_qr_fetch("select * from songs_songs where video_id='$id'");

print "<section class='video-watch-card'>";
run_template('video_watch');
print "</section>";


if($settings['prev_next_video']){
print "<div class='video-watch-nav'>";
prev_next_video($id,$data['cat']);
print "</div>";
}


}else{
print "<section class='video-watch-card'>";
open_table();
print "<center> $phrases[file_is_not_available]</center>";
close_table();      
print "</section>";
}
print "</div></div>";
}else{
login_redirect();
}
}else{
print "<div class='video-watch-page'><div class='video-watch-shell'><section class='video-watch-card'>";
open_table();
print "<center> $phrases[err_wrong_url]</center>";
close_table();    
print "</section></div></div>";
}

//---------------------------------------------
require(CWD . "/includes/framework_end.php"); 
