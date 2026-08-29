<?php
$get_category = "SELECT * FROM product";
$run_category = mysqli_query($con, $get_category);

$discounts = [];
while ($cat_row = mysqli_fetch_assoc($run_category)) {
  $pname = $cat_row['pname'].'_'.$cat_row['color'];

  $discounts[] = [
    'value' => $cat_row['ccid'],
    'name' => $pname
  ];
}

$get_ct = "SELECT * FROM product group by category";
$run_ct = mysqli_query($con, $get_ct);

$catgs = [];
while ($cat_row = mysqli_fetch_assoc($run_ct)) {
  $catg = $cat_row['category'];

  $q12 = "SELECT * FROM `catgory` where ctid='$catg'";
  $res = mysqli_query($conn, $q12);        
  while ($row123 = mysqli_fetch_array($res))
  {
    $catgs[] = [
      'value' => $cat_row['category'],
      'name' => $row123['category']
    ];
  }
}

$query = "SELECT * FROM product group by keyword";
$run = mysqli_query($con, $query);

$tags = [];
while ($row = mysqli_fetch_assoc($run)) {
    $keyword = $row['keyword'];
    
    $tags[] = [
      'value' => $keyword,
      'name' => $keyword
    ];
}

$qury = "select * from catgory";
$run1 = mysqli_query($con, $qury);

$category = [];
while ($row1 = mysqli_fetch_array($run1)) {

    $ctid = $row1['ctid'];
    $catg = $row1['category'];
    
    $category[] = [
      'value' => $ctid,
      'name' => $catg
    ];
    // $sstat = $cat_row['sstat'];


    // echo '<option value="'.$catid.'" style="background:#fff;color:#000;font-size:16px;" >'.$category.'</option>';
  }
?>
<label for="type" class="font-weight-bold text-dark">Add in Side Bar</label>
<div class="container p-3 my-3 topb cont">
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#catg">Add List of Categories</a>
    <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#sleprod">Add Large Product Carousel</a>
    <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#lstprod">Add Product List Carousel</a>
    <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#prodtag">Add Product List Tag Carousel</a>
</div>
<label for="type" class="font-weight-bold text-dark">Add in Max Bar</label>
<div class="container p-3 my-3 topb cont">
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#slider">Add Slider</a>
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#rowprod">Add Product in Row Carousel</a>
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#promo">Add Promotion Images Tab</a>
  <a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#fcatg">Add Featured Categories Tab</a>
</div>
<a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#sidebar">Change Order of Functions in Side Bar</a>
<a target="_blank" class="btn btn-light cs-bt" data-toggle="modal" data-target="#maxbar">Change Order of Functions in Max Bar</a>

<!-- Side Bar Function Modal Start -->
<div class="modal" id="catg">
  <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title">Add Products in Carousel</h1>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
        <form name="form" action="update.php?q=selprod&type=catg" method="POST" enctype="multipart/form-data" style="width: auto;">
          <div class="form-flex" style="width: 100%;">
              
            <div class="form-group aprod">
              <label for="type" class="font-weight-bold text-dark">Title</label>
              <input type="text" name="title" id="title" autocomplete="off" placeholder="Enter Promotion Name" required>
            </div>
            <div class="form-group aprod">
            <label for="type" class="font-weight-bold text-dark">Descp</label>
              <textarea name="descp" id="descp" placeholder="Enter Short Description for future understanding" style="height: 120px !important;"></textarea>
            </div>
            <div class="form-group aprod">
              <label for="type" class="font-weight-bold text-dark">Page</label>
              <select id="type" name="type" required="">
                <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
              </select>
            </div>
            
            <div class="form-group aprod">
              <label for="lcatg" class="font-weight-bold text-dark">No. Of Product</label>
              <input type="number" min="1" name="lcatg" id="lcatg" autocomplete="off" placeholder="Enter No.of Product In The Carousel" required="true" onchange="generatecatg()">
              <div id="lcatg-inputs"></div>
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

