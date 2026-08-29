<div class="container p-3 my-3 topb cont">
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#discount">Add Discount Code</a>
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#imdisc">Add Discount Image on Shop Page</a>
</div>

<div class="modal" id="imdisc">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 80%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Discount Image</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=disimg" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Name / Descp</label>
                        <input type="text" name="disnm" id="disnm" autocomplete="off" placeholder="Enter Promotion Name" required>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Discount Code</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Discount Code</option>
                        <?php
                          $get_category = "select * from discount";
                          $run_category = mysqli_query($con, $get_category);
      
                          while ($cat_row = mysqli_fetch_array($run_category)) {
      
                            $utype = $cat_row['utype'];
                            $descp = $cat_row['descp'];
                            $code = $cat_row['code'];
                            $discid = $cat_row['discid'];
                            
                            echo '<option value="'.$discid.'" style="background:#fff;color:#000;font-size:16px;" >'.$code.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Discount Image</label>
                      <input type="file" name="image" placeholder="Choose Image 1" class="form-control my-2" accept=".jpg,.jpeg,.png" required="true" autocomplete="off">
                      <input type="text" name="link" id="link" autocomplete="off" placeholder="Enter Promotional Link" required>
                      <label for="type" class="font-weight-300 text-dark">Size of Image Should be 1375 X 409</label>
                    </div>

                    <div class="form-group aprod">
                      <label for="igtxt" class="font-weight-bold text-dark">Text on Image</label>
                      <input type="number" min="1" max="3" name="igtxt" id="igtxt" autocomplete="off" placeholder="Enter No.of Text on Images" required="true" onchange="generateigtext()">
                      <select name="select" class="form-control my-2">
                        <option value="Right">Align Text</option>
                        <option value="right">Right</option>
                        <option value="left">Left</option>
                        <option value="centre">Centre</option>
                      </select>
                      <div id="text-inputs"></div>
                    </div>
                </div>
              <div class="modal-footer">
                <input class="btn btn-light cs-bt" type="submit" value="Submit">
                <button type="button" class="btn btn-danger cs-bt" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
    </div>
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
      <th>Page</th>
      <th>Description</th>
      <th>Code</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $c = 1;
    $stmt = $conn->prepare("SELECT * FROM `disimg`");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
        $admid = $row['admid'];
        $discid = $row['discid'];
        $disimd = $row['disimd'];
        $date = $row['date'];
        $stat = $row['stat'];
        $pgname = $row['pgname'];
        $link = $row['link'];
        $descp = $row['descp'];
        
        $query1 = "SELECT * FROM admin where admid='$admid'";
        $result = mysqli_query($conn, $query1);
        while ($row1 = mysqli_fetch_array($result)) {
          $name = $row1['name'];
        }
        
        $query2 = "SELECT * FROM discount where discid='$discid'";
        $result2 = mysqli_query($conn, $query2);
        
        while ($row2 = mysqli_fetch_array($result2)) {
          $code = $row2['code'];
          $utype = $row2['utype'];
          $dstat = $row2['dstat'];
        }

    ?>
    <tr>
        <td><?php echo $c; ?></td>
        <td><?php echo $name; ?></td>
        <td><?php echo $pgname; ?></td>
        <td><?php echo $descp; ?></td>
        <td><?php echo $code; ?></td>
        <td><?php echo $date; ?></td>
        <?php
        if ($dstat == 0) {
          echo '<td><a title="The Assigned Discount Coupon Code is Off Turn On that First." class="btn" style="margin: 0px; background: #f83c01; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">On</a></td>';
        }
        else {
            if($stat == 0){
            echo '<td><a href="update.php?q=dimon&disimd='.$disimd.'" class="btn" style="margin: 0px; background: #f83c01; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">On</a></td>';
          }
          else {
              echo '<td><a href="update.php?q=dimoff&disimd='.$disimd.'" class="btn" style="margin: 0px; background: #0162f8; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">Off</a></td>';
          }
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<script src="tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>
<script>
function generateigtext() {
    var textinp = document.getElementById("igtxt").value;
    var textinpcont = document.getElementById("text-inputs");

    textinpcont.innerHTML = '';

    for (var i = 1; i <= textinp; i++) {
      var inputWrapper = document.createElement("div");
        inputWrapper.classList.add("input-flex-pair");

        var inputField = document.createElement("input");
        inputField.type = "text";
        inputField.name = "igtext" + i;
        inputField.placeholder = "Enter Text on Image " + i;
        inputField.classList.add("form-control");
        inputField.classList.add("my-2");
        inputField.setAttribute("autocomplete", "off");

        var inputField2 = document.createElement("input");
        inputField2.type = "text";
        inputField2.name = "textsz" + i;
        inputField2.placeholder = "Enter Text Size " + i;
        inputField2.classList.add("form-control");
        inputField2.classList.add("my-2");
        inputField2.setAttribute("autocomplete", "off");
        
        var inputField1 = document.createElement("input");
        inputField1.type = "color";
        inputField1.name = "ccode" + i;
        inputField1.value = "#000000";
        inputField1.classList.add("form-control");
        inputField1.classList.add("my-2");

        // var inputField = document.createElement("input");
        // inputField.type = "number";
        // inputField.name = "size" + igind + "_" + i;
        // inputField.placeholder = "Enter Size " + i;
        // inputField.classList.add("form-control");
        // inputField.classList.add("my-2");
        // inputField.setAttribute("required", "true");
        // inputField.setAttribute("autocomplete", "off");

        // var inputField1 = document.createElement("input");
        // inputField1.type = "number";
        // inputField1.name = "qty" + igind + "_" + i;
        // inputField1.placeholder = "Enter Quantity " + i;
        // inputField1.classList.add("form-control");
        // inputField1.classList.add("my-2");
        // inputField1.setAttribute("required", "true");
        // inputField1.setAttribute("autocomplete", "off");

        inputWrapper.appendChild(inputField);
        inputWrapper.appendChild(inputField2);
        inputWrapper.appendChild(inputField1);

        textinpcont.appendChild(inputWrapper);
        textinpcont.appendChild(document.createElement("br"));
    }
}
</script>