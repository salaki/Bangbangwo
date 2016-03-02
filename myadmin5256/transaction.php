<?php
include_once "include/config.php";
session_start();
ob_start();
if (!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '') {
    header('location:login.php');
}
include_once "include/header.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = mysql_query("select * from transaction_details ORDER BY id DESC ");
                            if (mysql_num_rows($data) > 0) {
                                while ($sresult = mysql_fetch_array($data)) {
                                    ?>
                                    <tr>
                                        <td class="centerNew"><?php echo $sresult['price']; ?></td>
                                        <td class="centerNew"><?php echo $sresult['date']; ?></td>
                                        <td class="centerNew"><?php echo $sresult['status']; ?></td>
                                    </tr>
        <?php
    }
} else {
    ?>
                                <tr>
                                    <td class="centerNew"><?php echo 'No Transaction'; ?></td>

                                </tr>
                                <?php
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "include/footer.php";
?>