<div class="modal" id="sleprod">
  <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title">Add Products in Carousel</h1>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
        <form name="form" action="update.php?q=selprod&type=lrgprod" method="POST" enctype="multipart/form-data" style="width: auto;">
          <div class="form-flex" style="width: 100%;">
              
            <div class="form-group aprod">
              <label for="type" class="font-weight-bold text-dark">Title</label>
              <input type="text" name="title" id="title" autocomplete="off" placeholder="Enter Promotion Name" required>
            </div>
            <div class="form-group aprod">
            <label for="type" class="font-weight-bold text-dark">Descp</label>
              <textarea name="descp" id="descp" placeholder="Enter Short Description for future understanding" style="height: 120px !important;"></textarea>
            </div>
            <div class="form-group aprod">
              <label for="type" class="font-weight-bold text-dark">Page</label>
              <select id="type" name="type" required="">
                <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
              </select>
            </div>
            
            <div class="form-group aprod">
              <label for="igtxt" class="font-weight-bold text-dark">No. Of Product</label>
              <input type="number" min="1" name="igtxt" id="igtxt" autocomplete="off" placeholder="Enter No.of Product In The Carousel" required="true" onchange="generateigtext()">
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

<div class="modal" id="lstprod">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=selprod&type=lstprod" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Title</label>
                        <input type="text" name="title" id="title" autocomplete="off" placeholder="Enter Promotion Name" required>
                    </div>
                    <div class="form-group aprod">
                    <label for="type" class="font-weight-bold text-dark">Descp</label>
                        <textarea name="descp" id="descp" placeholder="Enter Short Description for future understanding" style="height: 120px !important;"></textarea>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Page</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                      <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                      <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                      <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                      <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
                      </select>
                    </div>

                    <div class="form-group aprod">
                      <label for="list" class="font-weight-bold text-dark">No. Of Product</label>
                      <input type="number" min="1" name="list" id="list" autocomplete="off" placeholder="Enter No.of Product In The Carousel" required="true" onchange="lstprod()">
                      <div id="list-inputs"></div>
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

<div class="modal" id="prodtag">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=selprod&type=prodtag" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Title</label>
                        <input type="text" name="title" id="title" autocomplete="off" placeholder="Enter Promotion Name" required>
                    </div>
                    <div class="form-group aprod">
                    <label for="type" class="font-weight-bold text-dark">Descp</label>
                        <textarea name="descp" id="descp" placeholder="Enter Short Description for future understanding" style="height: 120px !important;"></textarea>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Page</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                      <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                      <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                      <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                      <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
                      </select>
                    </div>

                    <div class="form-group aprod">
                      <label for="tag" class="font-weight-bold text-dark">No. Of Product</label>
                      <input type="number" min="1" name="tag" id="tag" autocomplete="off" placeholder="Enter No.of Product In The Carousel" required="true" onchange="prodtag()">
                      <div id="tag-inputs"></div>
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
<!-- Side Bar Function Modal End -->

<!-- Max Bar Function Modal Start -->

<div class="modal" id="slider">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=slider" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">

                    <div class="form-group aprod">
                        <label for="slide" class="font-weight-bold text-dark">Page</label>
                        <select id="slide" name="slide" required="">
                          <option value="Select" style="background:#fff;color:#000;font-size:16px;">Types of Slider</option>
                          <?php
        
                            $get_category = "select * from sliders";
                            $run_category = mysqli_query($con, $get_category);
        
                            while ($cat_row = mysqli_fetch_array($run_category)) {
        
                                $sldid = $cat_row['sldid'];
                                $sldnm = $cat_row['sldnm'];
                                $sstat = $cat_row['sstat'];


                                if ($sstat == 1) {
                                    echo '<option value="'.$sldid.'" style="background:#fff;color:#000;font-size:16px;" >'.$sldnm.'</option>';
                                }
                                else {
                                    echo '<option value="'.$sldid.'" style="background:#fff;color:#000;font-size:16px;" disabled >'.$sldnm.'_Slider Off</option>';
                                }
                              }
                            ?>
                        </select>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Page</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                        <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                        <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                        <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                        <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
                      </select>
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

