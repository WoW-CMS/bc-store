<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
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
            <li class="uk-active">
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
        <div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
         <?php foreach ($this->store_product_model->top() as $item): ?>
          <div>
            <div class="uk-card uk-card-default">
              <div class="uk-card-media-top uk-cover-container">
                <img src="<?= $template['uploads'].$item->image ?>" alt="<?= $item->name ?>" uk-cover>
                <canvas width="300" height="300"></canvas>
              </div>
              <div class="uk-card-body uk-text-break">
                <h5 class="uk-h5 uk-margin-remove"><?= html_escape($item->name) ?></h5>
                <p class="uk-text-small uk-margin-remove-top uk-margin-small-bottom"><?= html_escape($item->description) ?></p>
                <h6 class="uk-h6 uk-margin-remove"><?= lang('price') ?>:</h6>
                <?php if ($item->currency === CURRENCY_DP): ?>
                <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $item->dp ?></span>
                <?php elseif ($item->currency === CURRENCY_VP): ?>
                <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $item->vp ?></span>
                <?php elseif ($item->currency === CURRENCY_BOTH): ?>
                <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $item->dp ?></span> &amp; <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $item->vp ?></span>
                <?php endif ?>
                <a href="<?= site_url('store/product/'.$item->id) ?>" class="uk-button uk-button-default uk-button-small uk-width-1-1 uk-margin-small-top"><?= lang('view_product') ?></a>
              </div>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</section>
