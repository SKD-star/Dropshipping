<?php
require_once __DIR__ . '/../db.php';

session_name('js239');
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['admin']))
{
    header("location: login.php");
    exit;
}
// ─── Home Page Settings Save Handler ─────────────────────────────────────────
if (@$_GET['q'] == 'homesettings' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'announcement_text'       => substr(trim($_POST['announcement_text'] ?? ''), 0, 500),
        'announcement_bg_color'   => preg_replace('/[^#a-fA-F0-9]/', '', $_POST['announcement_bg_color'] ?? '#0a0b0e'),
        'announcement_text_color' => preg_replace('/[^#a-fA-F0-9]/', '', $_POST['announcement_text_color'] ?? '#e9c176'),
        'announcement_link'       => substr(trim($_POST['announcement_link'] ?? ''), 0, 500),
        'announcement_enabled'    => isset($_POST['announcement_enabled']) ? 1 : 0,
        'hero_label'              => substr(trim($_POST['hero_label'] ?? ''), 0, 200),
        'hero_headline'           => substr(trim($_POST['hero_headline'] ?? ''), 0, 300),
        'hero_subheadline'        => substr(trim($_POST['hero_subheadline'] ?? ''), 0, 300),
        'hero_body'               => substr(trim($_POST['hero_body'] ?? ''), 0, 2000),
        'hero_bg_image'           => substr(trim($_POST['hero_bg_image'] ?? ''), 0, 500),
        'hero_cta_text'           => substr(trim($_POST['hero_cta_text'] ?? ''), 0, 100),
        'hero_cta_url'            => substr(trim($_POST['hero_cta_url'] ?? ''), 0, 500),
        'hero_product_id'         => (int)($_POST['hero_product_id'] ?? 0) ?: null,
        'flash_section_enabled'   => isset($_POST['flash_section_enabled']) ? 1 : 0,
        'flash_section_title'     => substr(trim($_POST['flash_section_title'] ?? ''), 0, 200),
        'flash_section_subtitle'  => substr(trim($_POST['flash_section_subtitle'] ?? ''), 0, 400),
        'flash_timer_hours'       => max(1, min(72, (int)($_POST['flash_timer_hours'] ?? 7))),
        'featured_section_enabled'=> isset($_POST['featured_section_enabled']) ? 1 : 0,
        'featured_section_title'  => substr(trim($_POST['featured_section_title'] ?? ''), 0, 200),
        'featured_section_subtitle'=> substr(trim($_POST['featured_section_subtitle'] ?? ''), 0, 300),
        'arrivals_section_enabled'=> isset($_POST['arrivals_section_enabled']) ? 1 : 0,
        'arrivals_section_title'  => substr(trim($_POST['arrivals_section_title'] ?? ''), 0, 200),
        'arrivals_section_subtitle'=> substr(trim($_POST['arrivals_section_subtitle'] ?? ''), 0, 300),
        'sticky_bar_enabled'      => isset($_POST['sticky_bar_enabled']) ? 1 : 0,
        'sticky_bar_product_id'   => (int)($_POST['sticky_bar_product_id'] ?? 0) ?: null,
        'whatsapp_enabled'        => isset($_POST['whatsapp_enabled']) ? 1 : 0,
        'whatsapp_number'         => preg_replace('/[^0-9]/', '', $_POST['whatsapp_number'] ?? ''),
        'whatsapp_message'        => substr(trim($_POST['whatsapp_message'] ?? ''), 0, 300),
        'brand_name'              => substr(trim($_POST['brand_name'] ?? 'LUMINA'), 0, 100),
        'brand_tagline'           => substr(trim($_POST['brand_tagline'] ?? ''), 0, 1000),
        'copyright_text'          => substr(trim($_POST['copyright_text'] ?? ''), 0, 300),
        'contact_email'           => substr(trim($_POST['contact_email'] ?? ''), 0, 255),
    ];


    // Build SET clause safely
    $set_parts = [];
    $bind_types = '';
    $bind_vals  = [];
    foreach ($fields as $col => $val) {
        $set_parts[] = "`$col` = ?";
        if (is_null($val)) { $bind_types .= 's'; $bind_vals[] = null; }
        elseif (is_int($val)) { $bind_types .= 'i'; $bind_vals[] = $val; }
        else { $bind_types .= 's'; $bind_vals[] = $val; }
    }

    // Check if row exists
    $chk = $conn->query("SELECT id FROM `home_settings` WHERE store_id=1 LIMIT 1");
    if ($chk && $chk->num_rows > 0) {
        $sql = "UPDATE `home_settings` SET " . implode(', ', $set_parts) . " WHERE store_id=1";
    } else {
        $cols  = implode(', ', array_map(fn($c) => "`$c`", array_keys($fields)));
        $plh   = implode(', ', array_fill(0, count($fields), '?'));
        $sql   = "INSERT INTO `home_settings` (store_id, $cols) VALUES (1, $plh)";
        $bind_types = 's' . $bind_types; // extra store_id
        array_unshift($bind_vals, 1);
        $sql   = "INSERT INTO `home_settings` (`store_id`, " . implode(', ', array_map(fn($c) => "`$c`", array_keys($fields))) . ") VALUES (1, " . implode(', ', array_fill(0, count($fields), '?')) . ")";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($bind_types, ...$bind_vals);
        if ($stmt->execute()) {
            header("Location: index.php?q=88&saved=1");
        } else {
            header("Location: index.php?q=88&err=1");
        }
    } else {
        header("Location: index.php?q=88&err=db");
    }
    exit;
}

