<div class="container p-3 my-3 topb cont">
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#product">Add Slider Group</a>
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#category">Add Slider</a>
</div>


<div class="modal" id="product">
  <div class="modal-dialog modal-dialog-scrollable mod-sz"  style="width: 50%;">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title">Add Products</h1>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
        <form name="form" action="update.php?q=addslg" method="POST" enctype="multipart/form-data" style="width: auto;">
            <div class="form-flex" style="width: 100%;">

                <div class="form-group fo-pa aprod">
                <label for="name" class="font-weight-bold text-dark">Announcement Slider Name</label>
                <input type="text" name="sldnm" id="sldnm" autocomplete="off" placeholder="Enter Announcement Slider Name" required>
                </div>
                <div class="form-group fo-pa aprod">
                <label for="name" class="font-weight-bold text-dark">Announcement Description Short</label>
                <input type="text" name="descp" id="descp" autocomplete="off" placeholder="Enter Announcement Description Short" required>
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

<div class="modal" id="category">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 80%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Category</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=addsld" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Slider Types</label>
                        <select id="type" name="type" required="">
                          <option value="Select" style="background:#fff;color:#000;font-size:16px;">Types of Slider</option>
                          <?php
        
                            $get_category = "select * from sliders";
                            $run_category = mysqli_query($con, $get_category);
        
                            while ($cat_row = mysqli_fetch_array($run_category)) {
        
                                $sldid = $cat_row['sldid'];
                                $sldnm = $cat_row['sldnm'];
                                echo '<option value="'.$sldid.'" style="background:#fff;color:#000;font-size:16px;" >'.$sldnm.'</option>';
                              }
                              ?>
                        </select>
                    </div>
                    <div class="form-group fo-pa aprod">
                        <label for="iamg" class="font-weight-bold text-dark">Images</label>
                        <input type="number" min="0" name="iamg" id="iamg" autocomplete="off" placeholder="Enter No.of Images In Slider" required="" onchange="generateImageInputs()">
                        <div id="image-inputs"></div>
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


