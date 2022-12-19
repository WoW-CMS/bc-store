<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('store') ?>"><?= lang('store') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('cart') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <?= $template['partials']['alerts'] ?>
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body uk-padding-remove">
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
            <thead>
              <tr>
                <th class="uk-table-expand"><?= lang('product') ?></th>
                <th class="uk-width-medium"><?= lang('realm') ?></th>
                <th class="uk-width-small"><?= lang('character') ?></th>
                <th class="uk-width-small"><?= lang('price') ?></th>
                <th class="uk-width-small"><?= lang('quantity') ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($contents as $item): ?>
              <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $this->realm_model->get_name($item['options']['realm']) ?></td>
                <td><?= $this->server_characters_model->character_name($item['options']['realm'], $item['options']['guid']) ?></td>
                <td>
                  <?php if ($item['options']['currency'] === CURRENCY_DP): ?>
                  <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $item['dp'] ?></span>
                  <?php elseif ($item['options']['currency'] === CURRENCY_VP): ?>
                  <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $item['vp'] ?></span>
                  <?php elseif ($item['options']['currency'] === CURRENCY_BOTH): ?>
                  <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $item['dp'] ?></span> &amp; <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $item['vp'] ?></span>
                  <?php endif ?>
                </td>
                <td>
                  <?= form_open(site_url('store/cart/quantity')) ?>
                    <?= form_hidden('id', $item['rowid']) ?>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-expand">
                        <div class="uk-form-controls">
                          <input class="uk-input uk-form-small" type="number" name="qty" value="<?= $item['qty'] ?>" autocomplete="off">
                        </div>
                      </div>
                      <div class="uk-width-auto">
                        <button class="uk-button uk-button-default uk-button-small uk-margin-small" type="submit"><i class="fa-solid fa-rotate"></i></button>
                      </div>
                    </div>
                  <?= form_close() ?>
                </td>
                <td>
                  <a href="<?= site_url('store/cart/delete/'.$item['rowid']) ?>" class="uk-button uk-button-danger uk-button-small"><i class="fa-solid fa-trash-can"></i></a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="uk-card-footer">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-expand@s">
            <a href="<?= site_url('store') ?>" class="uk-button uk-button-default uk-button-small"><?= lang('continue_buying') ?></a>
          </div>
          <div class="uk-width-auto@s uk-flex uk-flex-middle">
            <p class="uk-margin-small uk-text-small"><span class="uk-text-uppercase uk-text-bold uk-margin-small-right"><?= lang('total') ?>:</span> <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $this->cart->total_dp() ?></span> &amp; <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $this->cart->total_vp() ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="uk-flex uk-float-right">
      <?php if ($this->cart->total_items()): ?>
      <a href="<?= site_url('store/cart/checkout') ?>" class="uk-button uk-button-default"><i class="fa-solid fa-cart-shopping"></i> <?= lang('checkout') ?></a>
      <?php else: ?>
      <button class="uk-button uk-button-default" type="button" disabled><i class="fa-solid fa-cart-shopping"></i> <?= lang('checkout') ?></button>
      <?php endif ?>
    </div>
  </div>
</section>
