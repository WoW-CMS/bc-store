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
            <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
              <div class="uk-width-expand">
                <h3 class="uk-card-title"><i class="fa-solid fa-file-invoice"></i> <?= lang('order_details') ?></h3>
              </div>
              <div class="uk-width-auto"></div>
            </div>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small uk-grid-divider" uk-grid>
              <div class="uk-width-expand@s">
                <table class="uk-table bc-table-xsmall">
                  <tbody>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('id') ?></td>
                      <td class="uk-width-1-2"><?= $order->id ?></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('character') ?></td>
                      <td class="uk-width-1-2"><?= $character_name ?></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('product') ?></td>
                      <td class="uk-width-1-2"><?= $product->name ?></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('realm') ?></td>
                      <td class="uk-width-1-2"><?= $realm_name ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="uk-width-expand@s">
                <table class="uk-table bc-table-xsmall">
                  <tbody>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('voting_points') ?></td>
                      <td class="uk-width-1-2"><span class="bc-vp-points"><?= $order->total_vp ?></span></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('donation_points') ?></td>
                      <td class="uk-width-1-2"><span class="bc-dp-points"><?= $order->total_dp ?></span></td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('status') ?></td>
                      <td class="uk-width-1-2">
                        <?php if ($order->status === Store_order_model::STATUS_COMPLETED): ?>
                        <span class="uk-label uk-label-success"><?= $order->status ?></span>
                        <?php elseif ($order->status === Store_order_model::STATUS_PROCESSING): ?>
                        <span class="uk-label uk-label-danger"><?= $order->status ?></span>
                        <?php else: ?>
                        <span class="uk-label"><?= $order->status ?></span>
                        <?php endif ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="uk-width-1-2"><?= lang('created_at') ?></td>
                      <td class="uk-width-1-2">
                        <time datetime="<?= $order->created_at ?>"><?= locate_date($order->created_at) ?></time>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
