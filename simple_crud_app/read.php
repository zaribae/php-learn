<?php
    $title = 'View Data Pegawai';
    require_once './layouts/header.php';

    // cek id
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Include conns file
        require_once "./db/cons.php";
        
    
        $sql = "SELECT * FROM pegawai WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            
            $stmt->bindParam(":id", $param_id);
            
            
            $param_id = trim($_GET["id"]);
            
        
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    // Fetch data yang dicari jika ada
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // ambil value data
                    $name = $row["name"];
                    $address = $row["address"];
                    $salary = $row["salary"];
                    $profie = $row["profile_picture"];
                } else{
                    // url id tidak ditemukan
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    } else{
        // id tidak ditemukan
        header("location: error.php");
        exit();
    }
?>
    <div class="wrapper">
        <h1 class="mt-5 mb-4">View Pegawai</h1>
        <div class="card" style="width: 20rem; margin-left: auto; margin-right: auto; margin-top:3rem">
            <img src="<?php echo $row['profile_picture'] ?>" class="profile-size rounded" alt="<?php echo $row['name'] ?> Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                <p class="card-text">
                    <strong>Alamat : </strong><?php echo $row['address'] ?> <br>
                    <strong>Gaji sebesar : </strong> <?php echo $row['salary'] ?> <br>
                </p>
                <a href="index.php" class="mt-2 btn btn-primary">Back</a>
            </div>
        </div>
    </div>

    <!-- <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Data Pegawai</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo $row["address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p><b><?php echo $row["salary"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div> -->
</body>
</html>