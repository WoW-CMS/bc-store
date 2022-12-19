<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
          <li><a href="<?= site_url('store/admin') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/admin/orders') ?>"><?= lang('orders') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('order') ?> #<?= $order->id ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-grid-row-small uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-margin" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <span class="bc-color-lightgray">
                <i class="fa-solid fa-user fa-2x"></i>
              </span>
            </div>
            <div class="uk-width-expand">
              <h6 class="uk-h6 uk-text-bold uk-margin-remove"><?= lang('username') ?></h6>
              <p class="uk-text-meta uk-margin-remove"><?= user('username', $order->user_id) ?></p>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <span class="bc-color-lightgray">
                <i class="fa-solid fa-calendar-day fa-2x"></i>
              </span>
            </div>
            <div class="uk-width-expand">
              <h6 class="uk-h6 uk-text-bold uk-margin-remove"><?= lang('created_at') ?></h6>
              <p class="uk-text-meta uk-margin-remove"><?= format_date($order->created_at, 'M j, Y, h:i A') ?></p>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <span class="bc-color-lightgray">
                <i class="fa-solid fa-circle-info fa-2x"></i>
              </span>
            </div>
            <div class="uk-width-expand">
              <h6 class="uk-h6 uk-text-bold uk-margin-remove"><?= lang('status') ?></h6>
              <p class="uk-text-meta uk-margin-remove"><?= $order->status ?></p>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <span class="bc-color-lightgray">
                <i class="fa-solid fa-globe fa-2x"></i>
              </span>
            </div>
            <div class="uk-width-expand">
              <h6 class="uk-h6 uk-text-bold uk-margin-remove"><?= lang('ip') ?></h6>
              <p class="uk-text-meta uk-margin-remove"><?= $order->ip ?></p>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <span class="bc-color-lightgray">
                <i class="fa-solid fa-coins fa-2x"></i>
              </span>
            </div>
            <div class="uk-width-expand">
              <h6 class="uk-h6 uk-text-bold uk-margin-remove"><?= lang('total_dp') ?></h6>
              <p class="uk-text-meta uk-margin-remove"><?= $order->total_dp ?></p>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <span class="bc-color-lightgray">
                <i class="fa-solid fa-coins fa-2x"></i>
              </span>
            </div>
            <div class="uk-width-expand">
              <h6 class="uk-h6 uk-text-bold uk-margin-remove"><?= lang('total_vp') ?></h6>
              <p class="uk-text-meta uk-margin-remove"><?= $order->total_vp ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-header">
        <h6 class="uk-h6 uk-text-bold"><?= lang('products_sold') ?> (<span class="uk-text-primary"><?= $order->products_sold ?></span>)</h5>
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
                <th class="uk-width-small"><?= lang('character') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $item): ?>
              <tr>
                <td><?= $item->name ?></td>
                <td><?= $item->quantity ?></td>
                <td><?= (int) $item->dp * (int) $item->quantity ?></td>
                <td><?= (int) $item->vp * (int) $item->quantity ?></td>
                <td><?= $this->server_characters_model->character_name($item->realm_id, $item->guid) ?></td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <a href="<?= site_url('store/admin/orders') ?>" class="uk-button uk-button-primary"><?= lang('back') ?></a>
  </div>
</section>
