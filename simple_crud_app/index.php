<?php
    $title = 'Dashboard';
    // Include header file
    require_once './layouts/header.php';
    // Include conns file
    require_once './db/cons.php';
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="float-start">Detail Pegawai</h2>
                        <a href="create.php" class="btn btn-success float-end"><i class="fa fa-plus"></i> Tambah Pegawai Baru</a>
                    </div>
                    <?php
                    $sql = "SELECT * FROM pegawai";
                    if($result = $pdo->query($sql)) { ?>
                        <?php if($result->rowCount() > 0) { ?>
                             <table class="table table-bordered table-striped">
                                 <thead>
                                     <tr>
                                         <th>ID</th>
                                         <th>Nama</th>
                                         <th>Alamat</th>
                                         <th>Gaji</th>
                                         <th>Profile Picture</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                <?php while($row = $result->fetch()) { ?>
                                    <div class="contents">
                                        <tr>
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['address'] ?></td>
                                            <td><?php echo $row['salary'] ?></td>
                                            <td><img class="profile-size rounded" src="<?php echo $row['profile_picture'] ?>" alt="<?php echo $row['name'] ?> Image"></td>
                                            <td>
                                                <a href="read.php?id=<?php echo $row['id'] ?>" class="me-3" title="View Data" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
                                                <a href="update.php?id=<?php echo $row['id'] ?>" class="me-3" title="Edit Data" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                                <a href="delete.php?id=<?php echo $row['id'] ?>" title="Delete Data" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    </div>
                                <?php } ?>
                                </tbody>                           
                             </table>

                            
                            <?php unset($result); 
                        } else{
                            echo "<div class='alert alert-danger'><em>No records were found.</em></div>";
                        } ?>
                    <?php }   else { 
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                        // Close conns
                        unset($pdo);
                    ?>
                    
                    
                </div>
            </div>        
        </div>
    </div>

<?php require_once './layouts/footer.php' ?>