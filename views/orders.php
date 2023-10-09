<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('store') ?>"><?= lang('store') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('my_orders') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-rectangle-list"></i> <?= lang('menu') ?></h3>
          </div>
          <ul class="uk-nav-default" uk-nav>
            <?php foreach ($this->menu_model->display('panel') as $item): ?>
            <?php if ($item->type === ITEM_DROPDOWN): ?>
            <li class="uk-parent">
              <a href="#">
                <span class="bc-li-icon"><i class="<?= $item->icon ?>"></i></span><?= $item->name ?> <span uk-nav-parent-icon></span>
              </a>
              <ul class="uk-nav-sub">
                <?php foreach ($item->childs as $subitem): ?>
                <li class="<?= is_route_active($subitem->url) ? 'uk-active' : '' ?>">
                  <a target="<?= $subitem->target ?>" href="<?= $subitem->url ?>">
                    <span class="bc-li-icon"><i class="<?= $subitem->icon ?>"></i></span><?= $subitem->name ?>
                  </a>
                </li>
                <?php endforeach ?>
              </ul>
            </li>
            <?php elseif ($item->type === ITEM_LINK): ?>
            <li class="<?= is_route_active($item->url) ? 'uk-active' : '' ?>">
              <a target="<?= $item->target ?>" href="<?= $item->url ?>">
                <span class="bc-li-icon"><i class="<?= $item->icon ?>"></i></span><?= $item->name ?>
              </a>
            </li>
            <?php endif ?>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <div class="uk-width-2-3@s uk-width-3-4@m">
        <?= $template['partials']['alerts'] ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-padding-remove">
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
                <thead>
                  <tr>
                    <th class="uk-table-expand"><?= lang('name') ?></th>
                    <th class="uk-width-small"><?= lang('total_dp') ?></th>
                    <th class="uk-width-small"><?= lang('total_vp') ?></th>
                    <th class="uk-width-small"><?= lang('status') ?></th>
                    <th class="uk-width-medium"><?= lang('date') ?></th>
                    <th class="uk-width-small"><?= lang('actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orders as $item): ?>
                  <tr>
                    <td><?= $item->name ?></td>
                    <td><?= $item->total_dp ?></td>
                    <td><?= $item->total_vp ?></td>
                    <td>
                      <?php if ($item->status === Store_order_model::STATUS_COMPLETED): ?>
                      <span class="uk-label uk-label-success"><?= $item->status ?></span>
                      <?php elseif ($item->status === Store_order_model::STATUS_PROCESSING): ?>
                      <span class="uk-label uk-label-danger"><?= $item->status ?></span>
                      <?php else: ?>
                      <span class="uk-label"><?= $item->status ?></span>
                      <?php endif ?>
                    </td>
                    <td>
                      <time datetime="<?= $item->created_at ?>"><?= locate_date($item->created_at) ?></time>
                    </td>
                    <td>
                      <a href="<?= site_url('store/orders/view/'.$item->id) ?>" class="uk-button uk-button-default uk-button-small"><?= lang('view') ?></a>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php if (isset($orders) && ! empty($orders)): ?>
        <?= $pagination ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
