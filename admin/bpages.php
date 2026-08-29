<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order']) && isset($_POST['bcntids']) && is_array($_POST['order']) && is_array($_POST['bcntids'])) {
        $order = $_POST['order'];
        $bcntids = $_POST['bcntids'];

        foreach ($order as $index => $newOrder) {
            $bcntid = $bcntids[$index];
            
            $query = "UPDATE blog_posts SET c_order = ? WHERE bcntid = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "is", $newOrder, $bcntid);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Updated c_order for bcntid $bcntid to $newOrder <br>";
            } else {
                echo "Failed to update c_order for bcntid $bcntid <br>";
            }
        }

    } else {
        echo 'No valid order or bcntids received.';
    }
} else {
    // echo 'First';
}
?>

<style>
    .dragging {
        cursor: grabbing;
        position: absolute;
        z-index: 999;
        width: 65%;
        transform: scale(1);
    }
    .draggable {
        cursor: grab;
        transition: transform 0.2s ease;
    }
    #sortable {
        list-style-type: none;
        padding: 0;
    }
    #sortable li {
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f9fa;
    }
    .dragging {
        cursor: grabbing;
        margin: auto;
        opacity: 1;
    }
    .draggable {
        cursor: grab;
    }
    .draggable:active {
        cursor: grabbing;
    }
    #sortable .tlst
    {
        color: #000 !important;
        cursor: pointer;
    }
    #sortable .tlst a
    {
        color: #000 !important;
        cursor: pointer;
        width: 100%;
    }
    .ellipsis
    {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        border: 1px solid #ddd;
        padding: 10px;
    }
</style>

<div class="container mt-5">
    <?php
        if(!isset($_GET['blgid']))
        {
            echo '<h2>Blogs List</h2>
                <ul id="sortable">';
    
            $query = "SELECT * FROM blog_posts GROUP BY blgid";
            $results = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($results)) {
                $blgid = $row['blgid'];
                $title = $row['title'];
                $content = $row['content'];
                $c_order = $row['c_order'];
                
                // List each blog item
                echo '<li class="tlst"><a href="index.php?q=8&step=1&blgid='.$blgid.'">'.$title.'</a></li>';
            }
            echo '</ul>';
        }
    ?>
    
    <?php
        if(isset($_GET['blgid']))
        {
            echo '<h2>Blog Paragraphs</h2>
                <ul id="sortable">';
                
            $blgid = $_GET['blgid'];
            $query = "SELECT * FROM blog_posts WHERE blgid='$blgid' order by c_order asc";
            $results = mysqli_query($conn, $query);
            $bl = 1;
            while ($row = mysqli_fetch_array($results)) {
                $title = $row['title'];
                $bcntid = $row['bcntid'];
                $content = $row['content'];
                $c_order = $row['c_order'];
                
                // List each blog paragraph with hidden bcntid
                echo '<li class="draggable" draggable="true" id="item'.$c_order.'" data-id="'.$c_order.'">
                        <div class="ellipsis">
                        '.$content.'
                            
                        </div>
                        <input type="hidden" name="bcnid'.$bl.'" value="'.$bcntid.'">
                      </li>';
                $bl++;
            }
            echo '</ul>
                  <button id="saveOrder" class="btn btn-primary mt-3 apgbt">Save Order</button>';
        }
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    const sortable = document.getElementById('sortable');

    sortable.addEventListener('dragstart', (e) => {
        e.target.classList.add('dragging');
        e.target.style.cursor = 'grabbing';
    });

    sortable.addEventListener('dragend', (e) => {
        e.preventDefault();
        e.target.classList.remove('dragging');
        e.target.style.cursor = 'grab';
    });

    sortable.addEventListener('dragover', (e) => {
        e.preventDefault();
        const dragging = document.querySelector('.dragging');
        const afterElement = getDragAfterElement(sortable, e.clientY);

        if (afterElement == null) {
            sortable.appendChild(dragging);
        } else {
            sortable.insertBefore(dragging, afterElement);
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    $('#saveOrder').click(function() {
        let orderedIds = [];
        let bcntids = [];

        $('#sortable li').each(function(index) {
            orderedIds.push(index + 1);
            bcntids.push($(this).find('input[type="hidden"]').val());
        });

        $.post('index.php?q=8&step=1', { order: orderedIds, bcntids: bcntids }, function(response) {
            alert('Order saved successfully!');
            console.log(response);
        });
    });
</script>



<!-- /* STYLE 1: MATERIAL DESIGN */
.material-style #sortable {
  list-style-type: none;
  padding: 0;
}

.material-style #sortable li {
  margin: 12px 0;
  padding: 0;
  border-radius: 4px;
  background-color: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.material-style #sortable li:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.material-style .ellipsis {
  padding: 16px;
  display: flex;
  align-items: center;
}

.material-style .ellipsis::before {
  content: "≡";
  margin-right: 16px;
  color: #9e9e9e;
  font-size: 20px;
}

.material-style .dragging {
  transform: scale(1.05);
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.material-style #saveOrder {
  background-color: #2196F3;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 4px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  font-weight: 500;
}

.material-style #saveOrder:hover {
  background-color: #1976D2;
  box-shadow: 0 7px 14px rgba(0,0,0,0.25), 0 5px 5px rgba(0,0,0,0.22);
}

