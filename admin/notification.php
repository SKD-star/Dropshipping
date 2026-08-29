<div class="container mt-4 py-5 apc">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3">
            <ul class="nav flex-column apt aph">
                <li class="nav-item apl">
                    <a class="nav-link apthe <?php if ($step == 1) { echo 'active'; } ?>" href="?q=5&step=1">
                        Tickets
                    </a>
                </li>
                <li class="nav-item apl">
                    <a class="nav-link apthe <?php if ($step == 2) { echo 'active'; } ?>" href="?q=5&step=2">
                        Query
                    </a>
                </li>
                <li class="nav-item apl">
                    <a class="nav-link apthe <?php if ($step == 3) { echo 'active'; } ?>" href="?q=5&step=3">
                        Contact Support
                    </a>
                </li>
                <li class="nav-item apl">
                    <a class="nav-link apthe <?php if ($step == 3) { echo 'active'; } ?>" href="?q=5&step=4">
                        FAQ
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-9">
            <?php
            if ($step == 1) {
                echo '<a href="index.php?q=8&step=3" class="btn btn-primary apgbt">Add Blog Pages</a>';
                include 'bpages.php';
            } elseif ($step == 2) {
                echo "<h2>Announcements</h2><p>Here are the announcements...</p>";
                include 'query.php';
            } elseif ($step == 3) {
                echo "<h2>Blogs</h2><p>Here are the blogs...</p>";

                include 'ins-blog.php';
            } elseif ($step == 4) {
                echo "<h2>Blogs</h2><p>Here are the blogs...</p>";

                include 'faq.php';
            }
            ?>
        </div>
    </div>
</div>

