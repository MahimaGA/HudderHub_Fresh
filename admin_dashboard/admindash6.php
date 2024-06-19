<?php
include('admin_header.php')
?>
<!doctype html>
<html lang="en">
</body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="trader-profile">Manage Shop</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Shop Name</th>
                        <th scope="col">Shop Reg. Number</th>
                        <th scope="col">Shop Location</th>
                        <th scope="col">Shop Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION["user_id"];
                    if (!empty($user_id)) {
                        $counter = 1;
                        $query = "SELECT * FROM shop WHERE status = 0 OR status = 1";
                        $stid = oci_parse($connection, $query);

                        oci_execute($stid);

                        while (($row = oci_fetch_assoc($stid)) != false) {
                            $shop_id = $row["SHOP_ID"];
                            $shop_name = $row["SHOP_NAME"];
                            $location = $row["SHOP_LOCATION"];
                            $pan = $row["REGISTRATION_NO"];
                            $image = $row["SHOP_LOGO"];
                            $status = $row["STATUS"];

                    ?>
                            <tr>
                                <th scope="row"><?php echo $counter; ?></th>
                                <td><?php echo $shop_name; ?></td>
                                <td><?php echo $pan; ?></td>
                                <td><?php echo $location; ?></td>
                                <td><img src="../trader-dashboard/images/vendors/<?php echo $image; ?>" alt="" style="height:70px; width:70px;"></td>

                                <td>
                                    <a href="shop_update_form.php?id=<?php echo $shop_id; ?>">
                                        <button class="btn btn-default" style="display: inline-block; padding: 0px;" data-toggle="modal" data-target="#example">
                                            <img src="./images/edit.png" width="20" />
                                        </button>
                                    </a>
                                    <a href="delete_shop.php?id=<?php echo $shop_id; ?>">
                                        <button class="btn btn-default" style="display: inline-block; padding: 0px;">
                                            <img src="./images/delete.png" width="20" />
                                        </button>
                                    </a>
                                    <?php
                                    if ($status == '1') {
                                    ?>
                                        <a href="shop_status.php?id=<?php echo $shop_id; ?>&task=deactivate">
                                            <button class="btn btn-default" style="background-color:#FF6666; margin-left: 15px">Deactivate
                                            </button>
                                        </a>
                                    <?php } else { ?>
                                        <a href="shop_status.php?id=<?php echo $shop_id; ?>&task=activate">
                                            <button class="btn btn-default" style="background-color:#a8e4a0; margin-left: 15px">Activate
                                            </button>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>

                    <?php
                            $counter++;
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="error_message">
                <?php
                if (isset($_SESSION['update_message'])) {
                    echo $_SESSION['update_message'];
                    unset($_SESSION['update_message']);
                }
                ?>
            </div>

            <div class="error_message">
                <?php

                if (isset($_SESSION['empty_error'])) {
                    echo $_SESSION['empty_error'];
                    unset($_SESSION['empty_error']);
                }
                ?>
            </div>
            <style>
                .error_message {
                    color: green;
                    font-size: 20px;
                    text-align: left;
                    padding-top: 15px;

                }
            </style>

        </div>
    </div>
</div>

</div>
</div>
</div>


<script src="pickout.js"></script>
<script>
    pickout.to({
        el: '.pickout',
        search: true,
        txtBtnMultiple: 'CONFIRMAR SELECIONADAS'
    });


    pickout.updated('.country');
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });

    $(".image-box").click(function(event) {
        var previewImg = $(this).children("img");

        $(this)
            .siblings()
            .children("input")
            .trigger("click");

        $(this)
            .siblings()
            .children("input")
            .change(function() {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var urll = e.target.result;
                    $(previewImg).attr("src", urll);
                    previewImg.parent().css("background", "transparent");
                    previewImg.show();
                    previewImg.siblings("p").hide();
                };
                reader.readAsDataURL(this.files[0]);
            });
    });
</script>
</body>

</html>