<div class="container p-3 my-3 topb cont">
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#discount">Add Discount Code</a>
</div>
<?php
  include 'disc.php';
?>

<div class="container py-5 cont prodt">
<table class="table table-striped usr-table">
  <thead>
    <tr>
      <th>Sr. No</th>
      <th>Created By</th>
      <th>Description</th>
      <th>Code</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $c = 1;
    $stmt = $conn->prepare("SELECT * FROM `discount`");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
        $admid = $row['admid'];
        $discid = $row['discid'];
        $date = $row['date'];
        $dstat = $row['dstat'];
        $descp = $row['descp'];
        $code = $row['code'];
        $utype = $row['utype'];

        $query1 = "SELECT * FROM admin where admid='$admid'";
        $result = mysqli_query($conn, $query1);

        while ($row1 = mysqli_fetch_array($result)) {
            $name = $row1['name'];
        }

    ?>
    <tr>
        <td><?php echo $c; ?></td>
        <td><?php echo $name; ?></td>
        <td><?php echo $descp; ?></td>
        <td><?php echo $code; ?></td>
        <td><?php echo $date; ?></td>
        <?php
        if ($dstat == 0) {
            echo '<td><a href="update.php?q=dison&discid='.$discid.'" class="btn" style="margin: 0px; background: #f83c01; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">On</a></td>';
        }
        else {
            echo '<td><a href="update.php?q=disoff&discid='.$discid.'" class="btn" style="margin: 0px; background: #0162f8; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">Off</a></td>';
        }
        ?>
    </tr>
    <?php
      $c++;
    }
    ?>
  </tbody>
</table>

</div>