if (@$_GET['q'] == 'perm' && (@$_GET['admid']) && (@$_GET['type'])) {

    $adid = @$_GET['admid'];
    $type = @$_GET['type'];

    // echo $disc;
    if ($_SESSION['type'] != 'Main') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=10','_self')</script>";
    }
    else {
        if ($type == 1) {
            $stmt1 = $conn->prepare("update admin set perm = 'Viewer' where admid = ?");
        }
        elseif ($type == 2) {
            $stmt1 = $conn->prepare("update admin set perm = 'Product Manager' where admid = ?");
        }
        elseif ($type == 3) {
            $stmt1 = $conn->prepare("update admin set perm = 'Custom Manager' where admid = ?");
        }
        elseif ($type == 4) {
            $stmt1 = $conn->prepare("update admin set perm = 'Blog Writer' where admid = ?");
        }
        elseif ($type == 5) {
            $stmt1 = $conn->prepare("update admin set perm = 'Tickets Manager' where admid = ?");
        }
        else {
            echo "<script>alert('No Other Permission Available.')</script>";
        }

        $stmt1->bind_param("s", $adid);
        $stmt1->execute();
        
        header("Location: index.php?q=9&step=2");
    }
}
if (@$_GET['q'] == '789' && (@$_GET['uid'])) {
    $uid = @$_GET['uid'];
    $disc = $_POST['disc'];

    echo $disc;

    $stmt1 = $conn->prepare("update userdet set disc = ? where uid = ?");
    $stmt1->bind_param("ss", $disc, $uid); 
    $stmt1->execute();
    header("Location: index.php?q=2");
}
if (@$_GET['q'] == 'delprod' && (@$_GET['ccid'] || @$_GET['pid'])) {
    $ccid = @$_GET['ccid'] ?? '';
    $pid = (int)(@$_GET['pid'] ?? 0);

    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=1','_self')</script>";
        exit;
    }

    if ($pid > 0) {
        $conn->query("DELETE FROM `products` WHERE id = $pid");
        $conn->query("DELETE FROM `product_variants` WHERE product_id = $pid");
        $conn->query("DELETE FROM `product_images` WHERE product_id = $pid");
        $conn->query("DELETE FROM `product` WHERE ccid = 'prod_$pid'");
    }
    if (!empty($ccid)) {
        $conn->query("DELETE FROM `product` WHERE ccid = '" . $conn->real_escape_string($ccid) . "'");
        if (strpos($ccid, 'prod_') === 0) {
            $p_num = (int)substr($ccid, 5);
            $conn->query("DELETE FROM `products` WHERE id = $p_num");
            $conn->query("DELETE FROM `product_variants` WHERE product_id = $p_num");
            $conn->query("DELETE FROM `product_images` WHERE product_id = $p_num");
        }
    }
    header("Location: index.php?q=1");
    exit;
}
if (@$_GET['q'] == 'sldon' && (@$_GET['sldid'])) {
    $sldid = @$_GET['sldid'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=2','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update sliders set sstat = 1 where sldid = ?");
        $stmt1->bind_param("s", $sldid); 
        $stmt1->execute();
        header("Location: index.php?q=8&step=2");
    }
}
if (@$_GET['q'] == 'sldoff' && (@$_GET['sldid'])) {
    $sldid = @$_GET['sldid'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=2','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update sliders set sstat = 0 where sldid = ?");
        $stmt1->bind_param("s", $sldid); 
        $stmt1->execute();
        header("Location: index.php?q=8&step=2");
    }
}
if (@$_GET['q'] == 'prmon' && (@$_GET['prmoid'])) {
    $prmoid = @$_GET['prmoid'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=9&page=catg','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update promo set pstat = 1 where prmoid = ?");
        $stmt1->bind_param("s", $prmoid); 
        $stmt1->execute();
        header("Location: index.php?q=8&step=8");
    }
}
if (@$_GET['q'] == 'prmoff' && (@$_GET['prmoid'])) {
    $prmoid = @$_GET['prmoid'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=9&page=catg','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update promo set pstat = 0 where prmoid = ?");
        $stmt1->bind_param("s", $prmoid); 
        $stmt1->execute();
        header("Location: index.php?q=8&step=8");
    }
}


if (@$_GET['q'] == 'dison' && (@$_GET['discid'])) {
    $discid = @$_GET['discid'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=9&page=catg','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update discount set dstat = 1 where discid = ?");
        $stmt1->bind_param("s", $discid); 
        $stmt1->execute();
        header("Location: index.php?q=8&step=10");
    }
}
if (@$_GET['q'] == 'disoff' && (@$_GET['discid'])) {
    $discid = @$_GET['discid'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=9&page=catg','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update discount set dstat = 0 where discid = ?");
        $stmt1->bind_param("s", $discid); 
        $stmt1->execute();

        $stmt2 = $conn->prepare("update disimg set stat = 0 where discid = ?");
        $stmt2->bind_param("s", $discid); 
        $stmt2->execute();
        
        header("Location: index.php?q=8&step=10");
    }
}

if (@$_GET['q'] == 'dimon' && (@$_GET['disimd'])) {
    $disimd = @$_GET['disimd'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=10','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update disimg set stat = 1 where disimd = ?");
        $stmt1->bind_param("s", $disimd);
        $stmt1->execute();
        
        header("Location: index.php?q=8&step=10");
    }
}
if (@$_GET['q'] == 'dimoff' && (@$_GET['disimd'])) {
    $disimd = @$_GET['disimd'];

    // echo $disc;
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=10','_self')</script>";
    }
    else {
        $stmt1 = $conn->prepare("update disimg set stat = 0 where disimd = ?");
        $stmt1->bind_param("s", $disimd);
        $stmt1->execute();
        
        header("Location: index.php?q=8&step=10");
    }
}
// if (@$_GET['q'] == 'addcatg') {
    
//     $catg = $_POST['pname'];
//     $descpr = $_POST['descpr'];
//     $statusMsg = '';
//     $ctid = uniqid();
//     $admid = $_SESSION['admid'];

//     // $status = 'error';
//     $status = 'error';
//     if(!empty($_FILES["image"]["name"]))
//     {
//         echo 'Sagar2';
//         // Get file info
//         $fileName = basename($_FILES["image"]["name"]);
//         $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        
//         // Allow certain file formats
//         $allowTypes = array('jpg','png','jpeg','gif');
//         if(in_array($fileType, $allowTypes))
//         {
//             echo 'Sagar3';
//             $image = $_FILES['image']['tmp_name'];
//             $imgContent = addslashes(file_get_contents($image));
        
