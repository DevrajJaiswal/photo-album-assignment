<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Album assignment</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <h1 class="heading">My Photo Album</h1>

        <!-- Upload Form Start-->
        <div class="form-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" id="image">
                <button type="submit" name="save" id="saveImgButton">Save</button>
            </form>
        </div>
        <!-- Upload Form End-->

        <!-- Album layout Start -->
        <div class="album-container">

            <?php
            $imgs = glob('images/uploads/*.{jpg,jpeg,png}', GLOB_BRACE);
            // print_r($imgs);
            $total_imgs = count($imgs);
            $page_limit = 6;
            $total_page = ceil($total_imgs / $page_limit);

            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = (int) $_GET['page'];
                if ($page <= 0) {
                    $page = $total_page;
                } elseif ($page > $total_page) {
                    $page = 1;
                }
            }

            if ($total_imgs > 0) {
                usort($imgs, function ($a, $b) {
                    return filemtime($b) - filemtime($a); // newest first
                });

                $start = ($page - 1) * $page_limit;
                $currentImages = array_slice($imgs, $start, $page_limit);


                foreach ($currentImages as $img) {
                    echo "<div class='img-box'><img src='$img' alt=''></div>";
                }
            } else {
                echo "<div class='img-box' style='text-align:center; flex-basis:100%;'> No images found </div>";
            }
            ?>
        </div>
        <!-- Album layout End -->


        <!-- Pagination Start-->
        <div class="pagination">
            <?php
            if ($total_page > 1) {
                // echo "current page no" . $page;
                $prev_page = ($page - 1 < 1) ? $total_page : $page - 1;
                echo "<a class='prev nav' href='index.php?page=$prev_page'>Prev</a>";

                // Next button: if on last page, go to first
                $next_page = ($page + 1 > $total_page) ? 1 : $page + 1;
                echo "<a class='next nav' href='index.php?page=$next_page'>Next</a>";
            }
            ?>
        </div>
        <!-- Pagination End-->

    </main>

</body>

<?php

if (isset($_POST['save'])) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === 4) {
        echo "No file selected. Please choose an image to upload.";
        return;
    }

    $name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];

    $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    // echo "File Name: " . $name . "<br>";
    // echo "File temp name: " . $tmp_name . "<br>";
    // echo "File Type: " . $file_type . "<br>";
    // echo "File Size: " . $file_size . "<br>";
    // echo "File Extension: " . $file_ext . "<br>";
    // echo "File Error: " . $error . "<br>";

    if ($error === 0) {
        if (in_array($file_ext, $allowed_ext)) {
            if ($file_size <= 2 * 1024 * 1024) {
                $upload_path = "images/uploads/" . $name;
                if (move_uploaded_file($tmp_name, $upload_path)) {
                    echo "✅ Image successfully uploaded!";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "Image size should be Maximum 2MB.";
            }
        } else {
            echo "Invalid Image type. Only JPG, JPEG, PNG allowed.";
        }
    }
}

?>
<script src="script.js"></script>

</html>