/* STYLE 2: NEUMORPHIC */
.neumorphic-style #sortable {
  list-style-type: none;
  padding: 0;
}

.neumorphic-style #sortable li {
  margin: 16px 0;
  border-radius: 12px;
  background-color: #f0f4f8;
  box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
  transition: all 0.2s ease;
}

.neumorphic-style #sortable li:hover {
  box-shadow: 7px 7px 15px #d1d9e6, -7px -7px 15px #ffffff;
}

.neumorphic-style .ellipsis {
  padding: 18px;
  color: #5a6a8a;
  font-weight: 500;
}

.neumorphic-style .ellipsis::before {
  content: "::";
  margin-right: 14px;
  font-weight: bold;
  letter-spacing: 2px;
}

.neumorphic-style .dragging {
  background-color: #ffffff;
  box-shadow: inset 5px 5px 10px #d1d9e6, inset -5px -5px 10px #ffffff;
}

.neumorphic-style #saveOrder {
  background: #f0f4f8;
  color: #5a6a8a;
  border: none;
  padding: 14px 28px;
  border-radius: 12px;
  box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
  font-weight: 600;
}

.neumorphic-style #saveOrder:hover {
  box-shadow: inset 5px 5px 10px #d1d9e6, inset -5px -5px 10px #ffffff;
}

/* STYLE 3: GLASSMORPHISM */
.glass-style {
  background: linear-gradient(135deg, #83a4d4, #b6fbff);
  padding: 20px;
  border-radius: 16px;
}

.glass-style #sortable {
  list-style-type: none;
  padding: 0;
}

.glass-style #sortable li {
  margin: 14px 0;
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 16px;
  transition: all 0.3s;
}

.glass-style #sortable li:hover {
  background: rgba(255, 255, 255, 0.4);
  transform: translateY(-3px);
}

.glass-style .ellipsis {
  padding: 16px 22px;
  color: #1a3246;
  font-weight: 500;
}

.glass-style .dragging {
  background: rgba(255, 255, 255, 0.5) !important;
  border: 1px solid rgba(255, 255, 255, 0.5);
  transform: scale(1.05);
}

.glass-style #saveOrder {
  background: rgba(255, 255, 255, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.5);
  color: #1a3246;
  padding: 12px 24px;
  border-radius: 16px;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  font-weight: 600;
}

.glass-style #saveOrder:hover {
  background: rgba(255, 255, 255, 0.5);
}

/* STYLE 4: DARK MODE */
.dark-style {
  background-color: #121212;
  padding: 20px;
  color: #e0e0e0;
}

.dark-style h2 {
  color: #e0e0e0;
}

.dark-style #sortable {
  list-style-type: none;
  padding: 0;
}