//             // Insert image content into database 
//             echo 'Sagar';
//             // $insert = mysqli_query($conn, "INSERT into images VALUES ('$imgContent')"); 
//             // $q3     = mysqli_query($conn, "insert into company values(NULL,'$id','$cname','$phoneno','$address')") or die("No Companies Data is Changed Error Ask Sagar");
//             $insert = mysqli_query($conn, "insert into catgory (`admid`,`ctid`,`category`,`descp`,`ctimg`) VALUES ('$admid','$ctid', '$catg', '$descpr', '$imgContent')") or die("No Category is Added Error Ask Sagar");
//             // $insert = mysqli_query($conn, "insert into items values (NULL,'$fid','$fitno','$type','$imgContent','$uid','$htname','$fname','$desc','$netwt','$mrp','$dis','Available','$inote','$ibox','$ingden','$ditm')")or die("No Food Item is Added Error Ask Sagar"); 
            
//             if($insert)
//             {
//                 $status = 'success'; 
//                 $statusMsg = "File uploaded successfully.";
//                 header("location: index.php?q=0");
//             }
//             else
//             {
//                 $statusMsg = "File upload failed, please try again."; 
//             }  
//         }
//         else
//         {
//             $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
//         } 
//     }
//     else
//     {
//         $statusMsg = 'Please select an image file to upload.'; 
//     } 
//     // }
//     echo $statusMsg;

// }
// if (@$_GET['q'] == 'addprod') {
    
//     $pname = $_POST['pname'];
//     $type = $_POST['type'];
//     // $siz = $_POST['siz']; 
//     $col = $_POST['col']; 
//     $desn = $_POST['desn'];
//     $disc = $_POST['disc'];
//     $keyword = $_POST['keyword'];
//     $mrp = $_POST['mrp'];
//     $descpm = $_POST['descpm'];
//     $admid = $_SESSION['admid'];
//     $pcid = uniqid(); 
//     $statusMsg = ''; 

//     for ($i = 1; $i <= $desn; $i++) {
//         if (isset($_POST["desch" . $i])) {
//             $desch = $_POST["desch" . $i];
//             $descp = $_POST["descp" . $i];
//             $despid = uniqid();

//             $stmt1 = $conn->prepare("insert into description (admid, pcid, despid, decph, descp) VALUES (?, ?, ?, ?, ?)");
//             $stmt1->bind_param("sssss", $admid, $pcid, $despid, $desch, $descp); 
//             $stmt1->execute();
//             echo "Heading: $desch<br>";
//             echo nl2br(htmlspecialchars($descp));
//         }
//         else {
//             echo 'NOOOOOOOOO';
//         }
//     }


    
//     for ($i = 1; $i <= $col; $i++) 
//     {
//         if (isset($_POST["ccode" . $i]) && isset($_POST["cname" . $i])) {
//             $colorCode = $_POST["ccode" . $i];
//             $colorName = $_POST["cname" . $i];
//             $ccid = uniqid();
            
//             $insert = mysqli_query($conn, "insert into product (`admid`,`pcid`,`ccid`,`keyword`,`category`,`pname`,`descp`,`color`,`ccode`,`mrp`,`disc`) VALUES ('$admid','$pcid', '$ccid', '$keyword', '$type', '$pname', '$descpm', '$colorName', '$colorCode', '$mrp', '$disc')") or die("No Product Item is Added Error Ask Sagar");

            
//             for ($j = 1; $j <= $_POST["iamg" . $i]; $j++) {
//                 if (isset($_FILES["image" . $i . "_" . $j]) && $_FILES["image" . $i . "_" . $j]["error"] == UPLOAD_ERR_OK) {
//                     $imageFile = $_FILES["image" . $i . "_" . $j];
//                     $imageName = $_POST["iname" . $i . "_" . $j];

//                     $status = 'error';
//                     if(!empty($_FILES["image" . $i . "_" . $j]["name"]))
//                     {
//                         echo 'Sagar2';
                        
//                         $fileName = basename($_FILES["image" . $i . "_" . $j]["name"]);
//                         $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        
                        
//                         $allowTypes = array('jpg','png','jpeg','gif');
//                         if(in_array($fileType, $allowTypes))
//                         {
//                             echo 'Sagar3';
//                             $image = $_FILES["image" . $i . "_" . $j]['tmp_name'];
//                             $imgContent = addslashes(file_get_contents($image));
//                             // $imgContent = file_get_contents($image);


//                             echo 'Sagar';
//                             $imid = uniqid();

//                             echo $ccid.'<br>'.$imid.'<br>'.$mrp.'<br>'.$disc.'<br>'.$colorCode.'<br>'.$colorName.'<br><br><br>';
//                             $admid = $_SESSION['admid'];
//                             // $insert = mysqli_query($conn, "insert into product (`admid`,`pcid`,`keyword`,`ccid`,`category`,`pname`,`descp`,`color`,`ccode`,`mrp`,`disc`) VALUES ('$admid','$pcid', '$ccid', '$keyword', '$type', '$pname', '$descpm', '$colorName', '$colorCode', '$mrp', '$disc')") or die("No Product Item is Added Error Ask Sagar");
//                             // $insert2 = mysqli_query($conn, "INSERT INTO pimage (`admid`, `pcid`, `ccid`, `imid`, `category`, `iname`, `image`) VALUES ('$admid', '$pcid', '$ccid', '$imid', '$type', '$imageName', '$imgContent')") or die("No Product Item is Added. Error Ask Sagar");
//                             $insert2 = mysqli_query($conn, "insert into pimage (`admid`,`pcid`,`ccid`,`imid`,`category`,`iname`,`image`) VALUES ('$admid','$pcid', '$ccid', '$imid', '$type', '$imageName', '$imgContent')") or die("No Product Item is Added Error Ask Sagar");

//                             if($insert && $insert2)
//                             {
//                                 $status = 'success';
//                                 $statusMsg = "File uploaded successfully.";
//                                 // header("location: main.php?q=0");
//                             }
//                             else
//                             {
//                                 $statusMsg = "File upload failed, please try again."; 
//                             }  
//                         }
//                         else
//                         {
//                             $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
//                         } 
//                     }
//                     else
//                     {
//                         $statusMsg = 'Please select an image file to upload.'; 
//                     } 

//                 }
//             }
//             for ($k = 1; $k <= $_POST["siz" . $i]; $k++) {
//                 if (isset($_POST["siz" . $i])) {
//                     $size = $_POST["size" . $i . "_" . $k];
//                     $qty = $_POST["qty" . $i . "_" . $k];
//                     $szid = uniqid();
                    
