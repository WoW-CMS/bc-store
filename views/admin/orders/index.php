<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
          <li><a href="<?= site_url('store/admin') ?>"><?= lang('store') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('orders') ?></h1>
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
            <li class="uk-parent">
              <a href="#">
                <?= lang('catalog') ?> <span uk-nav-parent-icon></span>
              </a>
              <ul class="uk-nav-sub">
                <li><a href="<?= site_url('store/admin/categories') ?>"><?= lang('categories') ?></a>
                <li><a href="<?= site_url('store/admin/products') ?>"><?= lang('products') ?></a></li>
              </ul>
            </li>
            <li class="uk-active"><a href="<?= site_url('store/admin/orders') ?>"><?= lang('orders') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <div class="uk-grid-small uk-margin-small uk-flex uk-flex-middle" uk-grid>
              <div class="uk-width-expand">
                <h3 class="uk-card-title"><?= lang('orders') ?></h3>
              </div>
              <div class="uk-width-auto">
                <button class="uk-button uk-button-default uk-button-small" type="button" uk-toggle="target: #filter_toggle; animation: uk-animation-slide-top-small"><i class="fa-solid fa-filter"></i></button>
              </div>
            </div>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <div id="filter_toggle" class="uk-padding-small" hidden>
              <h6 class="uk-h6 uk-text-bold uk-text-uppercase uk-margin-small"><i class="fa-solid fa-filter fa-lg"></i> <?= lang('filter') ?></h6>
              <form action="<?= current_url() ?>" method="get" accept-charset="utf-8">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-expand@s">
                    <div class="uk-inline uk-width-1-1">
                      <span class="uk-form-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                      <input class="uk-input" type="text" name="search" value="<?= $search ?>" placeholder="<?= lang('search') ?>" autocomplete="off">
                    </div>
                  </div>
                  <div class="uk-width-auto@s">
                    <button class="uk-button uk-button-primary" type="submit"><?= lang('search') ?></button>
                  </div>
                </div>
              </form>
            </div>
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-middle uk-table-divider uk-table-small uk-margin-remove">
                <thead>
                  <tr>
                    <th><?= lang('id') ?></th>
                    <th class="uk-table-shrink"><?= lang('user') ?></th>
                    <th class="uk-width-small"><?= lang('products_sold') ?></th>
                    <th class="uk-width-small"><?= lang('status') ?></th>
                    <th class="uk-width-medium uk-visible@s"><?= lang('date') ?></th>
                    <th class="uk-width-small"><?= lang('actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orders as $item): ?>
                  <tr>
                    <td><?= $item->id ?></td>
                    <td class="uk-text-center">
                      <img class="uk-preserve-width uk-border-circle" src="<?= user_avatar($item->user_id) ?>" width="32" height="32" alt="<?= $item->username ?>" uk-tooltip="<?= $item->username ?>">
                    </td>
                    <td><?= $item->products_sold ?></td>
                    <td><span class="uk-label"><?= $item->status ?></span></td>
                    <td class="uk-visible@s">
                      <time datetime="<?= $item->created_at ?>"><?= locate_date($item->created_at) ?></time>
                    </td>
                    <td>
                      <a href="<?= site_url('store/admin/orders/view/'.$item->id) ?>" class="uk-button uk-button-primary uk-button-small"><?= lang('view') ?></a>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?= $pagination ?>
      </div>
    </div>
  </div>
</section>
