<style>

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
        if(!isset($_GET['page']))
        {
            echo '<ul id="sortable">';
                echo '<li class="tlst"><a href="index.php?q=8&step=9&page=index">Index</a></li>';
                echo '<li class="tlst"><a href="index.php?q=8&step=9&page=catg">Category</a></li>';
                echo '<li class="tlst"><a href="index.php?q=8&step=9&page=shop">Product Detail</a></li>';
                echo '<li class="tlst"><a href="index.php?q=8&step=9&page=cart">Cart</a></li>';
            echo '</ul>';
        }
        if(isset($_GET['page']) && ($_GET['page'] == 'catg'))
        {
            include 'category.php';
        }
        if(isset($_GET['page']) && ($_GET['page'] == 'index'))
        {
            include 'home.php';
        }
    ?>
</div>