//                     $stmt2 = $conn->prepare("insert into size (admid, pcid, ccid, szid, size, qty) VALUES (?, ?, ?, ?, ?, ?)");
//                     $stmt2->bind_param("ssssss", $admid, $pcid, $ccid, $szid, $size, $qty);
//                     $stmt2->execute();
                    
//                     echo "$ccid Size: $size, Quantity: $qty <br>";
//                 }
//             }
//         }
//     }

    
//     $conn->close();

    
//     if ($statusMsg) {
//         echo $statusMsg;
//         header("Location: index.php?q=0");
//     } else {
//         echo "Error: Something went wrong.";
//     }
// }



if (@$_GET['q'] == 'addblog') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

        if ($_SESSION['type'] == 'Viewer') {
            echo "<script>alert('You Arent Authorized.')</script>";
            echo "<script>window.open('index.php?q=8&step=3','_self')</script>";
        }
        else {
            $title = $_POST['title'];
            $content = isset($_POST['content']) ? $_POST['content'] : [];
            $blgid = uniqid();
            $admid = $_SESSION['admid'];
            $numTextareas = count($content);
            
            $targetDir = "../img/blog/$blgid/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
    
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                if (!empty($_FILES["image"]["name"])) {
                    
                    // $link = $_POST["link"];
    
                    $ikd = uniqid();
                
                    $fileName = basename($_FILES["image"]["name"]);
                    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    
                    if (in_array($fileType, $allowTypes)) {
                        $targetFile = $targetDir . $ikd . "_" . $fileName;
                        $dbFile = "img/blog/$blgid/" . $ikd . "_" . $fileName;
    
                        echo $dbFile;
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                            
                            // echo "insert into disimg (`admid`, `discid`, `disimd`, `pgname`, `descp`, `image`, 'position', `link`, `stat`) values ('$admid','$type', '$ikd', Shop, '$disnm', '$dbFile', '$select', '$link', '0')";
                            
                            for ($i = 1; $i <= $numTextareas; $i++) {
                                $contentText = mysqli_real_escape_string($conn, $content[$i]);
                                
                                $bcntid = uniqid();
                                $insert = mysqli_query($conn, "insert into blog_posts (`admid`, `blgid`, `bcntid`, `blgimg`, `title`, `content`, `c_order`) values ('$admid','$blgid', '$bcntid', '$dbFile', '$title', '$contentText', '$i')");
                            }
    
    
                            if ($insert) {
                                $status = 'success';
                                $statusMsg = "File uploaded successfully.";
                            } else {
                                $statusMsg = "File upload failed, please try again.";
                            }
                        } else {
                            $statusMsg = "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } else {
                    $statusMsg = 'Please select an image file to upload.';
                }
           }
    
            if ($statusMsg) {
                echo $statusMsg;
                header("Location: index.php?q=8&step=3");
            } else {
                echo "Error: Something went wrong.";
            }
        }
    }
}

if (@$_GET['q'] == 'addcatg') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=1','_self')</script>";
        exit;
    }

    $catg = trim($_POST['pname'] ?? 'New Collection');
    $descpr = trim($_POST['descpr'] ?? '');
    $descps = mysqli_real_escape_string($conn, $descpr);
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $catg)) ?: ('cat-' . rand(100, 999));
    $ctid = uniqid();
    $admid = $_SESSION['admid'] ?? 'admin';
    $targetFile = '';

    if (!empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) {
            $targetDir = "../img/category/$ctid/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . uniqid() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }
    }

    // Insert into collections table
    $stmt_c = $conn->prepare("INSERT INTO `collections` (`store_id`, `title`, `slug`, `description`, `image_url`, `is_active`, `created_at`) VALUES (1, ?, ?, ?, ?, 1, NOW())");
    $stmt_c->bind_param("ssss", $catg, $slug, $descpr, $targetFile);
    $stmt_c->execute();

    // Legacy table insert
    mysqli_query($conn, "INSERT IGNORE INTO catgory (`admid`, `ctid`, `category`, `descp`, `ctimg`) VALUES ('$admid', '$ctid', '" . mysqli_real_escape_string($conn, $catg) . "', '$descps', '$targetFile')");

    header("Location: index.php?q=1");
    exit;
}