<div class="modal" id="rowprod">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 60%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Max Bar Row Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=maxprod&type=rowprod" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Title</label>
                        <input type="text" name="title" id="title" autocomplete="off" placeholder="Enter Promotion Name" required>
                    </div>
                    <div class="form-group aprod">
                    <label for="type" class="font-weight-bold text-dark">Descp</label>
                        <textarea name="descp" id="descp" placeholder="Enter Short Description for future understanding" style="height: 120px !important;"></textarea>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Page</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                      <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                      <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                      <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                      <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
                      </select>
                    </div>

                    <div class="form-group aprod">
                      <label for="row" class="font-weight-bold text-dark">No. Of Product</label>
                      <input type="number" min="1" name="row" id="row" autocomplete="off" placeholder="Enter No.of Product In The Carousel" required="true" onchange="rowprod()">
                      <div id="row-inputs"></div>
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

<div class="modal" id="promo">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=promo" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">

                    <div class="form-group aprod">
                        <label for="promo" class="font-weight-bold text-dark">Page</label>
                        <select id="promo" name="promo" required="">
                          <option value="Select" style="background:#fff;color:#000;font-size:16px;">Types of Slider</option>
                          <?php
        
                            $get_category = "SELECT * FROM `promo` group by prmoid";
                            $run_category = mysqli_query($con, $get_category);
        
                            while ($cat_row = mysqli_fetch_array($run_category)) {
        
                                $prmoid = $cat_row['prmoid'];
                                $pronm = $cat_row['pronm'];
                                $pstat = $cat_row['pstat'];


                                if ($pstat == 1) {
                                    echo '<option value="'.$prmoid.'" style="background:#fff;color:#000;font-size:16px;" >'.$pronm.'</option>';
                                }
                                else {
                                    echo '<option value="'.$prmoid.'" style="background:#fff;color:#000;font-size:16px;" disabled >'.$pronm.'_Slider Off</option>';
                                }
                              }
                            ?>
                        </select>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Page</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                        <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                        <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                        <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                        <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
                      </select>
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

<div class="modal" id="fcatg">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 40%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=fcatg" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Title</label>
                        <input type="text" name="title" id="title" autocomplete="off" placeholder="Enter Promotion Name" required>
                    </div>
                    <div class="form-group aprod">
                    <label for="type" class="font-weight-bold text-dark">Descp</label>
                        <textarea name="descp" id="descp" placeholder="Enter Short Description for future understanding" style="height: 120px !important;"></textarea>
                    </div>
                    <div class="form-group aprod">
                      <label for="type" class="font-weight-bold text-dark">Page</label>
                      <select id="type" name="type" required="">
                        <option value="INVALID" style="background:#fff;color:#000;font-size:16px;">Select Page Name</option>
                        <option value="680a1b1c76486" style="background:#fff;color:#000;font-size:16px;" >Home</option>
                        <option value="680a1b4d70cb2" style="background:#fff;color:#000;font-size:16px;" disabled>Category</option>
                        <option value="680a1b577c350" style="background:#fff;color:#000;font-size:16px;" disabled>Product Detail</option>
                        <option value="680a1b6459ef8" style="background:#fff;color:#000;font-size:16px;" disabled>Cart</option>
                      </select>
                    </div>
                    
                    <div class="form-group aprod">
                      <label for="catg" class="font-weight-bold text-dark">No. Of Categories</label>
                      <input type="number" min="1" name="catg" id="catg" autocomplete="off" placeholder="Enter No.of Product In The Carousel" required="true" onchange="fcatg()">
                      <div id="catg-inputs"></div>
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
<!-- Max Bar Function Modal End -->


<div class="modal" id="sidebar">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 80%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <?php include 'sidebar.php'; ?>
          </div>
        </div>
    </div>
</div>

<div class="modal" id="maxbar">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 80%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Products in Carousel</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <?php include 'maxbar.php'; ?>
          </div>
        </div>
    </div>
</div>


