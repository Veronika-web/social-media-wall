<?php
/*-------------------------------------
PASS YOUR WALL_ID , APP_ID , APP_SECRET
---------------------------------------*/
$wall_id= "12077";
$app_id= "f0afca337586413cae1e68689d5f50b5";
$app_secret= "abb10a6046d145b0be5e1d417a7f686b";
/*-----------------------------------
DATABASE CONNECTION AND TABLE NAME
-----------------------------------*/
$hostname="localhost";
$username="root";
$password="";
$database_name="php_DB";
$table_name="JSON_DATA";
//Guzzlehttp and mysqli handler
mysqli_report( MYSQLI_REPORT_STRICT);
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
try{ 
    //MAX ITERATION to get total no. of posts
    $max_iteration=34;
    // Base URI is used with relative requests
    $client = new Client(['base_uri' => 'https://www.socialmediawall.io','timeout'  => 10.0,]); 
    $offset=0;
    //Iterations to get request
    for($iteration_index=0;$iteration_index<$max_iteration;$iteration_index++){
        /*----------------------------------
        REQUEST TO GET JSON REST API 
        -------------------------------------*/
        try{ 
            //API URL
            $url="https://www.socialmediawall.io/api/v1.1/".$wall_id."/posts/?app_id=".$app_id."&app_secret=".$app_secret."&limit=30&offset=".$offset;
            //request to get REST API
            $response = $client->get($url);
        }
        catch(RequestException $e){
            echo "CHECK TIME OUT ";
            exit();
        }
        $code = $response->getStatusCode();
        if($code!=200){
            exit();
        }
        $body = $response->getBody();

        $content=$response->getBody()->getContents();

        $json=json_decode($content);
        if(!isset($json->data)){
            exit();
        }
        if(!isset($json->data->posts)){
            exit();
        }
        $json_objects =$json->data->posts;

        if(!isset($json->data->hasMore)){
            exit();
        }
        $hasMore=$json->data->hasMore;
        $max_post=count($json_objects ); 
        //database connection
        $conn= mysqli_connect($hostname,$username,$password,$database_name);
        //loop to insert the data and if data exists update
        for($Post_index=0;$Post_index<$max_post;$Post_index++){

            $postid="'".$json_objects[$Post_index]->postid."'";
            $sourcelink="'".addslashes($json_objects[$Post_index]->sourcelink)."'";
            $text="'".addslashes($json_objects[$Post_index]->text)."'";
            $imagelink="'".addslashes($json_objects[$Post_index]->imagelink)."'";
            $videolink="'".addslashes($json_objects[$Post_index]->videolink). "'";
            $source="'".addslashes($json_objects[$Post_index]->source)."'";
            $sourceid="'" .addslashes($json_objects[$Post_index]->sourceid)."'";
            $authorname="'". addslashes($json_objects[$Post_index]->authorname)."'";
            $author_display_name="'".addslashes($json_objects[$Post_index]->author_display_name)."'";
            $authorimage="'".addslashes($json_objects[$Post_index]->authorimage)."'";
            $creationtime="'".addslashes($json_objects[$Post_index]->creationtime)."'";
            echo "\n";
            $table= "SELECT *FROM $table_name WHERE postid=$postid";
            $data =mysqli_query($conn, $table );
            $countid=mysqli_num_rows($data);
            
            if($countid!=0){
                    $update=mysqli_query($conn,"UPDATE $table_name SET sourcelink=$sourcelink text=$text imagelink=$imagelink videolink=$videolink source=$source sourceid=$sourceid authorname=$authorname author_display_name=$author_display_name authorimage=$authorimage creationtime=$creationtime  WHERE postid=$postid") or die(mysqli_connect_error());
                    echo "updated";
            }
            else{
                    $insert=mysqli_query($conn,"INSERT INTO $table_name(postid,sourcelink,text,imagelink,videolink,source,sourceid,authorname,author_display_name,authorimage,creationtime) VALUES(".$postid.",".$sourcelink.",".$text.",".$imagelink.",".$videolink.",".$source.",".$sourceid.",".$authorname.",".$author_display_name.",".$authorimage.",".$creationtime." ) ") or die(mysqli_connect_error());
                    echo "inserted";
            }

        }
        if($hasMore=='true'){ 
            $offset+=30;
        }
       else{
            break;
            echo "NO MORE POSTS";      
        }       

    }
    echo $max_post;
}

catch(RequestException $e){
    echo "Something went bad!!! CHECK TIME OUT \n" ;
}

catch (mysqli_sql_exception $ex) {
    die("Can't connect to the database! \n" );
}

?>
