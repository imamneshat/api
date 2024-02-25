<?php 

    require '../inc/DbConnect.php';

    function error422($message){
        $data = [
            'status'=> 405,
            'message'=> $message,
        ];
        header("HTTP/1.0 422 unprocessable Entity");
        echo json_encode($data);
        exit();
    }

    function storeCustomer($customerinput){
        global $conn;

        $name = mysqli_real_escape_string($conn, $customerinput['name']);
        $email = mysqli_real_escape_string($conn, $customerinput['email']);
        $mobile = mysqli_real_escape_string($conn, $customerinput['mobile']);

        if(empty(trim($name))){

            return error422('Enter your Name');
        }elseif(empty(trim($email))){

            return error422('Enter your Email');
        }elseif(empty(trim($mobile))){

            return error422('Enter your Mobile');
        }else{
            $query = "INSERT INTO users (name, email, mobile) VALUES ('$name', '$email', '$mobile')";
            $result = mysqli_query($conn, $query);

            if($result){
                $data = [
                    'status'=> 201,
                    'message'=> 'Customer Created Successfully',
                ];
                header("HTTP/1.0 201 Created");
                echo json_encode($data);
            }else {
                $data = [
                    'status'=> 500,
                    'message'=> 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode($data);
            }
        }
    }

    function getCustomerList() {

        global $conn;

        $query = "SELECT * FROM users";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            if(mysqli_num_rows($query_run) > 0){

                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

                $data = [
                    'status'=> 200,
                    'message'=> 'Customer List Fiteched Successfully',
                    'data' => $res
                ];
                header("HTTP/1.0 200 ok");
                echo json_encode($data);

            }else {
                $data = [
                    'status'=> 404,
                    'message'=> 'Customer Not Found',
                ];
                header("HTTP/1.0 404 Customer Not Found");
                echo json_encode($data);
            }
           
        }
        else {
            $data = [
                'status'=> 500,
                'message'=> 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
    }

    function getCustomer($id){
        global $conn;

        if($id['id'] == null){

            return error422('Enter your Costomer id');
        }
       
        $custpmerid = mysqli_real_escape_string($conn, $id['id']);

        $query = "SELECT * FROM users WHERE id = $custpmerid";

        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            if(mysqli_num_rows($query_run) == 1){

                $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

                $data = [
                    'status'=> 200,
                    'message'=> 'Customer List Fiteched Successfully',
                    'data' => $res
                ];
                header("HTTP/1.0 200 ok");
                echo json_encode($data);

            }else {
                $data = [
                    'status'=> 404,
                    'message'=> 'Customer Not Found',
                ];
                header("HTTP/1.0 404 Customer Not Found");
                echo json_encode($data);
            }
           
        }
        else {
            $data = [
                'status'=> 500,
                'message'=> 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
    }

    function updateCustomer($customerinput, $customerParam){

        global $conn;

        if(!isset($customerParam['id'])){

            return error422('Costomer id not found in URL');
        }elseif($customerParam['id'] == null){

            return error422('Enter your Costomer id');
        }
       

        $custpmerid = mysqli_real_escape_string($conn, $customerParam['id']);

        $name = mysqli_real_escape_string($conn, $customerinput['name']);
        $email = mysqli_real_escape_string($conn, $customerinput['email']);
        $mobile = mysqli_real_escape_string($conn, $customerinput['mobile']);

        if(empty(trim($name))){

            return error422('Enter your Name');
        }elseif(empty(trim($email))){

            return error422('Enter your Email');
        }elseif(empty(trim($mobile))){

            return error422('Enter your Mobile');
        }else{
            $query = "UPDATE users SET name ='$name', email ='$email', mobile ='$mobile' WHERE id = $custpmerid";

            $result = mysqli_query($conn, $query);

            if($result){
                $data = [
                    'status'=> 201,
                    'message'=> 'Customer Record Updated Successfully',
                ];
                header("HTTP/1.0 201 Created");
                echo json_encode($data);
            }else {
                $data = [
                    'status'=> 500,
                    'message'=> 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode($data);
            }
        }
    }

    function deleteCustomer($id){

        global $conn;

        if($id['id'] == null){

            return error422('Enter your Costomer id');
        }
       
        $custpmerid = mysqli_real_escape_string($conn, $id['id']);

        $query = "DELETE FROM users WHERE id = $custpmerid";
        $result = mysqli_query($conn, $query);

        
        if($result){

            $data = [
                'status'=> 200,
                'message'=> 'Customer Record Deleted Successfully'
            ];
            header("HTTP/1.0 200 ok");
            echo json_encode($data);

        }else {
            $data = [
                'status'=> 404,
                'message'=> 'Customer Not Found',
            ];
            header("HTTP/1.0 404 Customer Not Found");
            echo json_encode($data);
        }
    }

?>