<script>
    function generatecatg() {
        var discountData = <?php echo json_encode($catgs); ?>;

        var textinp = document.getElementById("lcatg").value;
        var textinpcont = document.getElementById("lcatg-inputs");

        textinpcont.innerHTML = '';

        for (var i = 1; i <= textinp; i++) {
            // Create the select element
            var selectWrapper = document.createElement("div");
            selectWrapper.classList.add("form-group", "aprod");

            var label = document.createElement("label");
            label.setAttribute("for", "type");
            label.classList.add("font-weight-bold", "text-dark");
            label.innerText = "Select the Product No." + i;
            selectWrapper.appendChild(label);

            var selectElement = document.createElement("select");
            selectElement.id = "type" + i;
            selectElement.name = "type" + i;
            selectElement.required = true;
            
            var defaultOption = document.createElement("option");
            defaultOption.value = "INVALID";
            defaultOption.style.background = "#fff";
            defaultOption.style.color = "#000";
            defaultOption.style.fontSize = "16px";
            defaultOption.innerText = "Select Categories";
            selectElement.appendChild(defaultOption);

            discountData.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.value;
                option.style.background = "#fff";
                option.style.color = "#000";
                option.style.fontSize = "16px";
                option.innerText = item.name;
                selectElement.appendChild(option);
            });

            selectWrapper.appendChild(selectElement);
            textinpcont.appendChild(selectWrapper);
        }
    }
</script>

<script>
    function generateigtext() {
        var discountData = <?php echo json_encode($discounts); ?>;

        var textinp = document.getElementById("igtxt").value;
        var textinpcont = document.getElementById("text-inputs");

        textinpcont.innerHTML = '';

        for (var i = 1; i <= textinp; i++) {
            // Create the select element
            var selectWrapper = document.createElement("div");
            selectWrapper.classList.add("form-group", "aprod");

            var label = document.createElement("label");
            label.setAttribute("for", "type");
            label.classList.add("font-weight-bold", "text-dark");
            label.innerText = "Select the Product No." + i;
            selectWrapper.appendChild(label);

            var selectElement = document.createElement("select");
            selectElement.id = "type" + i;
            selectElement.name = "type" + i;
            selectElement.required = true;
            
            var defaultOption = document.createElement("option");
            defaultOption.value = "INVALID";
            defaultOption.style.background = "#fff";
            defaultOption.style.color = "#000";
            defaultOption.style.fontSize = "16px";
            defaultOption.innerText = "Select Page Name";
            selectElement.appendChild(defaultOption);

            discountData.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.value;
                option.style.background = "#fff";
                option.style.color = "#000";
                option.style.fontSize = "16px";
                option.innerText = item.name;
                selectElement.appendChild(option);
            });

            selectWrapper.appendChild(selectElement);
            textinpcont.appendChild(selectWrapper);
        }
    }
</script>

<script>
    function lstprod() {
        var discountData = <?php echo json_encode($discounts); ?>;

        var textinp = document.getElementById("list").value;
        var textinpcont = document.getElementById("list-inputs");

        textinpcont.innerHTML = '';

        for (var i = 1; i <= textinp; i++) {
            // Create the select element
            var selectWrapper = document.createElement("div");
            selectWrapper.classList.add("form-group", "aprod");

            var label = document.createElement("label");
            label.setAttribute("for", "type");
            label.classList.add("font-weight-bold", "text-dark");
            label.innerText = "Select the Product No." + i;
            selectWrapper.appendChild(label);

            var selectElement = document.createElement("select");
            selectElement.id = "type" + i;
            selectElement.name = "type" + i;
            selectElement.required = true;
            
            var defaultOption = document.createElement("option");
            defaultOption.value = "INVALID";
            defaultOption.style.background = "#fff";
            defaultOption.style.color = "#000";
            defaultOption.style.fontSize = "16px";
            defaultOption.innerText = "Select Page Name";
            selectElement.appendChild(defaultOption);

            discountData.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.value;
                option.style.background = "#fff";
                option.style.color = "#000";
                option.style.fontSize = "16px";
                option.innerText = item.name;
                selectElement.appendChild(option);
            });

            selectWrapper.appendChild(selectElement);
            textinpcont.appendChild(selectWrapper);
        }
    }
</script>

