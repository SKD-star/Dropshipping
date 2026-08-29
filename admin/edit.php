<?php
require_once __DIR__ . '/layout_header.php';
?>

<div class="container-fluid py-4 cont">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="font-weight-bold text-dark mb-1"><i class="fas fa-user-shield text-primary mr-2"></i> Team Permissions &amp; Access Control</h3>
            <p class="text-muted mb-0 small">Manage administrator roles, assign permission tiers, and monitor access levels.</p>
        </div>
        <a href="index.php?q=9&step=1" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius:8px;">
            <i class="fas fa-user-plus mr-1"></i> Add New Admin
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius:14px; overflow:hidden; background:var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <span class="font-weight-bold" style="color:var(--text-primary);">
                <i class="fas fa-users-cog text-primary mr-1"></i> Active Administrators
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 usr-table">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Admin Name</th>
                            <th>Username</th>
                            <th>Account Type</th>
                            <th>Active Role / Permission</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $c = 1;
                    $stmt = $conn->prepare("SELECT * FROM `admin` ORDER BY id ASC");
                    if ($stmt) {
                        $stmt->execute();
                        $results = $stmt->get_result();
                        if ($results && $results->num_rows > 0) {
                            while ($row = $results->fetch_assoc()) {
                                $adid = $row['admid'];
                                $name = $row['name'] ?: 'Administrator';
                                $username = $row['username'];
                                $astat = $row['astat'] ?: 'admin';
                                $perm = $row['perm'] ?: 'Super Admin';
                                ?>
                                <tr>
                                    <td><strong><?= $c ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:50%;background:rgba(99,102,241,0.1);color:var(--brand);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.75rem;">
                                                <?= strtoupper(substr($name, 0, 2)) ?>
                                            </div>
                                            <strong><?= htmlspecialchars($name) ?></strong>
                                        </div>
                                    </td>
                                    <td><code>@<?= htmlspecialchars($username) ?></code></td>
                                    <td><span class="badge badge-light border"><?= htmlspecialchars(ucfirst($astat)) ?></span></td>
                                    <td><span class="badge badge-primary px-2 py-1"><?= htmlspecialchars($perm) ?></span></td>
                                    <td style="text-align:right;">
                                        <div class="dropdown d-inline-block">
                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle font-weight-bold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:6px;">
                                                <i class="fas fa-sliders-h mr-1"></i> Change Role
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right shadow">
                                                <a class="dropdown-item" href="update.php?q=perm&admid=<?= urlencode($adid) ?>&type=1"><i class="fas fa-eye text-muted mr-2"></i> Viewer</a>
                                                <a class="dropdown-item" href="update.php?q=perm&admid=<?= urlencode($adid) ?>&type=2"><i class="fas fa-box text-muted mr-2"></i> Product Manager</a>
                                                <a class="dropdown-item" href="update.php?q=perm&admid=<?= urlencode($adid) ?>&type=3"><i class="fas fa-users text-muted mr-2"></i> Customer Manager</a>
                                                <a class="dropdown-item" href="update.php?q=perm&admid=<?= urlencode($adid) ?>&type=4"><i class="fas fa-pen text-muted mr-2"></i> Blog Writer</a>
                                                <a class="dropdown-item" href="update.php?q=perm&admid=<?= urlencode($adid) ?>&type=5"><i class="fas fa-headset text-muted mr-2"></i> Tickets Manager</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center py-4 text-muted">No administrators found.</td></tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    iamgeflx.innerHTML = '';

    for (var i = 1; i <= colorsizes; i++) {
        var inputWrapper = document.createElement("div");
        
        var imagene = document.createElement("div");
        var imagscls = document.createElement("div");
        var imaginp = document.createElement("div");
        
        var siz = document.createElement("div");
        var sizinp = document.createElement("div");

        inputWrapper.classList.add("input-pair");

        imagene.classList.add("form-flex");
        imagene.classList.add("szimg");
        
        imagscls.classList.add("form-group");
        imagscls.classList.add("fo-pa");
        imagscls.classList.add("aprod");
        imagscls.classList.add("szimg-bx");
        imaginp.setAttribute("id", "image-inputs" + i);
        
        siz.classList.add("form-group");
        siz.classList.add("fo-pa");
        siz.classList.add("aprod");
        siz.classList.add("szimg-bx");
        sizinp.setAttribute("id", "size-inputs" + i);

        var inputField = document.createElement("input");
        inputField.type = "text";
        inputField.name = "cname" + i;
        inputField.placeholder = "Enter Color Name " + i;
        inputField.classList.add("form-control");
        inputField.classList.add("my-2");
        inputField.setAttribute("required", "true");
        inputField.setAttribute("autocomplete", "off");

        var inputField1 = document.createElement("input");
        inputField1.type = "color";
        inputField1.name = "ccode" + i;
        inputField1.value = "#000000";
        inputField1.classList.add("form-control");
        inputField1.classList.add("my-2");

        var label = document.createElement("label");
        label.setAttribute("for", "iamg" + i);
        label.classList.add("font-weight-bold", "text-dark");
        label.textContent = "Images";

        var inputField3 = document.createElement("input");
        inputField3.type = "number";
        inputField3.min = "0";
        inputField3.name = "iamg" + i;
        inputField3.id = "iamg" + i;
        inputField3.autocomplete = "off";
        inputField3.placeholder = "Enter your No.of Images for Color " + i;
        inputField3.required = true;
        inputField3.setAttribute("onchange", "generateImageInputs(" + i + ")");
        inputField3.setAttribute("required", "true");
        inputField3.setAttribute("autocomplete", "off");

        var labels = document.createElement("label");
        labels.setAttribute("for", "siz" + i);
        labels.classList.add("font-weight-bold", "text-dark");
        labels.textContent = "Sizes for " + i + " Color";

        var inputField4 = document.createElement("input");
        inputField4.type = "number";
        inputField4.min = "0";
        inputField4.name = "siz" + i;
        inputField4.id = "siz" + i;
        inputField4.autocomplete = "off";
        inputField4.placeholder = "Enter your No.of Images for Color " + i;
        inputField4.required = true;
        inputField4.setAttribute("onchange", "generateSizeeInputs(" + i + ")");
        inputField4.setAttribute("required", "true");
        inputField4.setAttribute("autocomplete", "off");

        inputWrapper.appendChild(inputField);
        inputWrapper.appendChild(inputField1);
        imagene.appendChild(imagscls);
        
        imagene.appendChild(siz);

        imagscls.appendChild(label);
        imagscls.appendChild(inputField3);
        imagscls.appendChild(imaginp);

        siz.appendChild(labels);
        siz.appendChild(inputField4);
        siz.appendChild(sizinp);

        colorInputContainer.appendChild(inputWrapper);
        iamgeflx.appendChild(imagene);
        colorInputContainer.appendChild(document.createElement("br"));
    }
}

function generateImageInputs(colorIndex) {
    var imageinputs = document.getElementById("iamg" + colorIndex).value;
    var colorInputContainer = document.getElementById("image-inputs" + colorIndex);


    colorInputContainer.innerHTML = '';

    for (var i = 1; i <= imageinputs; i++) {
        var inputWrapper = document.createElement("div");
        inputWrapper.classList.add("input-pair");
        inputWrapper.classList.add("szimg-bx");

        var inputField = document.createElement("input");
        inputField.type = "file";
        inputField.name = "image" + colorIndex + "_" + i;
        inputField.placeholder = "Choose Image " + i;
        inputField.classList.add("form-control");
        inputField.classList.add("my-2");
        inputField.accept = ".jpg,.jpeg,.png";
        inputField.setAttribute("required", "true");
        inputField.setAttribute("autocomplete", "off");

        var inputField1 = document.createElement("input");
        inputField1.type = "text";
        inputField1.name = "iname" + colorIndex + "_" + i;
        inputField1.placeholder = "Enter Image Name " + i;
        inputField1.classList.add("form-control");
        inputField1.classList.add("my-2");
        inputField1.setAttribute("required", "true");
        inputField1.setAttribute("autocomplete", "off");

        inputWrapper.appendChild(inputField1);
        inputWrapper.appendChild(inputField);

        colorInputContainer.appendChild(inputWrapper);
        colorInputContainer.appendChild(document.createElement("br"));
    }
}

function generateSizeeInputs(SizeIndex) {
    var sizeinputs = document.getElementById("siz" + SizeIndex).value;
    var SizeInputContainer = document.getElementById("size-inputs" + SizeIndex);

    SizeInputContainer.innerHTML = '';

    for (var i = 1; i <= sizeinputs; i++) {
        var inputWrapper = document.createElement("div");
        inputWrapper.classList.add("input-pair");
        inputWrapper.classList.add("szimg-bx");

        var inputField = document.createElement("input");
        inputField.type = "number";
        inputField.name = "size" + SizeIndex + "_" + i;
        inputField.placeholder = "Enter Size " + i;
        inputField.classList.add("form-control");
        inputField.classList.add("my-2");
        inputField.setAttribute("required", "true");
        inputField.setAttribute("autocomplete", "off");

        var inputField1 = document.createElement("input");
        inputField1.type = "number";
        inputField1.name = "qty" + SizeIndex + "_" + i;
        inputField1.placeholder = "Enter Quantity " + i;
        inputField1.classList.add("form-control");
        inputField1.classList.add("my-2");
        inputField1.setAttribute("required", "true");
        inputField1.setAttribute("autocomplete", "off");

        inputWrapper.appendChild(inputField);
        inputWrapper.appendChild(inputField1);

        SizeInputContainer.appendChild(inputWrapper);
        SizeInputContainer.appendChild(document.createElement("br"));
    }
}
</script>
<?php require_once __DIR__ . '/layout_footer.php'; ?>
