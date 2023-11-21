<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
          <li><a href="<?= site_url('store/admin') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/admin/products') ?>"><?= lang('products') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('products') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <ul class="uk-nav-default" uk-nav>
            <li class="uk-nav-header"><?= lang('menu') ?></li>
            <li><a href="<?= site_url('store/admin') ?>"><?= lang('dashboard') ?></a></li>
            <li><a href="<?= site_url('store/admin/settings') ?>"><?= lang('settings') ?></a></li>
            <li class="uk-parent uk-open">
              <a href="#">
                <?= lang('catalog') ?> <span uk-nav-parent-icon></span>
              </a>
              <ul class="uk-nav-sub">
                <li><a href="<?= site_url('store/admin/categories') ?>"><?= lang('categories') ?></a>
                <li class="uk-active"><a href="<?= site_url('store/admin/products') ?>"><?= lang('products') ?></a></li>
              </ul>
            </li>
            <li><a href="<?= site_url('store/admin/orders') ?>"><?= lang('orders') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <div class="uk-card uk-card-default uk-card-header uk-margin">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
              <p class="uk-text-small uk-margin-remove"><?= lang('product_commands') ?></p>
              <h3 class="uk-card-title uk-margin-remove"><?= html_escape($product->name) ?></h3>
            </div>
            <div class="uk-width-auto">
              <a href="<?= site_url('store/admin/products/'.$product->id.'/add') ?>" class="uk-button uk-button-default uk-button-small"><i class="fa-solid fa-pen"></i> <?= lang('add') ?></a>
            </div>
          </div>
        </div>
        <div class="uk-grid-small uk-child-width-1-1" uk-grid>
          <?php foreach ($commands as $item): ?>
          <div>
            <div class="uk-card uk-card-default uk-card-body">
              <div class="uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                  <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon"><i class="fa-solid fa-feather"></i></span>
                    <input class="uk-input uk-form-small" type="text" value="<?=  $item->command ?>" readonly>
                  </div>
                </div>
                <div class="uk-width-auto">
                  <div class="uk-button-group">
                    <a href="<?= site_url('store/admin/products/'.$product->id.'/edit/'.$item->id) ?>" class="uk-button uk-button-primary uk-button-small"><?= lang('edit') ?></a>
                    <div class="uk-inline">
                      <button class="uk-button uk-button-primary uk-button-small" type="button"><i class="fa-solid fa-caret-down"></i></button>
                      <div uk-dropdown="mode: click; boundary: ! .uk-container">
                        <ul class="uk-nav uk-dropdown-nav">
                          <li><a href="<?= site_url('store/admin/products/'.$product->id.'/delete/'.$item->id) ?>" class="uk-text-danger"><span class="bc-li-icon"><i class="fa-solid fa-trash-can"></i></span><?= lang('delete') ?></a></li>
                        </ul>
                      </div>
                    </div>
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