<script>
    function prodtag() {
        var tagData = <?php echo json_encode($tags); ?>;

        var textinp = document.getElementById("tag").value;
        var textinpcont = document.getElementById("tag-inputs");

        textinpcont.innerHTML = '';

        for (var i = 1; i <= textinp; i++) {
            // Create the select element
            var selectWrapper = document.createElement("div");
            selectWrapper.classList.add("form-group", "aprod");

            var label = document.createElement("label");
            label.setAttribute("for", "type");
            label.classList.add("font-weight-bold", "text-dark");
            label.innerText = "Select the Product No." + i;
            selectWrapper.appendChild(label);

            var selectElement = document.createElement("select");
            selectElement.id = "type" + i;
            selectElement.name = "type" + i;
            selectElement.required = true;
            
            var defaultOption = document.createElement("option");
            defaultOption.value = "INVALID";
            defaultOption.style.background = "#fff";
            defaultOption.style.color = "#000";
            defaultOption.style.fontSize = "16px";
            defaultOption.innerText = "Select Page Name";
            selectElement.appendChild(defaultOption);

            tagData.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.value;
                option.style.background = "#fff";
                option.style.color = "#000";
                option.style.fontSize = "16px";
                option.innerText = item.name;
                selectElement.appendChild(option);
            });

            selectWrapper.appendChild(selectElement);
            textinpcont.appendChild(selectWrapper);
        }
    }
</script>

<script>
    function rowprod() {
        var discountData = <?php echo json_encode($discounts); ?>;

        var textinp = document.getElementById("row").value;
        var textinpcont = document.getElementById("row-inputs");

        textinpcont.innerHTML = '';

        for (var i = 1; i <= textinp; i++) {
            // Create the select element
            var selectWrapper = document.createElement("div");
            selectWrapper.classList.add("form-group", "aprod");

            var label = document.createElement("label");
            label.setAttribute("for", "type");
            label.classList.add("font-weight-bold", "text-dark");
            label.innerText = "Select the Product No." + i;
            selectWrapper.appendChild(label);

            var selectElement = document.createElement("select");
            selectElement.id = "type" + i;
            selectElement.name = "type" + i;
            selectElement.required = true;
            
            var defaultOption = document.createElement("option");
            defaultOption.value = "INVALID";
            defaultOption.style.background = "#fff";
            defaultOption.style.color = "#000";
            defaultOption.style.fontSize = "16px";
            defaultOption.innerText = "Select Page Name";
            selectElement.appendChild(defaultOption);

            discountData.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.value;
                option.style.background = "#fff";
                option.style.color = "#000";
                option.style.fontSize = "16px";
                option.innerText = item.name;
                selectElement.appendChild(option);
            });

            selectWrapper.appendChild(selectElement);
            textinpcont.appendChild(selectWrapper);
        }
    }
</script>

<script>
    function fcatg() {
        var catgData = <?php echo json_encode($category); ?>;

        var textinp = document.getElementById("catg").value;
        var textinpcont = document.getElementById("catg-inputs");

        textinpcont.innerHTML = '';

        for (var i = 1; i <= textinp; i++) {
            // Create the select element
            var selectWrapper = document.createElement("div");
            selectWrapper.classList.add("form-group", "aprod");

            var label = document.createElement("label");
            label.setAttribute("for", "ctyp");
            label.classList.add("font-weight-bold", "text-dark");
            label.innerText = "Select the Product No." + i;
            selectWrapper.appendChild(label);

            var selectElement = document.createElement("select");
            selectElement.id = "ctyp" + i;
            selectElement.name = "ctyp" + i;
            selectElement.required = true;
            
            var defaultOption = document.createElement("option");
            defaultOption.value = "INVALID";
            defaultOption.style.background = "#fff";
            defaultOption.style.color = "#000";
            defaultOption.style.fontSize = "16px";
            defaultOption.innerText = "Select Categories";
            selectElement.appendChild(defaultOption);

            catgData.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.value;
                option.style.background = "#fff";
                option.style.color = "#000";
                option.style.fontSize = "16px";
                option.innerText = item.name;
                selectElement.appendChild(option);
            });

            selectWrapper.appendChild(selectElement);
            textinpcont.appendChild(selectWrapper);
        }
    }
</script>