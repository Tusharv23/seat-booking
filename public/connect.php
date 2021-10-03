<?php
    $email = $_POST['email'];
    $no_of_seats = $_POST['no_of_tickets'];
    if($no_of_seats>7){
        die("Maximum Seat Limit Exceeded");
    }
    //Connecting database
    $conn = new mysqli('localhost:3306','app','password','ticket_booking');
    if($conn->connect_error){
        die('Database Connection Failed : '.$conn->connect_error); 
    } 

    if($email){
        $stmt = $conn->
        prepare("insert into user_bookings (email,number_of_seats) values (?,?)");
        $stmt->bind_param("si",$email,$no_of_seats); 
        $stmt->execute();
        $inserted_id = $stmt->insert_id;
        $stmt->close();
    }

    $query = "select reserved_row,reserved_column from reserved_seats";
    $result = $conn->query($query);
    $seat_arr = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $seat_arr[] = $row["reserved_row"]."-".$row["reserved_column"];
        }
    }

    if($no_of_seats){
        require_once('seat_booking.php');
        $bookSeats = new bookSeats;
        $bookSeats->create_map(7,80,$seat_arr);
        $bookedSeats = $bookSeats->allocate_seats($no_of_seats);

        if(count($bookedSeats) > 0){
            $query = "Insert into reserved_seats (booking_id,reserved_row,reserved_column) values(?,?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii",$inserted_id,$r,$c);
            for($i=0;$i<count($bookedSeats);$i++){
                $r = $bookedSeats[$i]['reserved_row'];
                $c = $bookedSeats[$i]['reserved_column'];
                $stmt->execute();
                echo "Booked Seat: ".$r."-".$c."<br>";
            }
            $stmt->close();
        } else {
            echo('Seats Not Available');
        }
    }
?>