<div class="container py-5 cont prodt">
  <table class="table table-striped usr-table">
    <thead>
      <tr>
        <th>Sr. No</th>
        <th>Created By</th>
        <th>Slider Name</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $c = 1;
      $stmt = $conn->prepare("SELECT * FROM `sliders`");
      $stmt->execute();
      $results = $stmt->get_result();
      while ($row = $results->fetch_assoc()) {
          $admid = $row['admid'];
          $sldid = $row['sldid'];
          $sldnm = $row['sldnm'];
          $descp = $row['descp'];
          $date = $row['date'];
          $sstat = $row['sstat'];

      ?>
      <tr>
          <td><?php echo $c; ?></td>
          <td><?php echo $admid; ?></td>
          <td><?php echo $sldnm; ?></td>
          <td><?php echo $descp; ?></td>
          <td><?php echo $date; ?></td>
          <?php
          if ($sstat == 0) {
              echo '<td><a href="update.php?q=sldon&sldid='.$sldid.'" class="btn" style="margin: 0px; background: #f83c01; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">On</a></td>';
          }
          else {
              echo '<td><a href="update.php?q=sldoff&sldid='.$sldid.'" class="btn" style="margin: 0px; background: #0162f8; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">Off</a></td>';
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
function generateImageInputs() {
    var imageinputs = document.getElementById("iamg").value;
    var colorInputContainer = document.getElementById("image-inputs");


    colorInputContainer.innerHTML = '';

    for (var i = 1; i <= imageinputs; i++) {
        var inputWrapper = document.createElement("div");
        inputWrapper.classList.add("input-pair");
        inputWrapper.classList.add("szimg-bx");
        
        var inputWrapper1 = document.createElement("div");
        inputWrapper1.classList.add("input-flex-pair");
        
        var iginp = document.createElement("div");
        iginp.setAttribute("id", "text-inputs" + i);

        // inputWrapper.classList.add("szimg-bx");

        var inputField = document.createElement("input");
        inputField.type = "file";
        inputField.name = "image_" + i;
        inputField.placeholder = "Choose Image " + i;
        inputField.classList.add("form-control");
        inputField.classList.add("my-2");
        inputField.accept = ".jpg,.jpeg,.png";
        inputField.setAttribute("required", "true");
        inputField.setAttribute("autocomplete", "off");

        var inputField1 = document.createElement("input");
        inputField1.type = "text";
        inputField1.name = "iname_" + i;
        inputField1.placeholder = "Enter Image Name " + i;
        inputField1.classList.add("form-control");
        inputField1.classList.add("my-2");
        inputField1.setAttribute("required", "true");
        inputField1.setAttribute("autocomplete", "off");

        var labels = document.createElement("label");
        labels.setAttribute("for", "igtxt" + i);
        labels.classList.add("font-weight-bold", "text-dark");
        labels.textContent = "Image for " + i + " Text";

        var inputField4 = document.createElement("input");
        inputField4.type = "number";
        inputField4.min = "1";
        inputField4.name = "igtxt" + i;
        inputField4.id = "igtxt" + i;
        inputField4.autocomplete = "off";
        inputField4.placeholder = "Enter No.of Text on Images " + i;
        inputField4.required = true;
        inputField4.setAttribute("onchange", "generateigtext(" + i + ")");
        inputField4.setAttribute("required", "true");
        inputField4.setAttribute("autocomplete", "off");

        var inputField3 = document.createElement("input");
        inputField3.type = "text";
        inputField3.name = "link_" + i;
        inputField3.placeholder = "Enter Link for " + i + " Image";
        inputField3.classList.add("form-control");
        inputField3.classList.add("my-2");
        inputField3.setAttribute("autocomplete", "off");

        var selectField = document.createElement("select");
        selectField.name = "select_" + i;
        selectField.classList.add("form-control");
        selectField.classList.add("my-2");

        var defaultOption = document.createElement("option");
        defaultOption.value = "Right";
        defaultOption.textContent = "Align Text";
        selectField.appendChild(defaultOption);

        var options = ["Right", "Left", "Centre"];
        options.forEach(function(optionText) {
            var option = document.createElement("option");
            option.value = optionText.toLowerCase().replace(" ", "_");
            option.textContent = optionText;
            selectField.appendChild(option);
        });

        
        
        inputWrapper.appendChild(labels);
        inputWrapper.appendChild(inputField4);
        inputWrapper.appendChild(iginp);
        
        inputWrapper.appendChild(inputWrapper1);
        // inputWrapper1.appendChild(inputField2);
        inputWrapper1.appendChild(selectField);
        
        inputWrapper.appendChild(inputField1);
        inputWrapper.appendChild(inputField);
        
        inputWrapper.appendChild(inputField3);
        
        colorInputContainer.appendChild(inputWrapper);
        colorInputContainer.appendChild(document.createElement("br"));
    }
}



function generateigtext(igind) {
    var textinp = document.getElementById("igtxt" + igind).value;
    var textinpcont = document.getElementById("text-inputs" + igind);

    textinpcont.innerHTML = '';

    for (var i = 1; i <= textinp; i++) {
      var inputWrapper = document.createElement("div");
        inputWrapper.classList.add("input-flex-pair");

        var inputField = document.createElement("input");
        inputField.type = "text";
        inputField.name = "igtext" + igind + "_" + i;
        inputField.placeholder = "Enter Text on Image " + i;
        inputField.classList.add("form-control");
        inputField.classList.add("my-2");
        inputField.setAttribute("autocomplete", "off");

        var inputField2 = document.createElement("input");
        inputField2.type = "text";
        inputField2.name = "textsz" + igind + "_" + i;
        inputField2.placeholder = "Enter Text Size " + i;
        inputField2.classList.add("form-control");
        inputField2.classList.add("my-2");
        inputField2.setAttribute("autocomplete", "off");
        
        var inputField1 = document.createElement("input");
        inputField1.type = "color";
        inputField1.name = "ccode" + igind + "_" + i;
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