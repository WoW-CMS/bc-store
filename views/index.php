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
              <a href="<?= site_url('store') ?>"><?= lang('home') ?></a>
            </li>
            <?php foreach ($categories as $cat): ?>
            <?php if ($cat->type === ITEM_DROPDOWN): ?>
            <li class="uk-parent">
              <a href="#">
                <?= $cat->name ?> <span uk-nav-parent-icon></span>
              </a>
              <ul class="uk-nav-sub" uk-nav>
                <?php foreach ($cat->childs as $catsub): ?>
                <li class="<?= is_route_active('store/category/'.$subitem->slug) ? 'uk-active' : '' ?>">
                  <a href="<?= site_url('store/category/'.$catsub->slug) ?>"><?= $catsub->name ?></a>
                </li>
                <?php endforeach ?>
              </ul>
            </li>
            <?php elseif ($cat->type === ITEM_LINK): ?>
            <li class="<?= is_route_active('store/category/'.$cat->slug) ? 'uk-active' : '' ?>">
              <a href="<?= site_url('store/category/'.$cat->slug) ?>"><?= $cat->name ?></a>
            </li>
            <?php endif ?>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <div class="uk-width-2-3@s uk-width-3-4@m">
        <h4 class="uk-h4 uk-text-bold uk-margin-small"><?= lang('featured_products') ?></h4>
        <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid uk-height-match="target: > div > .uk-card .uk-card-body">
         <?php foreach ($products as $item): ?>
          <div>
            <div class="uk-card uk-card-default">
              <div class="uk-card-body">
                <div class="uk-cover-container uk-border-rounded uk-margin-small-bottom">
                  <canvas width="300" height="150"></canvas>
                  <img src="<?= $template['uploads'].$item->image ?>" alt="<?= html_escape($item->name) ?>" uk-cover>
                </div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-text-meta" uk-grid>
                  <div class="uk-width-auto">
                    <span uk-tooltip="<?= lang('realm') ?>"><?= html_escape($item->realm_name) ?></span>
                  </div>
                  <div class="uk-width-expand"></div>
                </div>
                <h5 class="uk-h5 uk-text-bold uk-margin-remove">
                  <a href="<?= site_url('store/product/'.$item->id) ?>" class="uk-link-reset"><?= html_escape($item->name) ?></a>
                </h5>
              </div>
              <div class="uk-card-footer">
                <div class="uk-grid-small uk-margin-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-small uk-text-bold uk-margin-remove"><?= lang('price') ?>:</p>
                    <?php if ($item->currency === Store_product_model::CURRENCY_DP): ?>
                    <span class="bc-dp-points"><?= $item->dp ?></span>
                    <?php elseif ($item->currency === Store_product_model::CURRENCY_VP): ?>
                    <span class="bc-vp-points"><?= $item->vp ?></span>
                    <?php elseif ($item->currency === Store_product_model::CURRENCY_BOTH): ?>
                    <span class="bc-dp-points"><?= $item->dp ?></span> <?= lang('and') ?> <span class="bc-vp-points"><?= $item->vp ?></span>
                    <?php elseif ($item->currency === Store_product_model::CURRENCY_CHOICE): ?>
                    <span class="bc-dp-points"><?= $item->dp ?></span> <?= lang('or') ?> <span class="bc-vp-points"><?= $item->vp ?></span>
                    <?php endif ?>
                  </div>
                  <div class="uk-width-auto">
                    <a href="<?= site_url('store/product/'.$item->id) ?>" class="uk-button uk-button-default uk-button-small"><i class="fa-solid fa-eye"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</section>
