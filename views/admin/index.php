<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('store') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <ul class="uk-nav-default" uk-nav>
            <li class="uk-nav-header"><?= lang('menu') ?></li>
            <li class="uk-active"><a href="<?= site_url('store/admin') ?>"><?= lang('dashboard') ?></a></li>
            <li><a href="<?= site_url('store/admin/settings') ?>"><?= lang('settings') ?></a></li>
            <li class="uk-parent">
              <a href="#">
                <?= lang('catalog') ?> <span uk-nav-parent-icon></span>
              </a>
              <ul class="uk-nav-sub">
                <li><a href="<?= site_url('store/admin/categories') ?>"><?= lang('categories') ?></a>
                <li><a href="<?= site_url('store/admin/products') ?>"><?= lang('products') ?></a></li>
              </ul>
            </li>
            <li><a href="<?= site_url('store/admin/orders') ?>"><?= lang('orders') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <div class="uk-grid-match uk-child-width-1-1 uk-child-width-1-3@s uk-margin-small" uk-grid>
          <div>
            <div class="uk-card uk-card-default uk-card-body">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-auto">
                  <span class="fa-stack bc-stack-medium">
                    <span class="bc-color-blue bc-icon-drop-shadow">
                      <i class="fa-solid fa-circle fa-stack-2x"></i>
                    </span>
                    <i class="fa-solid fa-tags fa-stack-1x fa-inverse"></i>
                  </span>
                </div>
                <div class="uk-width-expand">
                  <h3 class="uk-h3 uk-text-bold uk-margin-remove"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="<?= $total_categories ?>">0</span></h3>
                  <p class="uk-text-meta uk-margin-remove"><?= lang('categories_added') ?></p>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="uk-card uk-card-default uk-card-body">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-auto">
                  <span class="fa-stack bc-stack-medium">
                    <span class="bc-color-pink bc-icon-drop-shadow">
                      <i class="fa-solid fa-circle fa-stack-2x"></i>
                    </span>
                    <i class="fa-solid fa-box fa-stack-1x fa-inverse"></i>
                  </span>
                </div>
                <div class="uk-width-expand">
                  <h3 class="uk-h3 uk-text-bold uk-margin-remove"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="<?= $total_products ?>">0</span></h3>
                  <p class="uk-text-meta uk-margin-remove"><?= lang('products_added') ?></p>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="uk-card uk-card-default uk-card-body">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-auto">
                  <span class="fa-stack bc-stack-medium">
                    <span class="bc-color-violet bc-icon-drop-shadow">
                      <i class="fa-solid fa-circle fa-stack-2x"></i>
                    </span>
                    <i class="fa-solid fa-cart-shopping fa-stack-1x fa-inverse"></i>
                  </span>
                </div>
                <div class="uk-width-expand">
                  <h3 class="uk-h3 uk-text-bold uk-margin-remove"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="<?= $total_purchases ?>">0</span></h3>
                  <p class="uk-text-meta uk-margin-remove"><?= lang('total_purchases') ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-margin" uk-grid>
          <div class="uk-width-3-5@s uk-width-2-3@m">
            <div class="uk-card uk-card-default uk-margin">
              <div class="uk-card-header">
                <h3 class="uk-card-title"><i class="fa-solid fa-ellipsis-vertical"></i> <?= lang('latest_purchases') ?></h3>
              </div>
              <div class="uk-card-body uk-padding-remove">
                <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
                  <thead>
                    <tr>
                      <th><?= lang('id') ?></th>
                      <th class="uk-table-shrink"><?= lang('user') ?></th>
                      <th class="uk-width-medium"><?= lang('purchased_products') ?></th>
                      <th class="uk-width-medium"><?= lang('created_at') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($latest_orders as $item): ?>
                    <tr>
                      <td><?= $item->id ?></td>
                      <td class="uk-text-center">
                        <img class="uk-preserve-width uk-border-circle" src="<?= user_avatar($item->user_id) ?>" width="32" height="32" alt="<?= $item->username ?>" uk-tooltip="<?= $item->username ?>">
                      </td>
                      <td><?= $item->total_products ?></td>
                      <td>
                        <time datetime="<?= $item->created_at ?>"><?= locate_date($item->created_at) ?></time>
                      </td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="uk-width-2-5@s uk-width-1-3@m"></div>
        </div>
      </div>
    </div>
  </div>
</section>
