<?php
    $title = 'Create Pegawai';

    // Include header file
    require_once './layouts/header.php';
     // Include conss file
    require_once "./db/cons.php";
    
    // Define variable
    $name = $address = $salary = $profile_picture = "";
    $name_err = $address_err = $salary_err = $profile_picture_error = "";
    
    //Function to make random file name
    $n=12;
    function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
    
        return $randomString;
    }

    
    // proses data dari form ketika di submit
    if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        
        //Validate image
        $ori_file = $_FILES['profile']['tmp_name'];
        $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
        $dir = 'images/';
        $profile_picture = $dir . getName($n) . '.' . $extension;
        move_uploaded_file($ori_file, $profile_picture);
    
        
        // mengecek inputan
        if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($profile_picture_error)){
            
            $sql = "INSERT INTO pegawai (name, address, salary, profile_picture) VALUES (:name, :address, :salary, :profile_picture)";
    
            if($stmt = $pdo->prepare($sql)){
                
                $stmt->bindParam(":name", $param_name);
                $stmt->bindParam(":address", $param_address);
                $stmt->bindParam(":salary", $param_salary);
                $stmt->bindParam(":profile_picture", $param_profile_picture);
                
                
                $param_name = $name;
                $param_address = $address;
                $param_salary = $salary;
                $param_profile_picture = $profile_picture;
                
                
                if($stmt->execute()){
                    // Success, redirect ke dashboard
                    header("location: index.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            unset($stmt);
        }
        
        // Close conns
        unset($pdo);
    }
?>


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-5">Add Pegawai</h2>
                    <p>Mohon isi form ini dan submit untuk menambahkan pegawai ke database</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" method="post">
                        <div class="form-group mt-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label>Gaji</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="formFile" class="form-label">Upload Profile Picture</label>
                            <input class="form-control" name="profile" id="profile" type="file" accept=".jpeg, .jpg, .png" id="formFile" aria-describedby="profileHelp">
                            <div id="profileHelp" class="form-text">Hanya menerima file dengan format (.JPG, .JPEG, .PNG)</div>
                        </div>
                        <input type="submit" class="mt-4 me-2 btn btn-primary" value="Submit">
                        <a href="index.php" class="mt-4 btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>

<?php require_once './layouts/footer.php' ?>