<?php

require 'dbcon.php';


//===================insert=======================//

if(isset($_POST['save_request']))
{

    $r_name = mysqli_real_escape_string($con, $_POST['r_name']);

    //department and (group or user)

    $r_day = mysqli_real_escape_string($con, $_POST['r_day']);
    $r_hour = mysqli_real_escape_string($con, $_POST['r_hour']);
    $r_priority = mysqli_real_escape_string($con, $_POST['r_priority']);

    if($r_name == NULL || $r_priority == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO support (r_name,r_day,r_hour,r_priority) VALUES ('$r_name','$r_day','$r_hour','$r_priority')";
    $query_run = mysqli_query($con, $query);


    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Request Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Request Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

//-------------------update--------------------//

if(isset($_POST['update_request']))
{
    $request_id = mysqli_real_escape_string($con, $_POST['request_id']);

    $r_name = mysqli_real_escape_string($con, $_POST['r_name']);
    $r_day = mysqli_real_escape_string($con, $_POST['r_day']);
    $r_hour = mysqli_real_escape_string($con, $_POST['r_hour']);
    $r_priority = mysqli_real_escape_string($con, $_POST['r_priority']);

    if($r_name == NULL || $r_priority == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE support SET r_name='$r_name', r_day='$r_day', r_hour='$r_hour', r_priority='$r_priority' 
              WHERE r_id='$request_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Request Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Request Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}

//-------------------to get request id-----------------------------//

if(isset($_GET['request_id']))
{
    $request_id = mysqli_real_escape_string($con, $_GET['request_id']);

    $query = "SELECT * FROM support WHERE r_id='$request_id'";
    $query_run = mysqli_query($con, $query);
  

    if(mysqli_num_rows($query_run) == 1)
    {
        $request = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Request Fetch Successfully by id',
            'data' => $request,
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Request Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

//-------------------to change request status--------------------//

// $request_id = mysqli_real_escape_string($con, $_GET['r_id']);
// $request_status = mysqli_real_escape_string($con, $_GET['request_status']);
// $updatequery1 = "UPDATE support SET request_status=$request_status WHERE r_id=$request_id";
// mysqli_query($con,$updatequery1);
// header('location:support.php');

//==========================================//


//-------------------get department users--------------------//
if(isset($_GET['get_users'])){
    $request_id = mysqli_real_escape_string($con, $_GET['dep_id']);

    $query = "SELECT `user_id`,`name` FROM users WHERE department_id=".$_GET['dep_id']." and user_status=1";
    $query_run = mysqli_query($con, $query);
  
    $request = mysqli_fetch_all($query_run,MYSQLI_NUM);

    if(mysqli_num_rows($query_run)>0)
    {
        // $request = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Request Fetch Successfully by department id',
            'data' => $request,
        ];
        echo json_encode($res);
         return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Request No Users In Requested Department Id '
        ];
        echo json_encode($res);
         return;
    }
}

//==========================================//



//-------------------get department groups--------------------//
if(isset($_GET['get_groups'])){
    $request_id = mysqli_real_escape_string($con, $_GET['dep_id']);

    $query = "SELECT `group_id`,`group_name` FROM groups WHERE department_id=".$_GET['dep_id']." and group_status=1";
    $query_run = mysqli_query($con, $query);
  

 if(@mysqli_num_rows($query_run)>0)
    {
        $request = mysqli_fetch_all($query_run,MYSQLI_NUM);

         $res = [
            'status' => 200,
            'message' => 'Request Fetch Successfully by department id',
            'data' => $request,
        ];
        echo json_encode($res);
         return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Request No Groups In Requested Department Id '
        ];
        echo json_encode($res);
         return;
    }
}

//==========================================//
?>





