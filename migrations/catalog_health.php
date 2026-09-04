<?php
require_once __DIR__ . '/../config.php';
$pdo = new PDO(
    sprintf("mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4", getenv("DB_HOST")?:"127.0.0.1", getenv("DB_PORT")?:"3306", getenv("DB_NAME")?:"novadrop"),
    getenv("DB_USER")?:"root", getenv("DB_PASS")?:"",
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
);

// Image column is 'url' not 'image_url'
echo "=== IMAGE SAMPLE (using url col) ===\n";
foreach($pdo->query("SELECT product_id, url, is_primary FROM product_images LIMIT 15")->fetchAll() as $r)
    echo "prod:{$r['product_id']} primary:{$r['is_primary']} ".substr($r['url'],0,80)."\n";

// Variant inventory_qty
echo "\n=== VARIANT INVENTORY_QTY ===\n";
foreach($pdo->query("SELECT id, product_id, sku, inventory_qty, is_active FROM product_variants ORDER BY product_id LIMIT 40")->fetchAll() as $r)
    echo "var:{$r['id']} prod:{$r['product_id']} sku:{$r['sku']} qty:{$r['inventory_qty']} active:{$r['is_active']}\n";

// Products with vendor string (check if vendor field is blank = orphan)
echo "\n=== BLANK VENDOR FIELD ===\n";
$bv=$pdo->query("SELECT id, title, status FROM products WHERE vendor IS NULL OR vendor=''")->fetchAll();
echo "Count: ".count($bv)."\n";
foreach($bv as $r) echo "ID:{$r['id']} {$r['status']} ".substr($r['title'],0,40)."\n";

// Products 104/105 look like duplicates
echo "\n=== POTENTIAL DUPLICATE PRODUCTS ===\n";
$dups=$pdo->query("SELECT title, COUNT(*) cnt FROM products GROUP BY title HAVING cnt>1")->fetchAll();
echo "Count: ".count($dups)."\n";
foreach($dups as $r) echo "TITLE:".substr($r['title'],0,60)." count:{$r['cnt']}\n";

// Product 103 is draft — check if it's a copy
echo "\n=== DRAFT PRODUCTS ===\n";
foreach($pdo->query("SELECT id, title, status, created_at FROM products WHERE status='draft'")->fetchAll() as $r)
    echo "ID:{$r['id']} {$r['status']} created:{$r['created_at']} ".substr($r['title'],0,40)."\n";

// Vendor 3 status check
echo "\n=== VENDORS ===\n";
foreach($pdo->query("SELECT id, business_name, status, kyc_status, email FROM vendors")->fetchAll() as $r)
    echo "ID:{$r['id']} status:{$r['status']} kyc:{$r['kyc_status']} {$r['business_name']}\n";

// Collections list
echo "\n=== COLLECTIONS ===\n";
foreach($pdo->query("SELECT id, title, slug, status FROM collections LIMIT 10")->fetchAll() as $r)
    echo "ID:{$r['id']} slug:{$r['slug']} status:{$r['status']} {$r['title']}\n";

// .htaccess
echo "\n=== HTACCESS ===\n";
$ht=file_get_contents(__DIR__."/../.htaccess");
echo substr($ht, 0, 800)."\n";

// .gitignore
echo "\n=== GITIGNORE ===\n";
$gi=file_get_contents(__DIR__."/../.gitignore");
echo $gi;

// db.php check — does it have hardcoded creds?
echo "\n=== DB.PHP FIRST 60 LINES ===\n";
$lines=file(__DIR__."/../db.php");
for($i=0;$i<min(60,count($lines));$i++) echo $lines[$i];

echo "\n=== AGENTS WIRED CHECK ===\n";
foreach(glob(__DIR__."/../application/core/agents/*.php") as $f) {
    $name=basename($f,".php");
    $found=shell_exec("grep -rl ".escapeshellarg($name)." ".__DIR__."/../application/modules/ 2>&1");
    echo "$name: ".(trim($found)?"WIRED":"NOT WIRED")."\n";
}

echo "\n=== HOME_SETTINGS ===\n";
foreach($pdo->query("SELECT * FROM home_settings LIMIT 1")->fetchAll() as $r) {
    foreach($r as $k=>$v) echo "$k: ".substr((string)$v,0,60)."\n";
}

echo "\n=== Done ===\n";
