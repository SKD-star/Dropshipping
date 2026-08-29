<div class="container p-3 my-3 topb cont">
<?php
  if ($_SESSION['type'] == 'Viewer') {
    echo '<a class="btn btn-light cs-bt">Add Category</a>';
  }
  else {
?>
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#faq">Add Frequently Asked Questions</a>
<?php } ?>
</div>

<div class="modal" id="faq">
  <div class="modal-dialog modal-dialog-scrollable mod-sz que">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title">Answer</h1>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
        <form name="form" action="update.php?q=addfaq" method="POST" enctype="multipart/form-data" style="width: auto;">
          <div class="form-flex" style="width: 100%;">

            <div class="form-group fo-pa aprod">
                <label class="font-weight-bold text-dark">Question:</label>
                <input type="text" name="question" id="question" placeholder="Enter The Question" class="form-control" required>
            </div>
            <div class="form-group fo-pa aprod">
              <label for="name" class="font-weight-bold text-dark">Answer:</label>
              <textarea name="answer" id="answer" placeholder="Enter The Answer" style="height: 200px !important;" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <input class="btn btn-light cs-bt" type="submit" value="Submit" />
            <button type="button" class="btn btn-danger cs-bt" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("select * from `faq`");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc())
    {
      $qid = $row['qid'];
      $quest = $row['quest'];
      $admid = $row['admid'];
      $ans = $row['ans'];
      $date = $row['date'];
    }
?>
<div class="modal" id="editq" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable mod-sz que">
    <div class="modal-content">

    <div class="modal-header">
        <h1 class="modal-title">Answer</h1>
        <a href="index.php?q=5&step=4" class="close">×</a>
      </div>

      <div class="modal-body">
        <form name="form" action="update.php?q=upfaq&qid=<?php echo $qid; ?>" method="POST" enctype="multipart/form-data" style="width: auto;">
          <div class="form-flex" style="width: 100%;">

            <div class="form-group fo-pa aprod">
                <label class="font-weight-bold text-dark">Question:</label>
                <input type="text" name="question" id="question" value="<?php echo $quest; ?>" placeholder="Enter The Question" class="form-control" required
                <?php
                    if (isset($_GET['edit']) && isset($_GET['edited'])) {
                    }
                    else {
                        echo 'disabled';
                    }
                ?>>
            </div>
            <div class="form-group fo-pa aprod">
              <label for="name" class="font-weight-bold text-dark">Answer:</label>
              <textarea name="answer" id="answer" value="" placeholder="Enter The Answer" style="height: 200px !important;" required
              <?php
                    if (isset($_GET['edit']) && isset($_GET['edited'])) {
                    }
                    else {
                        echo 'disabled';
                    }
                ?>><?php echo $ans; ?></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <?php
                if (isset($_GET['edit']) && isset($_GET['edited'])) {
            ?>          
            <input class="btn btn-light cs-bt" type="submit" value="Submit" />
            <?php
                }
                else {
                    echo '<td><a href="index.php?q=5&step=4&edit='.$qid.'&edited=true" class="btn" style="margin: 0px; background: #0164f8; color: #fff; text-decoration: none; padding: 10px; font-size: 15px;">Edit Question</a></td>';
                }
            ?>
            <!-- <button type="button" class="btn btn-danger cs-bt" data-dismiss="modal">Close</button> -->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
}
?>

<div class="container py-5 cont prodt">
  <table class="table table-striped usr-table">
    <thead>
      <tr>
        <th>Sr. No</th>
        <th>Questions</th>
        <th>Answer</th>
        <th>Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $c = 1;
      $admid = $_SESSION['admid'];
      $stmt = $conn->prepare("select * from `faq`");
      $stmt->execute();
      $results = $stmt->get_result();
      while ($row = $results->fetch_assoc())
      {
        $qid = $row['qid'];
        $quest = $row['quest'];
        $admid = $row['admid'];
        $ans = substr($row['ans'], 0, 200) . '...' ;
        $date = $row['date'];

        $stmt45 = $conn->prepare("select * from `admin` where astat='admin' and admid=?");
        $stmt45->bind_param("s", $admid);
        $stmt45->execute();
        $result45 = $stmt45->get_result();
        while ($row45 = $result45->fetch_assoc())
        {
            $name = $row45['name'];
        }
      ?>
      <tr>
      <td><?php echo $c; ?></td>
      <td><?php echo $quest; ?></td>
      <td><a href=""><?php echo $ans; ?><a></td>
      <td><?php echo $date; ?></td>
      <?php
        if ($_SESSION['type'] == 'Viewer') {
            echo '<td></td>';
        }
        else {
            echo '<td><a href="index.php?q=5&step=4&edit='.$qid.'" class="btn" style="margin: 0px; background: #f83c01; color: #fff; text-decoration: none; padding: 10px; font-size: 15px; width: 140px;">View Question</a></td>';
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

