<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">

  <!-- Header Banner -->
  <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #111217 0%, #1e1f26 100%); color: #fff; border-radius: 16px;">
    <div class="card-body p-4">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
          <span class="badge badge-warning text-uppercase px-2.5 py-1 mb-2 font-weight-bold" style="letter-spacing: 0.1em; background: rgba(233, 193, 118, 0.2); color: #e9c176; border: 1px solid rgba(233, 193, 118, 0.3);">
            ✦ DTC Merchandising &amp; Bundle Engine
          </span>
          <h2 class="h3 font-weight-bold mb-1 text-white">Coordinated Ensemble Packs &amp; Looks</h2>
          <p class="text-white-50 mb-0 small">
            Configure multi-item pack discounts (3-piece &amp; 2-piece tier privileges), curate coordinated wardrobe archetypes, and control in-cart bundle behavior.
          </p>
        </div>
        <div class="d-flex gap-2">
          <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-light btn-sm font-weight-bold px-3" style="border-radius: 8px;">
            <i class="fas fa-external-link-alt mr-1"></i> Preview Storefront
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
      <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <div class="row">
    
    <!-- Left Column: Pack Discounts & Global Configuration (5 cols) -->
    <div class="col-lg-5 mb-4">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
          <h5 class="font-weight-bold text-dark mb-1">
            <i class="fas fa-percentage text-warning mr-1.5"></i> Tiered Pack Discounts
          </h5>
          <p class="text-muted small mb-0">Control the automatic bundle discounts offered when customers acquire complete looks.</p>
        </div>
        <div class="card-body px-4 pt-3">
          <form method="post" action="<?= base_url('admin/promotions/ensembles') ?>">
            <input type="hidden" name="action" value="save_discounts">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <!-- 3-Item Bundle Discount -->
            <div class="form-group mb-3">
              <label class="font-weight-bold text-dark small mb-1">
                3-Piece Complete Pack Discount (%)
              </label>
              <div class="input-group">
                <input type="number" step="0.5" min="0" max="90" name="bundle_discount_3" class="form-control font-weight-bold" value="<?= htmlspecialchars((string)$b3_discount) ?>" required style="border-radius: 10px 0 0 10px;">
                <div class="input-group-append">
                  <span class="input-group-text bg-light font-weight-bold text-muted" style="border-radius: 0 10px 10px 0;">% OFF</span>
                </div>
              </div>
              <small class="form-text text-muted">Applied when user acquires all 3 pieces (Top + Bottom + Footwear). Default: 15%</small>
            </div>

            <!-- 2-Item Bundle Discount -->
            <div class="form-group mb-3">
              <label class="font-weight-bold text-dark small mb-1">
                2-Piece Pair Pack Discount (%)
              </label>
              <div class="input-group">
                <input type="number" step="0.5" min="0" max="90" name="bundle_discount_2" class="form-control font-weight-bold" value="<?= htmlspecialchars((string)$b2_discount) ?>" required style="border-radius: 10px 0 0 10px;">
                <div class="input-group-append">
                  <span class="input-group-text bg-light font-weight-bold text-muted" style="border-radius: 0 10px 10px 0;">% OFF</span>
                </div>
              </div>
              <small class="form-text text-muted">Applied when user removes 1 item and acquires 2 pieces. Default: 10%</small>
            </div>

            <!-- 1-Item Single Piece Notice -->
            <div class="p-3 bg-light rounded mb-3 text-muted small border">
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-info-circle text-primary"></i>
                <span><strong>1-Piece Single Acquisition:</strong> Billed at regular retail price (0% discount).</span>
              </div>
            </div>

            <hr class="my-3">

            <!-- Toggles -->
            <div class="custom-control custom-switch mb-3">
              <input type="checkbox" class="custom-control-input" id="bundleEnabledSwitch" name="bundle_discount_enabled" value="1" <?= $b_enabled ? 'checked' : '' ?>>
              <label class="custom-control-label font-weight-bold text-dark small" for="bundleEnabledSwitch">
                Enable Pack Discounts Across Storefront &amp; Cart
              </label>
              <small class="text-muted d-block">Enables real-time strikethrough pricing and pack privilege tags.</small>
            </div>

            <div class="custom-control custom-switch mb-4">
              <input type="checkbox" class="custom-control-input" id="bundleFreeShipSwitch" name="bundle_free_shipping" value="1" <?= $b_freeship ? 'checked' : '' ?>>
              <label class="custom-control-label font-weight-bold text-dark small" for="bundleFreeShipSwitch">
                Complimentary White-Glove Insured Delivery on Ensemble Packs
              </label>
              <small class="text-muted d-block">Unlocks 100% free insured shipping automatically for multi-item packs.</small>
            </div>

            <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2.5 shadow-sm" style="border-radius: 10px; background: #111217; border-color: #111217;">
              <i class="fas fa-save mr-1.5"></i> Save Pack Discount Settings
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Right Column: Curated Ensemble Looks (7 cols) -->
    <div class="col-lg-7 mb-4">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bold text-dark mb-1">
              <i class="fas fa-tshirt text-primary mr-1.5"></i> Coordinated Looks Catalog
            </h5>
            <p class="text-muted small mb-0">Active wardrobe looks displayed in the Atelier Concierge modal and AI Style Identity.</p>
          </div>
          <span class="badge badge-success px-2.5 py-1 font-weight-bold">3 Active Looks</span>
        </div>

        <div class="card-body px-4 pt-3">
          
          <!-- Look 1 -->
          <div class="card mb-3 border bg-light" style="border-radius: 12px;">
            <div class="card-body p-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                  <span class="badge badge-dark font-weight-bold">01</span>
                  <h6 class="font-weight-bold mb-0 text-dark">The Executive Suiting Look</h6>
                </div>
                <span class="badge badge-pill badge-primary">Formal &amp; Sharp</span>
              </div>
              <p class="text-muted small mb-2">Double-Faced Cashmere Cocoon Coat + Okayama Selvedge Denim + Italian Chelsea Boots</p>
              <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Top: 100% Cashmere Coat</span>
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Bottom: 14.5oz Denim (28-38)</span>
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Shoes: Calfskin Boot (UK 7-11)</span>
              </div>
            </div>
          </div>

          <!-- Look 2 -->
          <div class="card mb-3 border bg-light" style="border-radius: 12px;">
            <div class="card-body p-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                  <span class="badge badge-dark font-weight-bold">02</span>
                  <h6 class="font-weight-bold mb-0 text-dark">The Tailored Atelier Classic</h6>
                </div>
                <span class="badge badge-pill badge-warning text-dark">Autumnal Layering</span>
              </div>
              <p class="text-muted small mb-2">Cashmere Turtleneck Knit + Italian Pleated Wool Trousers + Calfskin Penny Loafers</p>
              <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Top: Ribbed Turtleneck (XS-XXL)</span>
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Bottom: Pleated Wool (28-38)</span>
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Shoes: Penny Loafers (UK 7-11)</span>
              </div>
            </div>
          </div>

          <!-- Look 3 -->
          <div class="card mb-3 border bg-light" style="border-radius: 12px;">
            <div class="card-body p-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                  <span class="badge badge-dark font-weight-bold">03</span>
                  <h6 class="font-weight-bold mb-0 text-dark">The Monochromatic Street Look</h6>
                </div>
                <span class="badge badge-pill badge-info">Architectural Casual</span>
              </div>
              <p class="text-muted small mb-2">Sculpted 500 GSM Terry Hoodie + Okayama Selvedge Denim + Minimalist Suede Derby</p>
              <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Top: Heavyweight Terry (XS-XXL)</span>
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Bottom: Selvedge Denim (28-38)</span>
                <span class="badge badge-secondary"><i class="fas fa-check mr-1"></i> Shoes: Suede Derby (UK 7-11)</span>
              </div>
            </div>
          </div>

          <!-- Storefront Integration Status -->
          <div class="p-3 rounded border border-success bg-white d-flex align-items-center justify-between">
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-check-circle text-success fa-lg"></i>
              <div>
                <strong class="d-block text-dark small font-weight-bold">Dynamic Sizing &amp; Cart Sync Active</strong>
                <span class="text-muted small">Category-accurate sizes (Jeans in 28-38, Footwear in UK 6-11, Tops in XS-XXL) synced with cart.</span>
              </div>
            </div>
            <span class="badge badge-light border font-weight-bold">Live</span>
          </div>

        </div>
      </div>
    </div>

  </div>

</div>
