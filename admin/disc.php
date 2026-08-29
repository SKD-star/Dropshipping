<div class="modal" id="discount">
    <div class="modal-dialog modal-dialog-scrollable mod-sz" style="width: 80%;">
        <div class="modal-content">
    
          <div class="modal-header">
            <h1 class="modal-title">Add Discount Code</h1>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
    
          <div class="modal-body">
            <form name="form" action="update.php?q=addisc" method="POST" enctype="multipart/form-data" style="width: auto;">
                <div class="form-flex" style="width: 100%;">
                    
                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Name / Descp</label>
                        <input type="text" name="descp" id="descp" autocomplete="off" placeholder="Enter Discount Description" required>
                        <!-- <label for="type" class="font-weight-300 text-dark">Size of Image Should be 1375 X 409</label> -->
                    </div>

                    <div class="form-group aprod">
                        <label for="type" class="font-weight-bold text-dark">Discount Code</label>
                        <input type="text" name="disc" id="disc" autocomplete="off" placeholder="Enter Discount Code" required>
                        <label for="type" class="font-weight-300 text-dark">Adding the Discount would Apply to <b>ALL USERS</b></label>
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