if (@$_GET['q'] == 'addprod') {

    // Other fields
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=1','_self')</script>";
    }
    else {
        $pname = $_POST['pname'];
        $type = $_POST['type'];
        $col = $_POST['col'];
        $desn = $_POST['desn'];
        $disc = $_POST['disc'];
        $keyword = $_POST['keyword'];
        $mrp = $_POST['mrp'];
        $descpm = $_POST['descpm'];
        $admid = $_SESSION['admid'];
        $pcid = uniqid(); // Parent product ID
        $statusMsg = '';

        // Loop for product descriptions
        for ($i = 1; $i <= $desn; $i++) {
            if (isset($_POST["desch" . $i])) {
                $desch = $_POST["desch" . $i];
                $descp = $_POST["descp" . $i];
                $despid = uniqid();

                $stmt1 = $conn->prepare("insert into description (admid, pcid, despid, decph, descp) VALUES (?, ?, ?, ?, ?)");
                $stmt1->bind_param("sssss", $admid, $pcid, $despid, $desch, $descp);
                $stmt1->execute();
                echo "Heading: $desch<br>";
                echo nl2br(htmlspecialchars($descp));
            }
        }

        // Loop for product colors
        for ($i = 1; $i <= $col; $i++) {
            if (isset($_POST["ccode" . $i]) && isset($_POST["cname" . $i])) {
                $colorCode = $_POST["ccode" . $i];
                $colorName = $_POST["cname" . $i];
                $ccid = uniqid(); // Generate a unique CCID for this color

                // Create a directory for each color ID (ccid) under img/products/
                $targetDir = "../img/products/$ccid/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $insert = mysqli_query($conn, "insert into product (`admid`, `pcid`, `ccid`, `keyword`, `category`, `pname`, `descp`, `color`, `ccode`, `mrp`, `disc`) VALUES ('$admid', '$pcid', '$ccid', '$keyword', '$type', '$pname', '$descpm', '$colorName', '$colorCode', '$mrp', '$disc')") or die("No Product Item is Added Error Ask Sagar");

                // Upload images for this product color
                for ($j = 1; $j <= $_POST["iamg" . $i]; $j++) {
                    if (isset($_FILES["image" . $i . "_" . $j]) && $_FILES["image" . $i . "_" . $j]["error"] == UPLOAD_ERR_OK) {
                        $imageFile = $_FILES["image" . $i . "_" . $j];
                        $imageName = $_POST["iname" . $i . "_" . $j];
                        $status = 'error';

                        if (!empty($_FILES["image" . $i . "_" . $j]["name"])) {
                            // Get file details
                            $fileName = basename($_FILES["image" . $i . "_" . $j]["name"]);
                            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                            // Allowed file types
                            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                            if (in_array($fileType, $allowTypes)) {

                                $ikd = uniqid();
                                
                                $targetFile = $targetDir . $ikd . "_" . $fileName;
                                $dbFile = "img/products/$ccid/" . $ikd . "_" . $fileName;
                                // Move the uploaded file to the folder
                                if (move_uploaded_file($_FILES["image" . $i . "_" . $j]["tmp_name"], $targetFile)) {
                                    // Insert image details into the database (storing the file path)
                                    $insert2 = mysqli_query($conn, "INSERT INTO pimage (`admid`, `pcid`, `ccid`, `imid`, `category`, `iname`, `image`) VALUES ('$admid', '$pcid', '$ccid', '" . uniqid() . "', '$type', '$imageName', '$dbFile')") or die("No Product Item is Added. Error Ask Sagar");

                                    if ($insert2) {
                                        $status = 'success';
                                        $statusMsg = "File uploaded successfully.";
                                    } else {
                                        $statusMsg = "File upload failed, please try again.";
                                    }
                                } else {
                                    $statusMsg = "Sorry, there was an error uploading your file.";
                                }
                            } else {
                                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                            }
                        } else {
                            $statusMsg = 'Please select an image file to upload.';
                        }
                    }
                }

                // Loop for sizes
                for ($k = 1; $k <= $_POST["siz" . $i]; $k++) {
                    if (isset($_POST["siz" . $i])) {
                        $size = $_POST["size" . $i . "_" . $k];
                        $qty = $_POST["qty" . $i . "_" . $k];
                        $szid = uniqid();

                        $stmt2 = $conn->prepare("insert into size (admid, pcid, ccid, szid, size, qty) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt2->bind_param("ssssss", $admid, $pcid, $ccid, $szid, $size, $qty);
                        $stmt2->execute();

                        echo "$ccid Size: $size, Quantity: $qty <br>";
                    }
                }
            }
        }

        $conn->close();

        // Redirect or show message based on success or failure
        if ($statusMsg) {
            echo $statusMsg;
            header("Location: index.php?q=0");
        } else {
            echo "Error: Something went wrong.";
        }
    }
}


if (@$_GET['q'] == 'addslg') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=1','_self')</script>";
    }
    else {    
        $sldnm = $_POST['sldnm'];
        $descp = $_POST['descp'];
        $iamg = $_POST['iamg'];
        $admid = $_SESSION['admid'];
        $sldid = uniqid(); 
        $statusMsg = '';

        $stmt1 = $conn->prepare("insert into sliders (admid, sldid, sldnm, descp, sstat) VALUES (?, ?, ?, ?, '0')");
        $stmt1->bind_param("ssss", $admid, $sldid, $sldnm, $descp); 
        $stmt1->execute();
        
        $conn->close();
        header("Location: index.php?q=8&step=2");
    }
}

if (@$_GET['q'] == 'addisc') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8','_self')</script>";
    }
    else {
        $descp = $_POST['descp'];
        $disc = $_POST['disc'];
        $admid = $_SESSION['admid'];
        $disid = uniqid();
        $utype = 'All Users';

        $stmt1 = $conn->prepare("insert into discount (admid, discid, utype, descp, code, dstat) VALUES (?, ?, ?, ?, ?, '0')");
        $stmt1->bind_param("sssss", $admid, $disid, $utype, $descp, $disc); 
        $stmt1->execute();
        
        $conn->close();
        header("Location: index.php?q=8&step=9&page=catg");
    }
}
if (@$_GET['q'] == 'assign') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=5&step=2','_self')</script>";
    }
    else {
        // $descp = $_POST['descp'];
        // $disc = $_POST['disc'];
        $admid = $_GET['admid']; 
        $qid = $_GET['qid']; 
        $disid = uniqid();
        $utype = 'All Users';

        $stmt1 = $conn->prepare("insert into notify (admid, qid, type) VALUES (?, ?, 'Question')");
        $stmt1->bind_param("ss", $admid, $disid); 
        $stmt1->execute();

        $stmt2 = $conn->prepare("update questions set atype = ? where qid = ?");
        $stmt2->bind_param("ss", $admid, $qid); 
        $stmt2->execute();

        $stmt3 = $conn->prepare("delete from notify where qid = ?");
        $stmt3->bind_param("s", $qid);
        $stmt3->execute();
        
        $conn->close();
        header("Location: index.php?q=5&step=2");
    }
}
if (@$_GET['q'] == 'addfaq') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=5&step=2','_self')</script>";
    }
    else {
        $ans = $_POST['answer'];
        $question = $_POST['question'];
        $admid = $_SESSION['admid'];
        $qid = uniqid();

        echo $ans.'<br>';
        echo $qid.'<br>';

        $stmt1 = $conn->prepare("insert into faq (admid, qid, quest, ans) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("ssss", $admid, $qid, $question, $ans); 
        $stmt1->execute();
        
        // $conn->close();
        header("Location: index.php?q=5&step=2");
    }
}

if (@$_GET['q'] == 'ansque') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=5&step=2','_self')</script>";
    }
    else {
        $ans = $_POST['answer'];
        $qid = $_GET['qid'];
        $admid = $_SESSION['admid'];
        $disid = uniqid();
        $utype = 'All Users';

        echo $ans.'<br>';
        echo $qid.'<br>';
        $stmt1 = $conn->prepare("update questions set admid = ?, ans = ?, adate = NOW() where qid = ?");
        $stmt1->bind_param("sss", $admid, $ans, $qid); 
        $stmt1->execute();
        // $stmt1 = $conn->prepare("insert into discount (admid, discid, utype, descp, code, dstat) VALUES (?, ?, ?, ?, ?, '0')");
        
        // $conn->close();
        header("Location: index.php?q=5&step=2");
    }
}

