<?php
    $title = 'Delete Pegawai';
    require_once './layouts/header.php';

    // delete data
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        // Include conss file
        require_once "./db/cons.php";
        
        
        $sql = "DELETE FROM pegawai WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            
            $stmt->bindParam(":id", $param_id);
            
        
            $param_id = trim($_POST["id"]);
            
            
            if($stmt->execute()){
                // delete success, redirect ke dashboard
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    } else{
        // check id
        if(empty(trim($_GET["id"]))){
            // id tidak ada, redirect ke error
            header("location: error.php");
            exit();
        }
    }
?>


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Pegawai</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Anda yakin ingin mendelete data pegawai?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>

<?php require_once './layouts/footer.php' ?>