.dark-style #sortable li {
  margin: 12px 0;
  background-color: #1e1e1e;
  border: 1px solid #333;
  border-radius: 8px;
  transition: all 0.2s ease;
}

.dark-style #sortable li:hover {
  background-color: #2a2a2a;
  border-color: #444;
}

.dark-style .ellipsis {
  padding: 16px;
  color: #e0e0e0;
}

.dark-style .ellipsis::before {
  content: "≡";
  margin-right: 12px;
  color: #888;
}

.dark-style .dragging {
  background-color: #3a3a3a !important;
  border-color: #555 !important;
}

.dark-style #saveOrder {
  background-color: #BB86FC;
  color: #121212;
  border: none;
  padding: 12px 24px;
  border-radius: 6px;
  font-weight: 600;
}

.dark-style #saveOrder:hover {
  background-color: #A66DF7;
}

/* STYLE 5: MINIMALIST */
.minimalist-style #sortable {
  list-style-type: none;
  padding: 0;
}

.minimalist-style #sortable li {
  margin: 10px 0;
  padding: 0;
  border-bottom: 1px solid #eee;
  background-color: transparent;
  transition: all 0.2s ease;
}

.minimalist-style #sortable li:hover {
  border-bottom-color: #ccc;
}

.minimalist-style .ellipsis {
  padding: 14px 8px;
  color: #333;
  font-weight: 400;
}

.minimalist-style .ellipsis::before {
  content: "···";
  margin-right: 10px;
  color: #aaa;
  letter-spacing: 1px;
}

.minimalist-style .dragging {
  background-color: #f9f9f9 !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  border-radius: 4px;
}

.minimalist-style #saveOrder {
  background-color: transparent;
  color: #333;
  border: 1px solid #ddd;
  padding: 10px 20px;
  border-radius: 0;
  font-weight: 500;
  transition: all 0.2s ease;
}

.minimalist-style #saveOrder:hover {
  background-color: #f5f5f5;
  border-color: #ccc;
}

/* STYLE 6: PLAYFUL */
.playful-style {
  font-family: 'Comic Sans MS', 'Chalkboard SE', sans-serif;
}

.playful-style #sortable {
  list-style-type: none;
  padding: 0;
}

.playful-style #sortable li {
  margin: 14px 0;
  background-color: #fff;
  border: 3px solid #FFD54F;
  border-radius: 20px;
  box-shadow: 5px 5px 0 #FF9800;
  transition: all 0.2s ease;
}

.playful-style #sortable li:hover {
  transform: translateY(-5px) rotate(1deg);
  box-shadow: 8px 8px 0 #FF9800;
}

.playful-style .ellipsis {
  padding: 15px;
  color: #5D4037;
  font-weight: bold;
}

.playful-style .ellipsis::before {
  content: "✋";
  margin-right: 12px;
}

.playful-style .dragging {
  transform: rotate(3deg) scale(1.05);
  background-color: #FFFDE7 !important;
}

.playful-style #saveOrder {
  background-color: #FF9800;
  color: white;
  border: 3px solid #FFD54F;
  padding: 12px 24px;
  border-radius: 20px;
  font-weight: bold;
  box-shadow: 3px 3px 0 #E65100;
  transition: all 0.2s ease;
}

.playful-style #saveOrder:hover {
  background-color: #FFB74D;
  transform: translateY(-3px);
  box-shadow: 5px 5px 0 #E65100;
}

/* STYLE 7: CORPORATE */
.corporate-style {
  font-family: 'Arial', sans-serif;
}

.corporate-style #sortable {
  list-style-type: none;
  padding: 0;
}

.corporate-style #sortable li {
  margin: 8px 0;
  background-color: #f8f9fa;
  border-left: 4px solid #007bff;
  box-shadow: 0 1px 2px rgba(0,0,0,0.05);
  transition: all 0.2s ease;
}

.corporate-style #sortable li:hover {
  background-color: #e9ecef;
  border-left-color: #0056b3;
}

