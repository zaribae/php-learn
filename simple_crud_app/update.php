<?php
    $title = "Update Pegawai";

    require_once './layouts/header.php';
    // Include conns file
    require_once "./db/cons.php";
    
    // Define variable
    $name = $address = $salary = $profile_picture = "";
    $name_err = $address_err = $salary_err = "";

    // proses data dari form ketika di submit
    if(isset($_POST['submit']) && isset($_POST["id"]) && !empty($_POST["id"])){
        // dapatkan id dari hidden input value
        $id = $_POST["id"];
        
        // Validate name
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a name.";
        } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $name_err = "Please enter a valid name.";
        } else{
            $name = $input_name;
        }
        
        // Validate address
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Please enter an address.";     
        } else{
            $address = $input_address;
        }
        
        // Validate salary
        $input_salary = trim($_POST["salary"]);
        if(empty($input_salary)){
            $salary_err = "Please enter the salary amount.";     
        } elseif(!ctype_digit($input_salary)){
            $salary_err = "Please enter a positive integer value.";
        } else{
            $salary = $input_salary;
        }


        // Validate image
        $ori_file = $_FILES['profile']['tmp_name'];
        $dir = 'images/';
        $profile_picture = $dir . basename($_FILES['profile']['name']);
        $file = $profile_picture;
        move_uploaded_file($ori_file, $profile_picture);
    
        
    
        
        // check inputan
        if(empty($name_err) && empty($address_err) && empty($salary_err)){
            
            $sql = "UPDATE pegawai SET name=:name, address=:address, salary=:salary, profile_picture=:profile_picture WHERE id=:id";
    
            if($stmt = $pdo->prepare($sql)){
                
                $stmt->bindParam(":name", $param_name);
                $stmt->bindParam(":address", $param_address);
                $stmt->bindParam(":salary", $param_salary);
                $stmt->bindParam(":profile_picture", $param_profile_picture);
                $stmt->bindParam(":id", $param_id);
                
               
                $param_name = $name;
                $param_address = $address;
                $param_salary = $salary;
                $param_profile_picture = $profile_picture;
                $param_id = $id;
                
                
                if($stmt->execute()){
                    // update success, redirect ke dashboard
                    header("location: index.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            unset($stmt);
        }
        
        // Close connection
        unset($pdo);
    } else{
        // cek id
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Get parameter url
            $id =  trim($_GET["id"]);
            
            
            $sql = "SELECT * FROM pegawai WHERE id = :id";
            if($stmt = $pdo->prepare($sql)){
                
                $stmt->bindParam(":id", $param_id);
                
                $param_id = $id;
                
                
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        // Fetch data yang dicari jika ada
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                        // ambil value data
                        $name = $row["name"];
                        $address = $row["address"];
                        $salary = $row["salary"];
                        $profile_picture = $row["profile_picture"];
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
        }  else{
            // url id tidak ditemukan
            header("location: error.php");
            exit();
        }
    }
?>

        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mt-5">Edit Pegawai</h2>
                        <p>Edit input dan submit untuk mengupdate data pegawai</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data"  method="post">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                                <span class="invalid-feedback"><?php echo $name_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                                <span class="invalid-feedback"><?php echo $address_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Gaji</label>
                                <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                                <span class="invalid-feedback"><?php echo $salary_err;?></span>
                            </div>
                            <img class="mt-3 rounded" style="width: 10rem;" src="<?php echo $profile_picture ?>" alt="<?php echo $name . "Images"?>">
                            <div class="form-group mt-3">
                                <label for="formFile" class="form-label">Upload Profile Picture</label>
                                <input class="form-control" name="profile" id="profile" type="file" accept=".jpeg, .jpg, .png" id="formFile" aria-describedby="profileHelp" required>
                                <div id="profileHelp" class="form-text">Hanya menerima file dengan format (.JPG, .JPEG, .PNG)</div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="submit" class="mt-3 me-3 btn btn-primary" name="submit" value="Submit">
                            <a href="index.php" class="mt-3 btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>

<?php require_once './layouts/footer.php' ?>