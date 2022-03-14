<?php

  $conn = new mysqli('localhost', 'root', '','newdb');

  if($conn->connect_error){
         
    die("<h2>Database connection failed!</h2>". $conn->connect_error);

  }

  if(isset($_POST["action"]))
  {

    if($_POST['action'] == 'fetch')
    {

      $query = "SELECT * FROM accounts ";
      $result = $conn->query($query);

      if($result == TRUE && $result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $data[] = array(
             'name' => $row['name'],
             'balance' => $row['balance']
          );
        }

        echo json_encode($data);
      }
      else
      {
        echo "no data";
      }
    }
  }

?>