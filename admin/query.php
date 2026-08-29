<?php
  $admid = $_SESSION['admin'];
?>
<div class="container p-3 my-3 topb cont">

</div>
<div class="modal" id="category">
  <div class="modal-dialog modal-dialog-scrollable mod-sz que">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title">Answer</h1>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
        <form name="form" id="answerForm" method="POST" enctype="multipart/form-data" style="width: auto;">
          <div class="form-flex" style="width: 100%;">

            <div class="form-group fo-pa aprod">
                <label class="font-weight-bold text-dark">Question:</label>
                <input type="text" id="questionField" class="form-control" disabled>
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


<div class="container py-5 cont prodt">
  <table class="table table-striped usr-table">
    <thead>
      <tr>
        <th>Sr. No</th>
        <th>User Name</th>
        <th>Product Name</th>
        <th>Query</th>
        <th></th>
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['madmin'])) { ?>
        <th>Assigned To: </th>
        <?php } ?>
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['madmin'])) { ?>
        <th>Assign</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
    <?php
      $c = 1;
      $admid = $_SESSION['admid'];
        // echo $c;
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['madmin'])) {
        $stmt = $conn->prepare("select * from `questions`");
      }
      else {
        $stmt = $conn->prepare("select * from `questions` where atype='all' or atype = ?");
        $stmt->bind_param("s", $admid);
      }
      $stmt->execute();
      $results = $stmt->get_result();
      while ($row = $results->fetch_assoc())
      {
        // $uid = $row['uid'];
        $ccid = $row['ccid'];
        $atype = $row['atype'];
        $quest = substr($row['quest'], 0, 200) . '...' ;
        $que = $row['quest'];
        $qdate = $row['qdate'];
        $uid = $row['uid'];
        $qid = $row['qid'];
        $ans = $row['ans'];

        if ($ans == NULL) {
            $stat = 0;
        }
        else {
            $stat = 1;
        }

        if ($atype == 'all') {
            $name = 'All';
        }
        else {
            $stmt45 = $conn->prepare("select * from `admin` where astat='admin' and admid=?");
            $stmt45->bind_param("s", $atype);
            $stmt45->execute();
            $result45 = $stmt45->get_result();
            while ($row45 = $result45->fetch_assoc())
            {
                $name = $row45['name'];
                // echo '<a href="update.php?q=assign&admid='.$admid.'&type=quest&qid='.$qid.'" class="dropdown-item usr-drp">'.$row45['name'].'</a>';
            }
        }

        // $uid = $row['uid'];
        

        
        $stmt1 = $conn->prepare("select * from `product` where ccid = ?");
        $stmt1->bind_param("s", $ccid);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        // echo $date1;
        while ($row1 = $result1->fetch_assoc())
        {
            $pname = $row1['pname'];
            $color = $row1['color'];
        }

        $stmt2 = $conn->prepare("SELECT * FROM `user` WHERE uid = ?");
        $stmt2->bind_param("s", $uid);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        while ($row2 = $result2->fetch_assoc()) {
            $user = $row2['username'];
        }
      ?>
      <tr>
      <td><?php echo $c; ?></td>
      <td><?php echo $user; ?></td>
      <td><a href="index.php?q=1&step=1&ccid=<?php echo $ccid; ?>"><?php echo $pname.'_'.$color; ?><a></td>
      <td><?php echo $quest; ?></td>
      <?php
        if ($_SESSION['type'] == 'Viewer') {
          if ($stat == 0) {
              echo '<td><a class="btn answer-btn" style="background:#f8010d; color: #fff; text-decoration: none; width: 150px; padding: 5px; font-size: 15px;">Not Authorized</a></td>';
          }
          else {
              echo '<td><a class="btn" style="margin: 0px; background:#f8010d; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 15px;">Already Answered</a></td>';
          }
        }
        else {
          if ($stat == 0) {
            echo '<td><a class="btn answer-btn" style="background:#f8010d; color: #fff; text-decoration: none; width: 150px; padding: 5px; font-size: 15px;" data-toggle="modal" data-target="#category" data-qid="' . $qid . '" data-quest="' . htmlspecialchars($row['quest'], ENT_QUOTES) . '">Answer The Query</a></td>';
          }
          else {
            echo '<td><a class="btn" style="margin: 0px; background:#f8010d; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 15px;">Already Answered</a></td>';
          }
        }
      ?>
      <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['madmin'])) { ?>
        <td><?php echo $name; ?></td>
        <td>
            <div class="dropdown">
              <button type="button" class="btn btn-primary dropdown-toggle usr-drp" data-toggle="dropdown">
                User Info
              </button>
              <div class="dropdown-menu">
              <a href="update.php?q=assign&admid=All&type=quest&qid=<?php echo $qid; ?>" class="dropdown-item usr-drp">All</a>
                <?php
                    $stmt34 = $conn->prepare("select * from `admin` where astat='admin'");
                    // $stmt34->bind_param("s", $ccid);
                    $stmt34->execute();
                    $result34 = $stmt34->get_result();
                    // echo $date1;
                    while ($row1 = $result34->fetch_assoc())
                    {
                        $admid = $row1['admid'];
                        echo '<a href="update.php?q=assign&admid='.$admid.'&type=quest&qid='.$qid.'" class="dropdown-item usr-drp">'.$row1['name'].'</a>';
                    }
                ?>
              </div>
            </div>
          </td>
      <?php } ?>
      </tr>
      
      <?php
        $c++;
      }
      ?>
    </tbody>
  </table>
</div>

<?php

// $productId = 1;

// $stmt = $conn->prepare("SELECT * FROM produts WHERE serial_no = ?");
// $stmt->bind_param("i", $productId);
// $stmt->execute();
// $result = $stmt->get_result();

// // Check if a product exists
// if ($result->num_rows > 0) {
//     $product = $result->fetch_assoc();

//     $image = $product['image'];
//     $imageName = $product['iname'];

//     echo '<img src="data:image/jpg;base64,' . base64_encode($image) . '" style="display: inline-block; margin-left: auto; margin-right: auto;" />';

// } else {
//     echo "Product not found.";
// }



?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->


<script>
document.addEventListener('DOMContentLoaded', function () {
  const answerButtons = document.querySelectorAll('.answer-btn');
  const form = document.getElementById('answerForm');
  const questionField = document.getElementById('questionField');
  const qidDisplay = document.getElementById('qidDisplay');

  answerButtons.forEach(button => {
    button.addEventListener('click', function () {
      const qid = this.getAttribute('data-qid');
      const questText = this.getAttribute('data-quest');

      form.setAttribute('action', 'update.php?q=ansque&qid=' + qid);
      if (questionField) questionField.value = questText;
      if (qidDisplay) qidDisplay.textContent = qid;
    });
  });
});
</script>

