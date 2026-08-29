<div class="container p-3 my-3 topb cont">
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#category">Add Promotion Tab</a>
</div>

<div class="modal" id="category">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 80%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Promotion Tabs</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=addpromo" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Name / Descp</label>
                        <input type="text" name="prnm" id="prnm" autocomplete="off" placeholder="Enter Promotion Name" required>
                    </div>
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Promotion Image</label>
                        <input type="file" name="image1" placeholder="Choose Image 1" class="form-control my-2" accept=".jpg,.jpeg,.png" required="true" autocomplete="off">
                        <input type="text" name="link1" id="link1" autocomplete="off" placeholder="Enter Promotional Link" required>
                    </div>

                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Promotion Image</label>
                        <input type="file" name="image2" placeholder="Choose Image 2" class="form-control my-2" accept=".jpg,.jpeg,.png" required="true" autocomplete="off">
                        <input type="text" name="link2" id="link2" autocomplete="off" placeholder="Enter Promotional Link" required>
                    </div>

                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Promotion Image</label>
                        <input type="file" name="image3" placeholder="Choose Image 3" class="form-control my-2" accept=".jpg,.jpeg,.png" required="true" autocomplete="off">
                        <input type="text" name="link3" id="link3" autocomplete="off" placeholder="Enter Promotional Link" required>
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
      <th>Name</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $c = 1;
    $stmt = $conn->prepare("SELECT * FROM `promo` group by prmoid");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
        $admid = $row['admid'];
        $prmoid = $row['prmoid'];
        $date = $row['date'];
        $pstat = $row['pstat'];
        $pronm = $row['pronm'];

    ?>
    <tr>
        <td><?php echo $c; ?></td>
        <td><?php echo $admid; ?></td>
        <td><?php echo $pronm; ?></td>
        <td><?php echo $date; ?></td>
        <?php
        if ($pstat == 0) {
            echo '<td><a href="update.php?q=prmon&prmoid='.$prmoid.'" class="btn" style="margin: 0px; background: #f83c01; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">On</a></td>';
        }
        else {
            echo '<td><a href="update.php?q=prmoff&prmoid='.$prmoid.'" class="btn" style="margin: 0px; background: #0162f8; color: #fff; text-decoration: none; width: 90px; padding: 5px; font-size: 20px;">Off</a></td>';
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