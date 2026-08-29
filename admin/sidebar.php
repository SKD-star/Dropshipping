<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order']) && isset($_POST['functs']) && is_array($_POST['order']) && is_array($_POST['functs'])) {
        $order = $_POST['order'];
        $functs = $_POST['functs'];

        foreach ($order as $index => $newOrder) {
            $funct = $functs[$index];
            
            $query = "UPDATE pages SET funord = ? WHERE funid = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "is", $newOrder, $funct);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Updated c_order for funct $funct to $newOrder <br>";
            } else {
                echo "Failed to update c_order for funct $funct <br>";
            }
        }

    } else {
        echo 'No valid order or bcntids received.';
    }
} else {
    // echo 'First';
}
?>

<?php
    echo '<h2>Blog Paragraphs</h2>
        <ul id="sortable">';
    $query = "SELECT * FROM pages where position='sidebar' order by funord asc";
    $results = mysqli_query($conn, $query);
    $bl = 1;
    while ($row = mysqli_fetch_array($results)) {
        $title = $row['title'];
        $funct = $row['funord'];
        $funid = $row['funid'];


        // List each blog paragraph with hidden bcntid
        echo '<li class="draggable" draggable="true" id="item'.$funct.'" data-id="'.$funct.'">
                <p>'.$title.'</p>
                <input type="hidden" name="bcnid'.$bl.'" value="'.$funid.'">
              </li>';
        $bl++;
    }
    echo '</ul>
        <button id="saveOrder" class="btn btn-primary mt-3 apgbt">Save Order</button>';
?>
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
        let functs = [];

        $('#sortable li').each(function(index) {
            orderedIds.push(index + 1);
            functs.push($(this).find('input[type="hidden"]').val());
        });

        $.post('index.php?q=8&step=9&page=index', { order: orderedIds, functs: functs }, function(response) {
            alert('Order saved successfully!');
            console.log(response);
        });
    });
</script>