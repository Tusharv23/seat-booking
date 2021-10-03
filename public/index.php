<!DOCTYPE html>
<html>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet"> 
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css"
  rel="stylesheet"
/>
<div class="container-fluid bg-info">
  <div class="row">
      <div class="col-md-12 d-flex justify-content-center">
        <form class="bg-dark border rounded" style="top:40%;height: 40vh;width: 200px; position: relative;" action="connect.php" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <p class="text-light">Book Tickets</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <input type="email" class="border rounded mt-2 ml-2" placeholder="Email" name="email"><br>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <input type="number" class="border rounded mt-2 ml-2" placeholder="No. of tickets" name="no_of_tickets"><br>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <button type="submit" class="border rounded mt-2 ml-2 btn btn-sm text-light" value="Submit">Submit</button>
                </div>
            </div>
          </form>
      </div>
  </div>
</div>
</html>