if (@$_GET['q'] == 'addsld') {
    
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=1','_self')</script>";
    }
    else {
        $sldid = $_POST['type'];
        $iamg = $_POST['iamg'];
        $admid = $_SESSION['admid'];
        $statusMsg = '';

        $targetDir = "../img/sliders/$sldid/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        for ($i = 1; $i <= $_POST["iamg"]; $i++) {
            if (isset($_FILES["image_" . $i]) && $_FILES["image_" . $i]["error"] == 0) {
                if (!empty($_FILES["image_" . $i]["name"])) {
                    
                    $iname = $_POST["iname_" . $i];
                    // $igtext = $_POST["igtext_" . $i];
                    $select = $_POST["select_" . $i];
                    $link = $_POST["link_" . $i];
                    $ikd = uniqid();
                
                    $fileName = basename($_FILES["image_" . $i]["name"]);
                    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');

                    if (in_array($fileType, $allowTypes)) {
                        $targetFile = $targetDir . $ikd . "_" . $fileName;
                        $dbFile = "img/sliders/$sldid/" . $ikd . "_" . $fileName;
        
                        if (move_uploaded_file($_FILES["image_" . $i]["tmp_name"], $targetFile)) {

                            $insert = mysqli_query($conn, "insert into slideimg (`admid`, `sldid`, `slimid`, `sldnm`, `sldimg`, `position`, `link`) values ('$admid','$sldid', '$ikd', '$iname', '$dbFile', '$select', '$link')");

                            for ($k = 1; $k <= $_POST["igtxt" . $i]; $k++) {
                                if (isset($_POST["igtxt" . $i])) {
                                    $igtext = $_POST["igtext" . $i . "_" . $k];
                                    $textsz = $_POST["textsz" . $i . "_" . $k];
                                    $color = $_POST["ccode" . $i . "_" . $k];
                                    
                                    $txtid = uniqid();
                
                                    $stmt2 = $conn->prepare("insert into sldtxt (admid, sldid, sldimd, stxtid, igtext, size, color) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                    $stmt2->bind_param("sssssss", $admid, $sldid, $ikd, $txtid, $igtext, $textsz, $color);
                                    $stmt2->execute();
                
                                    // echo "$ccid Size: $size, Quantity: $qty <br>";
                                }
                            }

                            if ($insert) {
                                $status = 'success';
                                $statusMsg = "File uploaded successfully.";
                            } else {
                                $statusMsg = "File upload failed, please try again.";
                            }
                        } else {
                            $statusMsg = "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } else {
                    $statusMsg = 'Please select an image file to upload.';
                }
                

            }
        }

        if ($statusMsg) {
            echo $statusMsg;
            header("Location: index.php?q=8&step=2");
        } else {
            echo "Error: Something went wrong.";
        }
    }
}

if (@$_GET['q'] == 'addpromo') {
    
    // $sldid = $_POST['type'];
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=9&page=catg','_self')</script>";
    }
    else {
        $iamg = 3;
        $admid = $_SESSION['admid'];
        $statusMsg = '';
        $pronm = $_POST["prnm"];
        $prmoid = uniqid();
        
        $targetDir = "../img/promo/$prmoid/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        for ($i = 1; $i <= $iamg; $i++) {
            if (isset($_FILES["image" . $i]) && $_FILES["image" . $i]["error"] == 0) {
                if (!empty($_FILES["image" . $i]["name"])) {
                    
                    // $iname = $_POST["iname_" . $i];
                    // $igtext = $_POST["igtext_" . $i];
                    // $select = $_POST["select_" . $i];
                    $link = $_POST["link" . $i];
                    $ikd = uniqid();
                
                    $fileName = basename($_FILES["image" . $i]["name"]);
                    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');

                    if (in_array($fileType, $allowTypes)) {
                        $targetFile = $targetDir . $ikd . "_" . $fileName;
                        $dbFile = "img/promo/$prmoid/" . $ikd . "_" . $fileName;
        
                        if (move_uploaded_file($_FILES["image" . $i]["tmp_name"], $targetFile)) {

                            $insert = mysqli_query($conn, "insert into promo (`admid`, `prmoid`, `pimgid`, `pronm`, `image`, `link`, `pstat`) values ('$admid','$prmoid', '$ikd', '$pronm', '$dbFile', '$link', '0')");

                            if ($insert) {
                                $status = 'success';
                                $statusMsg = "File uploaded successfully.";
                            } else {
                                $statusMsg = "File upload failed, please try again.";
                            }
                        } else {
                            $statusMsg = "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } else {
                    $statusMsg = 'Please select an image file to upload.';
                }
                

            }
        }

        if ($statusMsg) {
            echo $statusMsg;
            header("Location: index.php?q=8&step=2");
        } else {
            echo "Error: Something went wrong.";
        }
    }
}
if (@$_GET['q'] == 'disimg') {
    
    // $sldid = $_POST['type'];
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8&step=9&page=catg','_self')</script>";
    }
    else {
        // $iamg = 3;
        $admid = $_SESSION['admid'];
        $type = $_POST["type"];
        $statusMsg = '';
        $select = $_POST["select"];
        $disnm = $_POST["disnm"];
        $link = $_POST["link"];

        // echo $type.'<br>';
        echo $admid.'<br>';
        echo $disnm.'<br>';
        echo $type.'<br>';
        echo $select.'<br>';
        echo $link.'<br>';
        // $idscid = uniqid();
        
        $targetDir = "../img/pages/category/$type/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            if (!empty($_FILES["image"]["name"])) {
                
                // $link = $_POST["link"];

                $ikd = uniqid();
            
                $fileName = basename($_FILES["image"]["name"]);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowTypes = array('jpg', 'jpeg', 'png', 'gif');

                if (in_array($fileType, $allowTypes)) {
                    $targetFile = $targetDir . $ikd . "_" . $fileName;
                    $dbFile = "img/pages/category/$type/" . $ikd . "_" . $fileName;

                    echo $dbFile;
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

                        echo "insert into disimg (`admid`, `discid`, `disimd`, `pgname`, `descp`, `image`, 'position', `link`, `stat`) values ('$admid','$type', '$ikd', Shop, '$disnm', '$dbFile', '$select', '$link', '0')";
                        $insert = mysqli_query($conn, "insert into disimg (`admid`, `discid`, `disimd`, `pgname`, `descp`, `image`, `position`, `link`, `stat`) values ('$admid','$type', '$ikd', 'Shop', '$disnm', '$dbFile', '$select', '$link', '0')");

                        for ($k = 1; $k <= $_POST["igtxt"]; $k++) {
                            if (isset($_POST["igtxt"])) {
                                $igtext = $_POST["igtext" . $k];
                                $textsz = $_POST["textsz" . $k];
                                $color = $_POST["ccode" . $k];
                                
                                $txtid = uniqid();
            
                                $stmt2 = $conn->prepare("insert into distxt (admid, discid, disimd, dtxtid, igtext, size, color) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                $stmt2->bind_param("sssssss", $admid, $type, $ikd, $txtid, $igtext, $textsz, $color);
                                $stmt2->execute();
            
                                // echo "$ccid Size: $size, Quantity: $qty <br>";
                            }
                        }


                        if ($insert) {
                            $status = 'success';
                            $statusMsg = "File uploaded successfully.";
                        } else {
                            $statusMsg = "File upload failed, please try again.";
                        }
                    } else {
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                }
            } else {
                $statusMsg = 'Please select an image file to upload.';
            }
       }

        if ($statusMsg) {
            echo $statusMsg;
            header("Location: index.php?q=8&step=9&page=catg");
        } else {
            echo "Error: Something went wrong.";
        }
    }
}