.corporate-style .ellipsis {
  padding: 12px 16px;
  color: #495057;
  font-size: 14px;
}

.corporate-style .ellipsis::before {
  content: "≡";
  margin-right: 12px;
  color: #6c757d;
}

.corporate-style .dragging {
  background-color: #e2e6ea !important;
  border-left-color: #0056b3 !important;
}

.corporate-style #saveOrder {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
}

.corporate-style #saveOrder:hover {
  background-color: #0069d9;
}

/* STYLE 8: RETRO */
.retro-style {
  font-family: 'Courier New', monospace;
  background-color: #f0e6d2;
  padding: 20px;
  border: 4px double #8B4513;
}

.retro-style h2 {
  color: #8B4513;
  text-decoration: underline;
}

.retro-style #sortable {
  list-style-type: none;
  padding: 0;
}

.retro-style #sortable li {
  margin: 12px 0;
  background-color: #fff8e1;
  border: 2px solid #8B4513;
  box-shadow: 4px 4px 0 #8B4513;
  transition: all 0.2s ease;
}

.retro-style #sortable li:hover {
  transform: translate(-2px, -2px);
  box-shadow: 6px 6px 0 #8B4513;
}

.retro-style .ellipsis {
  padding: 14px;
  color: #5D4037;
  font-weight: bold;
}

.retro-style .ellipsis::before {
  content: ">>>";
  margin-right: 12px;
  color: #8B4513;
}

.retro-style .dragging {
  background-color: #ffe0b2 !important;
}

.retro-style #saveOrder {
  background-color: #8B4513;
  color: #f0e6d2;
  border: 2px solid #5D4037;
  padding: 10px 20px;
  font-weight: bold;
  box-shadow: 4px 4px 0 #5D4037;
  cursor: pointer;
}

.retro-style #saveOrder:hover {
  background-color: #A0522D;
  transform: translate(-2px, -2px);
  box-shadow: 6px 6px 0 #5D4037;
}

/* STYLE 9: HIGH CONTRAST */
.high-contrast-style {
  background-color: #000;
  color: #fff;
  padding: 20px;
}

.high-contrast-style h2 {
  color: #fff;
  border-bottom: 2px solid #ff0;
  padding-bottom: 10px;
}

.high-contrast-style #sortable {
  list-style-type: none;
  padding: 0;
}

.high-contrast-style #sortable li {
  margin: 12px 0;
  background-color: #000;
  border: 2px solid #ff0;
  transition: all 0.2s ease;
}

.high-contrast-style #sortable li:hover {
  background-color: #333;
}

.high-contrast-style .ellipsis {
  padding: 16px;
  color: #fff;
  font-weight: bold;
}

.high-contrast-style .ellipsis::before {
  content: "≡";
  margin-right: 14px;
  color: #ff0;
  font-size: 18px;
}

.high-contrast-style .dragging {
  background-color: #333 !important;
  border-color: #fff !important;
}

.high-contrast-style #saveOrder {
  background-color: #ff0;
  color: #000;
  border: none;
  padding: 12px 24px;
  font-weight: bold;
  transition: all 0.2s ease;
}

.high-contrast-style #saveOrder:hover {
  background-color: #fff;
}

/* STYLE 10: SOCIAL MEDIA */
.social-style {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif;
}

.social-style #sortable {
  list-style-type: none;
  padding: 0;
}

.social-style #sortable li {
  margin: 10px 0;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12);
  transition: all 0.2s ease;
  overflow: hidden;
}

.social-style #sortable li:hover {
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.social-style .ellipsis {
  padding: 16px;
  color: #262626;
  font-weight: 500;
  display: flex;
  align-items: center;
}

.social-style .ellipsis::before {
  content: "";
  width: 10px;
  height: 10px;
  margin-right: 16px;
  background-color: #0095f6;
  border-radius: 50%;
}

.social-style .dragging {
  transform: scale(1.02);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
}

.social-style #saveOrder {
  background-color: #0095f6;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.social-style #saveOrder:hover {
  background-color: #1877f2;
} -->
