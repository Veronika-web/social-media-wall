<?php 
/*-----------------------------------
        DATABASE CONNECTION
-------------------------------------*/
$hostname='localhost:3306';
$username='root';
$password='';
$database_name='php_DB';
$table_name="JSON_DATA";
set_error_handler("noticeHandler");
$conn=mysqli_connect($hostname,$username,$password,$database_name);
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
set_error_handler("noticeHandler");
try { 
  
    /*---------------------------------------------
    SELECT DATABASE TABLE AND GET LIMIT , OFFSET 
    -----------------------------------------------*/
    $offset=$_GET["offset"];
    $limit=$_GET["limit"];
    $sql=mysqli_query($conn,"SELECT * FROM $table_name ORDER BY creationtime DESC LIMIT ".$limit."  OFFSET ".$offset."");

/*----FETCH DATA USING WHILE LOOP(OPEN PARENTHESES) FROM DATABASE TABLE----*/
     while($print_data=mysqli_fetch_assoc($sql)){    ?>
        
            <a class="link" target="_blank" href='<?php  echo $print_data["sourcelink"]; ?>'>
                <div class="wall-post">
                    <div class="wall-post-header">   
                        <div class="text">
                            <span class="fa fa-<?php echo $print_data["source"]; ?>"></span>
                            <span><?php echo $print_data["authorname"]; ?></span>
                        </div>
                        <span class="wall-post-time"><?php echo date( "M d" , strtotime($print_data["creationtime"]));?></span>     
                    </div>
                <div class="wall-post-hr"></div>
                <div class="wall-post-text"><p><?php echo $print_data["text"]; ?></p></div>
                <!----if-else condition to check media exists --->
                <?php if($print_data["videolink"]!="" ){ ?>
                 <div class="wall-post-media"  style="height:240px"> 
                    <video width="100%" height="100%" style= "height:auto" controls loop autoplay muted >
                      <source src="<?php echo $print_data["videolink"];?>" type="video/mp4"/>
                    </video>
                 </div> 
                <?php } else{ ?>
                 <div class="wall-post-media" style="background-image:url('<?php echo $print_data["imagelink"];?>')"> </div>
                <!----end of if-else condition to check media exists --->
                <?php   } ?> 
                </div>
            </a>
        
<!--WHILE LOOP CLOSING PARENTHESES -->
     <?php  }  
}
catch (mysqli_sql_exception $ex) {
    die("data transfered to main page or check database connection! \n");
}
function noticeHandler(){
    
}
?>