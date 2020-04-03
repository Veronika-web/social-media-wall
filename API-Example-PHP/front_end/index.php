<?php
/*-------------------------------------
  DATABASE CONNECTION AND SELECT TABLE
---------------------------------------*/
$hostname='localhost:3306';
$username='root';
$password='';
$database_name='php_DB';
$table_name="JSON_DATA";
set_error_handler("noticeHandler");
$conn=mysqli_connect($hostname,$username,$password,$database_name);
$sql=mysqli_query($conn,"SELECT * FROM $table_name ORDER BY creationtime  DESC  LIMIT 20 offset 0");
?> 
    <!------------------------HTML CODE TO DISPLAY THE API POST----------------------->
    <!doctype html>
    <html>
     <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Social Media Aggregator API Live Example using PHP - SocialMediaWall.IO</title>
        <meta name="Description" content="Social media aggregator API live example using PHP. Open source available for download from github.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!------css styles----->
        <link rel="stylesheet" href="styles.css" type="text/css">


     </head>
     <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="https://www.socialmediawall.io">Social media aggregator</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <form class="navbar-form navbar-right" role="form">
                        <a href="https://github.com/socialmediawall-io/API-Live-Example-JS" type="button" class="btn btn-lg btn-default">View on GitHub <i class="fa fa-github"></i> </a>
                    </form>
                </div>
            </div>
        </nav>
        <div class="jumbotron">
            <div class="container">
                <h1>Hello, world!</h1>
                <p> This is a simple one page example that uses social media wall API. The page calls the 
                    <a href="https://www.socialmediawall.io/developer">API</a> from PHP to load an API enabled test social wall.
                </p>
                <p> <a class="btn btn-primary btn-lg" href="https://www.socialmediawall.io/developer" role="button">Learn     more</a>
                </p>
            </div>
        </div>
        <div class="container">
            <div class="row">
              <h1 class="title">#Rolex</h1>
            </div>
            <div class="row">
              <div class="posts">
             <!------------------------------------------------------------------------
                FETCH DATA USING WHILE LOOP(OPENING PARENTHESES) FROM DATABASE TABLE
              --------------------------------------------------------------------------> 
                <?php  while($print_data=mysqli_fetch_assoc($sql)){ ?>
                 
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
                                <video width="100%" height="100%" style= "height:auto" controls loop autoplay muted>
                                  <source src="<?php echo $print_data["videolink"];?>" type="video/mp4"/>
                                </video>
                             </div> 
                            <?php }else{ ?>
                             <div class="wall-post-media" style="background-image:url('<?php echo $print_data["imagelink"];?>')"> </div>
                            <!--- end of if-else condition to check media exists--->
                            <?php  }  ?>            
                        </div>
                    </a>
                 
                <!-----------------------------------------
                        WHILE LOOP CLOSING PARENTHESES 
                -------------------------------------------->
                <?php  } ?>
                </div>  
            </div>
        </div>
        <div class="row text-center">
          <div class="btn btn-primary btn-lg" id="load-more-btn">Load more</div>
        </div>
<?php  
function noticeHandler(){
        die( "<h1>SOMETHNG WENT BAD!!! CHECK DATABASE CONNECTION. </h1><br/>");
} 
?>       
        <script>
        /*-----------LOAD MORE POSTS USING AJAX-----------------*/
        //set limit to get post as per sqliquery    
        var limit = 20;
        var offset =limit;

        $(document).ready(function(){

            $("#load-more-btn").click(function(){

                $('#load-more-btn').html("Loading...");
                    $.ajax({
                        type:'GET',
                        url:'loadmore.php?offset='+offset+'&limit='+limit,
                        data:'',
                        success:function(response){
                            if(response!=""){
                                $(".posts").append(response);
                                $('#load-more-btn').html("Load more");
                                offset += limit;
                            }
                            else{ 
                                $('#load-more-btn').hide(); 
                            }
                        },
                        failure:function(){
                            console.log( 'Ajax request failed...' );
                            $.ajax.retry();
                        }

                    });
            });
        });
        </script>
 </body>	 
</html>