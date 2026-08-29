<style>
    .mce-branding a
    {
        display: none;
    }
    <?php
        $content = ' Asmit & Team'
    ?>
    .mce-branding::after {
        content: "<?php echo $content; ?>";
        font-weight: bold;
        /* color: red; */
    }
    .btitle
    {
        background-color: unset !important;
        color: #252525 !important;
    }
    .btitle:hover
    {
        background-color: unset !important;
    }

</style>
<!-- <h1>Add New Blog Post</h1>

<form method="POST" action="index.php">
    <label for="title">Title:</label>
    <input class="btitle" type="text" name="title" id="title" required><br><br>

    <label for="content">Content:</label><br>
    <div id="textareas-container">
        <textarea name="content[]" class="editor"></textarea><br><br>
    </div>

    <button type="button" onclick="addTextarea()">Add Another Textarea</button>
    <button type="button" onclick="removeTextarea()">Remove Last Textarea</button><br><br>

    <button type="submit">Save Blog Post</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: 'textarea',
    height: 300,
    plugins: 'advlist autolink lists link charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime table paste wordcount textcolor',
    toolbar: 'undo redo | formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | fontsize | bullist numlist outdent indent | removeformat',  // Add font color and size buttons to the toolbar
});
</script>
<script>
    function addTextarea() {
        const newTextarea = document.createElement('textarea');
        newTextarea.name = 'content[]';
        newTextarea.classList.add('editor');
        document.getElementById('textareas-container').appendChild(newTextarea);
        tinymce.init({
            selector: 'textarea.editor',
            height: 300,
            plugins: 'advlist autolink lists link charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime table paste wordcount', // Remove 'help' plugin here
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | fontsize | bullist numlist outdent indent | removeformat', // Exclude 'help' from toolbar
        });
    }

    function removeTextarea() {
        const container = document.getElementById('textareas-container');
        const textareas = container.getElementsByTagName('textarea');
        if (textareas.length > 0) {
            const lastTextarea = textareas[textareas.length - 1];
            tinymce.get(lastTextarea.id).remove();
            container.removeChild(lastTextarea);
        }
    }
</script> -->

<?php
require_once __DIR__ . "/../db.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Textareas with Names</title>
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script> -->
    <style>
        .textarea-container {
            position: relative;
            margin-bottom: 20px;
        }

        .remove-btn {
            position: absolute;
            top: 0;
            right: -1px;
            background-color: #ff0000c2;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Add New Blog Post</h1>

<form method="POST" action="update.php?q=addblog" enctype="multipart/form-data" style="width: auto;">
    <label for="image">Image:</label>
    <input type="file" id="image" name="image" class="form-control my-2" accept=".jpg,.jpeg,.png" required autocomplete="off">
    <label for="title">Title:</label>
    <input class="btitle" type="text" name="title" id="title" required><br><br>

    <label for="content">Content:</label><br>
    <div id="textareas-container">
        <!-- Initial textarea will be added here -->
    </div>

    <button type="button" class="btn btn-primary apgbt" onclick="addTextarea()">Add Textarea</button>
    <button type="submit" class="btn btn-primary apgbt" name="submit">Save Blog Post</button>
</form>
<script src="tinymce/tinymce.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>
    let editorCount = 0;

    function addTextarea() {
        editorCount++;

        const container = document.createElement('div');
        container.classList.add('textarea-container');
        container.id = 'container' + editorCount;

        // Create a new textarea
        const textarea = document.createElement('textarea');
        textarea.classList.add('editor');
        textarea.name = 'content[' + editorCount + ']'; // Dynamically set unique name attribute
        container.appendChild(textarea);

        // Add an 'X' button to remove the textarea
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'X';
        removeBtn.classList.add('remove-btn');
        removeBtn.onclick = function() {
            removeTextarea(container.id);
        };
        container.appendChild(removeBtn);

        // Append the container to the textareas container
        document.getElementById('textareas-container').appendChild(container);

        // Initialize TinyMCE editor
        // tinymce.init({
        //     selector: '#' + container.id + ' .editor',
        //     height: 300,       
        //     plugins: 'advlist autolink lists link charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime table paste wordcount image', // Add image plugin
        //     toolbar: 'undo redo | formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | fontsize | bullist numlist outdent indent | removeformat | image', // Add image button to toolbar
        //     images_upload_url: '../up_image.php',
        //     automatic_uploads: true,
        //     file_picker_types: 'image',
        //     setup: function(editor) {

        //     }
        //     // images_upload_base_path: 'admin/', 
        // });
        tinymce.init({
            selector: '#' + container.id + ' .editor',
            // height: 300,       
            plugins: 'advlist autolink lists link charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime table paste wordcount image', // Add image plugin
            toolbar: 'undo redo | formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | fontsize | bullist numlist outdent indent | removeformat | image', // Add image button to toolbar
            images_upload_url: '../up_image.php',
            automatic_uploads: true,
            file_picker_types: 'image',
            setup: function(editor) {

            }
            // images_upload_base_path: 'admin/', 
        });
    }
    
    // Function to remove a textarea
    function removeTextarea(containerId) {
        const container = document.getElementById(containerId);
        const textarea = container.querySelector('.editor');
        
        // Destroy the TinyMCE instance
        tinymce.get(textarea.id).destroy();
        
        // Remove the container from the DOM
        container.remove();
    }
</script>

</body>
</html>
