<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tags mr-2"></i> Category Management</span>
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#category">
            <i class="fas fa-plus mr-1"></i> Add Category
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover usr-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res_cats = $conn->query("SELECT * FROM `catgory` ORDER BY id DESC");
                    if ($res_cats && $res_cats->num_rows > 0) {
                        $i = 1;
                        while ($cat = $res_cats->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><strong><?= htmlspecialchars($cat['category']) ?></strong></td>
                                <td><?= htmlspecialchars($cat['descp'] ?: 'Standard apparel collection') ?></td>
                                <td><?= date('d M Y', strtotime($cat['created_at'])) ?></td>
                                <td style="text-align: right;">
                                    <a href="update.php?q=delcatg&ctid=<?= urlencode($cat['ctid']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center py-4 text-muted">No categories created yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