if (@$_GET['q'] == 'selprod') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8','_self')</script>";
    }
    else {
        $descp = $_POST['descp'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $admid = $_SESSION['admid'];
        $utype = 'All Users';
        $funid = uniqid();
        $pos = 'sidebar';
        
        if ($_GET['type'] == "lrgprod") {
            $func = 'lrgprod';
            $no = $_POST["igtxt"];
        }
        elseif ($_GET['type'] == "lstprod") {
            $func = 'lstprod';
            $no = $_POST["list"];
        }
        elseif ($_GET['type'] == "prodtag") {
            $func = 'prodtag';
            $no = $_POST["tag"];
        }
        elseif ($_GET['type'] == "catg") {
            $func = 'categories';
            $no = $_POST["lcatg"];
        }
        
        if ($type == "680a1b1c76486") {
            $pgname = 'Home';
        }
        elseif ($type == "680a1b4d70cb2") {
            $pgname = 'Category';
        }
        elseif ($type == "680a1b577c350") {
            $pgname = 'Product Detail';
        }
        elseif ($type == "680a1b6459ef8") {
            $pgname = 'Cart';
        }
        else {
            $pgname = 'Error';
        }

        $result = $conn->query("SELECT COUNT(funord) AS count FROM pages where pageid='$type' and position='sidebar'");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Count: " . $row['count'];
            
            $cnt = $row['count'];
        }
        $cnt++;

        $stmt1 = $conn->prepare("insert into pages (admid, funid, pageid, pgname, position, function, title, descp, funord, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '1')");
        $stmt1->bind_param("sssssssss", $admid, $funid, $type, $pgname, $pos, $func, $title, $descp, $cnt); 
        $stmt1->execute();


        for ($k = 1; $k <= $no; $k++) {
            $selpr = $_POST['type' . $k];
            echo $_GET['type'];
            if ($_GET['type'] == "prodtag") {
                $pcid = $selpr;
                
                $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, 'None')");
                $stmt2->bind_param("ssss", $admid, $funid, $type, $pcid); 
                $stmt2->execute();
            }
            elseif ($_GET['type'] == "catg") {
                $pcid = $selpr;
                
                $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, 'None')");
                $stmt2->bind_param("ssss", $admid, $funid, $type, $pcid); 
                $stmt2->execute();
            }
            else {
                $query1 = "SELECT * FROM product where ccid='$selpr'";
                $results = mysqli_query($conn, $query1);
                while ($row1 = mysqli_fetch_array($results)) {
                    
                    $pcid = $row1['pcid'];
                    // $key = $row1['keyword'];
                        
                    echo $pcid;
                }
                $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, ?)");
                $stmt2->bind_param("sssss", $admid, $funid, $type, $pcid, $selpr); 
                $stmt2->execute();
            }
        }
        
        $conn->close();
        header("Location: index.php?q=8&step=9&page=index");
    }
}

if (@$_GET['q'] == 'slider') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8','_self')</script>";
    }
    else {
        $slide = $_POST['slide'];
        $type = $_POST['type'];
        $admid = $_SESSION['admid'];
        $funid = uniqid();
        $pos = 'maxbar';
        
        $func = 'slider';

        
        if ($type == "680a1b1c76486") {
            $pgname = 'Home';
        }
        elseif ($type == "680a1b4d70cb2") {
            $pgname = 'Category';
        }
        elseif ($type == "680a1b577c350") {
            $pgname = 'Product Detail';
        }
        elseif ($type == "680a1b6459ef8") {
            $pgname = 'Cart';
        }
        else {
            $pgname = 'Error';
        }

        $result = $conn->query("SELECT COUNT(funord) AS count FROM pages where pageid='$type' and position='maxbar'");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Count: " . $row['count'];
            
            $cnt = $row['count'];
        }
        $cnt++;

        $get_category = "select * from sliders where sldid='$slide'";
        $run_category = mysqli_query($con, $get_category);

        while ($cat_row = mysqli_fetch_array($run_category)) {

            $descp = $cat_row['descp'];
            $title = $cat_row['sldnm'];

        }


        $stmt1 = $conn->prepare("insert into pages (admid, funid, pageid, pgname, position, function, title, descp, funord, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '1')");
        $stmt1->bind_param("sssssssss", $admid, $funid, $type, $pgname, $pos, $func, $title, $descp, $cnt); 
        $stmt1->execute();

    
        $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, 'None')");
        $stmt2->bind_param("ssss", $admid, $funid, $type, $slide); 
        $stmt2->execute();
        
        $conn->close();
        header("Location: index.php?q=8&step=9&page=index");
    }
}

