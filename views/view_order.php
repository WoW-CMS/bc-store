<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('store') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/orders') ?>"><?= lang('my_orders') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('order') ?></h1>
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
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('order_details') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small uk-grid-divider" uk-grid>
              <div class="uk-width-expand@s">
                <table class="uk-table bc-table-xsmall">
                  <tbody>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('id') ?>:</td>
                      <td class="uk-width-1-2"><?= $order->id ?></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('status') ?>:</td>
                      <td class="uk-width-1-2">
                        <?php if ($order->status === Store_order_model::STATUS_COMPLETED): ?>
                        <span class="uk-label uk-label-success"><?= lang('completed') ?></span>
                        <?php elseif ($order->status === Store_order_model::STATUS_PROCESSING): ?>
                        <span class="uk-label uk-label-danger"><?= lang('processing') ?></span>
                        <?php else: ?>
                        <span class="uk-label"><?= $order->status ?></span>
                        <?php endif ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('created_at') ?>:</td>
                      <td class="uk-width-1-2">
                        <time datetime="<?= $order->created_at ?>"><?= locate_date($order->created_at) ?></time>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="uk-width-expand@s">
                <table class="uk-table bc-table-xsmall">
                  <tbody>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('purchased_products') ?>:</td>
                      <td class="uk-width-1-2"><?= $order->total_products ?></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('total_vp') ?>:</td>
                      <td class="uk-width-1-2">
                        <span class="bc-vp-points"><?= $order->total_vp ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('total_dp') ?>:</td>
                      <td class="uk-width-1-2">
                        <span class="bc-dp-points"><?= $order->total_dp ?></span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('purchased_products') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
                <thead>
                  <tr>
                    <th class="uk-table-expand"><?= lang('name') ?></th>
                    <th class="uk-width-small"><?= lang('quantity') ?></th>
                    <th class="uk-width-small"><?= lang('dp') ?></th>
                    <th class="uk-width-small"><?= lang('vp') ?></th>
                    <th class="uk-width-small"><?= lang('realm') ?></th>
                    <th class="uk-width-small"><?= lang('character') ?></th>
                 </tr>
                </thead>
                <tbody>
                  <?php foreach ($products as $item): ?>
                  <tr>
                    <td><?= $item->name ?></td>
                    <td><?= $item->quantity ?></td>
                    <td>
                      <span class="bc-dp-points"><?= (int) $item->dp * (int) $item->quantity ?></span>
                    </td>
                    <td>
                      <span class="bc-vp-points"><?= (int) $item->vp * (int) $item->quantity ?></span>
                    </td>
                    <td><?= $item->realm_name ?></td>
                    <td><?= $this->server_characters_model->character_name($item->realm_id, $item->guid) ?></td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php if (isset($products) && ! empty($products)): ?>
        <?= $pagination ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
