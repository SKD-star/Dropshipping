<div class="container" style="padding-top:40px;padding-bottom:80px">
  <div style="font-size:12px;color:var(--text-3);margin-bottom:16px">
    <a href="<?= base_url('account') ?>">My Account</a> / <span>Wishlist</span>
  </div>

  <h1 style="font-size:28px;font-weight:800;margin-bottom:28px">My Wishlist (<?= count($wishlist) ?>)</h1>

  <?php if (empty($wishlist)): ?>
    <div style="background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center;max-width:500px;margin:0 auto">
      <div style="font-size:48px;margin-bottom:12px">♡</div>
      <h2 style="font-size:18px;font-weight:700;margin-bottom:8px">Your wishlist is empty</h2>
      <p style="color:var(--text-2);font-size:14px;margin-bottom:24px">Tap the heart icon on any product to save items you love for later.</p>
      <a href="<?= base_url('shop') ?>" class="nd-btn nd-btn-primary">Browse Catalog</a>
    </div>
  <?php else: ?>
    <div class="nd-products-grid" style="grid-template-columns:repeat(4, 1fr)">
      <?php foreach ($wishlist as $item): ?>
      <div class="nd-product-card" onclick="window.location='<?= base_url('product/' . $item['slug']) ?>'">
        <div class="nd-product-img-wrap">
          <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://picsum.photos/seed/' . $item['product_id'] . '/400/400') ?>" alt="<?= htmlspecialchars($item['title']) ?>">
          <button class="nd-product-quick-add" onclick="event.stopPropagation();addToCart(<?= $item['product_id'] ?>)">🛒 Add to Cart</button>
        </div>
        <div class="nd-product-info">
          <div class="nd-product-name"><?= htmlspecialchars($item['title']) ?></div>
          <div class="nd-product-price-row">
            <span class="nd-product-price">₹<?= number_format($item['min_price'], 0) ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