if (@$_GET['q'] == 'maxprod') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8','_self')</script>";
    }
    else {
        $descp = $_POST['descp'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $admid = $_SESSION['admid'];
        $funid = uniqid();
        $pos = 'maxbar';
        
        if ($_GET['type'] == "rowprod") {
            $func = 'rowprod';
            $no = $_POST["row"];
        }
        elseif ($_GET['type'] == "lstprod") {
            $func = 'lstprod';
            $no = $_POST["list"];
        }
        elseif ($_GET['type'] == "prodtag") {
            $func = 'prodtag';
            $no = $_POST["tag"];
        }
        
        if ($type == "680a1b1c76486") {
            $pgname = 'Home';
        }
        elseif ($type == "680a1b4d70cb2") {
            $pgname = 'Category';
        }
        elseif ($type == "680a1b577c350") {
            $pgname = 'Product Detail';
        }
        elseif ($type == "680a1b6459ef8") {
            $pgname = 'Cart';
        }
        else {
            $pgname = 'Error';
        }

        $result = $conn->query("SELECT COUNT(funord) AS count FROM pages where pageid='$type' and position='maxbar'");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Count: " . $row['count'];
            
            $cnt = $row['count'];
        }
        $cnt++;

        $stmt1 = $conn->prepare("insert into pages (admid, funid, pageid, pgname, position, function, title, descp, funord, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '1')");
        $stmt1->bind_param("sssssssss", $admid, $funid, $type, $pgname, $pos, $func, $title, $descp, $cnt); 
        $stmt1->execute();

        for ($k = 1; $k <= $no; $k++) {
            $selpr = $_POST['type' . $k];
            
            $query1 = "SELECT * FROM product where ccid='$selpr'";
            $results = mysqli_query($conn, $query1);
            while ($row1 = mysqli_fetch_array($results)) {
                $pcid = $row1['pcid'];
            }
            
            $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("sssss", $admid, $funid, $type, $pcid, $selpr); 
            $stmt2->execute();
        }
        
        $conn->close();
        header("Location: index.php?q=8&step=9&page=index");
    }
}

if (@$_GET['q'] == 'promo') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8','_self')</script>";
    }
    else {
        $promo = $_POST['promo'];
        $type = $_POST['type'];
        $admid = $_SESSION['admid'];
        $funid = uniqid();
        $pos = 'maxbar';
        
        $func = 'promo';

        
        if ($type == "680a1b1c76486") {
            $pgname = 'Home';
        }
        elseif ($type == "680a1b4d70cb2") {
            $pgname = 'Category';
        }
        elseif ($type == "680a1b577c350") {
            $pgname = 'Product Detail';
        }
        elseif ($type == "680a1b6459ef8") {
            $pgname = 'Cart';
        }
        else {
            $pgname = 'Error';
        }

        $result = $conn->query("SELECT COUNT(funord) AS count FROM pages where pageid='$type' and position='maxbar'");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Count: " . $row['count'];
            
            $cnt = $row['count'];
        }
        $cnt++;

        $get_category = "select * from promo where prmoid='$promo'";
        $run_category = mysqli_query($con, $get_category);

        while ($cat_row = mysqli_fetch_array($run_category)) {
            $title = $cat_row['pronm'];
            $descp = 'Promotion Images Group of 3 Images';
        }


        $stmt1 = $conn->prepare("insert into pages (admid, funid, pageid, pgname, position, function, title, descp, funord, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '1')");
        $stmt1->bind_param("sssssssss", $admid, $funid, $type, $pgname, $pos, $func, $title, $descp, $cnt); 
        $stmt1->execute();

    
        $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, 'None')");
        $stmt2->bind_param("ssss", $admid, $funid, $type, $promo); 
        $stmt2->execute();
        
        $conn->close();
        header("Location: index.php?q=8&step=9&page=index");
    }
}

if (@$_GET['q'] == 'fcatg') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=8','_self')</script>";
    }
    else {
        $descp = $_POST['descp'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $admid = $_SESSION['admid'];
        $funid = uniqid();
        $pos = 'maxbar';
        $func = 'fcatg';
        $no = $_POST["catg"];
        
        if ($type == "680a1b1c76486") {
            $pgname = 'Home';
        }
        elseif ($type == "680a1b4d70cb2") {
            $pgname = 'Category';
        }
        elseif ($type == "680a1b577c350") {
            $pgname = 'Product Detail';
        }
        elseif ($type == "680a1b6459ef8") {
            $pgname = 'Cart';
        }
        else {
            $pgname = 'Error';
        }

        $result = $conn->query("SELECT COUNT(funord) AS count FROM pages where pageid='$type' and position='maxbar'");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Count: " . $row['count'];
            
            $cnt = $row['count'];
        }
        $cnt++;

        $stmt1 = $conn->prepare("insert into pages (admid, funid, pageid, pgname, position, function, title, descp, funord, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '1')");
        $stmt1->bind_param("sssssssss", $admid, $funid, $type, $pgname, $pos, $func, $title, $descp, $cnt); 
        $stmt1->execute();

        for ($k = 1; $k <= $no; $k++) {
            $selpr = $_POST['ctyp' . $k];
            
            $stmt2 = $conn->prepare("insert into selprodt (admid, funid, pageid, pcid, ccid) VALUES (?, ?, ?, ?, 'None')");
            $stmt2->bind_param("ssss", $admid, $funid, $type, $selpr); 
            $stmt2->execute();
        }
        
        $conn->close();
        header("Location: index.php?q=8&step=9&page=index");
    }
}

if (@$_GET['q'] == 'upfaq') {
    if ($_SESSION['type'] == 'Viewer') {
        echo "<script>alert('You Arent Authorized.')</script>";
        echo "<script>window.open('index.php?q=5&step=2','_self')</script>";
    }
    else {
        $qid = $_GET['qid'];
        $question = $_POST['question'];
        $ans = $_POST['answer'];
        $admid = $_SESSION['admid'];

        echo $ans.'<br>';
        echo $qid.'<br>';
        
        // $conn->close();
        header("Location: index.php?q=5&step=2");
    }
}
?>