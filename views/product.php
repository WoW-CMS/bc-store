<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('store') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/category/'.$category->slug) ?>"><?= html_escape($category->name) ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('store') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-rectangle-list"></i> <?= lang('categories') ?></h3>
          </div>
          <ul class="uk-nav-default" uk-nav>
            <li>
              <a href="<?= site_url('store') ?>"><?= lang('top_products') ?></a>
            </li>
            <?php foreach ($categories as $cat): ?>
            <?php if ($cat->type === ITEM_DROPDOWN): ?>
            <li class="uk-parent">
              <a href="#">
                <?= $cat->name ?> <span uk-nav-parent-icon></span>
              </a>
              <ul class="uk-nav-sub" uk-nav>
                <?php foreach ($cat->childs as $catsub): ?>
                <li>
                  <a href="<?= site_url('store/category/'.$catsub->slug) ?>"><?= $catsub->name ?></a>
                </li>
                <?php endforeach ?>
              </ul>
            </li>
            <?php else: ?>
            <li>
              <a href="<?= site_url('store/category/'.$cat->slug) ?>"><?= $cat->name ?></a>
            </li>
            <?php endif ?>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <div class="uk-width-2-3@s uk-width-3-4@m">
        <?= $template['partials']['alerts'] ?>
        <div class="uk-margin" uk-grid>
          <div class="uk-width-1-3@m">
            <div class="uk-cover-container uk-height-medium">
              <img src="<?= $template['uploads'].$product->image ?>" alt="<?= html_escape($product->name) ?>" uk-cover>
            </div>
          </div>
          <div class="uk-width-2-3@m">
            <h3 class="uk-h4 uk-text-bold uk-text-break uk-margin-remove"><?= html_escape($product->name) ?></h3>
            <hr class="uk-hr uk-margin-remove">
            <div class="uk-margin-small-top uk-margin-bottom uk-text-break">
              <?= html_escape($product->description) ?>
            </div>
            <h6 class="uk-h6 uk-text-bold uk-margin-small-top uk-margin-remove-bottom"><?= lang('price') ?>:</h6>
            <?php if ($product->currency === CURRENCY_DP): ?>
            <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $product->dp ?></span>
            <?php elseif ($product->currency === CURRENCY_VP): ?>
            <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $product->vp ?></span>
            <?php elseif ($product->currency === CURRENCY_BOTH): ?>
            <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $product->dp ?></span> &amp; <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $product->vp ?></span>
            <?php endif ?>
            <h6 class="uk-h6 uk-text-bold uk-margin-small-top uk-margin-remove-bottom"><?= lang('realm') ?>:</h6>
            <?= $this->realm_model->get_name($product->realm_id) ?>
            <?= form_open(current_url()) ?>
              <h6 class="uk-h6 uk-text-bold uk-margin-small-top uk-margin-remove-bottom"><?= lang('character') ?>:</h6>
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-3-5@s">
                  <select class="uk-select tail-single" id="select_character" name="guid" autocomplete="off" data-placeholder="<?= lang('select_character') ?>">
                    <?php foreach ($characters as $character): ?>
                    <option value="<?= $character->guid ?>"><?= $character->name ?></option>
                    <?php endforeach ?>
                  </select>
                  <?= form_error('guid', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-expand@s"></div>
              </div>
              <h6 class="uk-h6 uk-text-bold uk-margin-small-top uk-margin-remove-bottom"><?= lang('quantity') ?>:</h6>
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-3 uk-width-1-5@s">
                  <input class="uk-input uk-width-small" type="number" name="qty" value="1" autocomplete="off">
                </div>
                <div class="uk-width-2-3 uk-width-2-5@s">
                  <button class="uk-button uk-button-default uk-margin-small" type="submit"><?= lang('add_cart') ?></button>
                </div>
              </div>
              <?= form_error('qty', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            <?= form_close() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
