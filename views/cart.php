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
    <div class="uk-margin" uk-grid>
      <div class="uk-width-2-3@s uk-width-3-4@m">
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-body uk-padding-remove">
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
                <thead>
                  <tr>
                    <th class="uk-table-expand"><?= lang('product') ?></th>
                    <th class="uk-width-small"><?= lang('price') ?></th>
                    <th class="uk-width-small"><?= lang('quantity') ?></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($contents as $item): ?>
                  <tr>
                    <td>
                      <a href="<?= site_url('store/product/'.$item['id']) ?>" class="uk-link-reset">
                        <h5 class="uk-h5 uk-margin-remove"><?= $item['name'] ?></h5>
                      </a>
                      <div class="uk-grid-small uk-grid-divider uk-flex uk-flex-middle uk-text-meta" uk-grid>
                        <div class="uk-width-auto">
                          <?= lang('realm') ?>: <?= $this->realm_model->get_name($item['options']['realm']) ?>
                        </div>
                        <div class="uk-width-auto">
                          <?= lang('character') ?>: <?= $this->server_characters_model->character_name($item['options']['realm'], $item['options']['guid']) ?>
                        </div>
                      </div>
                    </td>
                    <td>
                      <?php if ($item['options']['currency'] === Store_product_model::CURRENCY_DP): ?>
                      <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $item['dp'] ?></span>
                      <?php elseif ($item['options']['currency'] === Store_product_model::CURRENCY_VP): ?>
                      <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $item['vp'] ?></span>
                      <?php elseif ($item['options']['currency'] === Store_product_model::CURRENCY_BOTH): ?>
                      <span class="bc-dp-points" uk-tooltip="title: <?= lang('donation_points') ?>"><?= $item['dp'] ?></span> <?= lang('and') ?> <span class="bc-vp-points" uk-tooltip="title: <?= lang('voting_points') ?>"><?= $item['vp'] ?></span>
                      <?php endif ?>
                    </td>
                    <td>
                      <?= form_open(site_url('store/cart/quantity')) ?>
                        <?= form_hidden('id', $item['rowid']) ?>
                        <div class="uk-grid-small" uk-grid>
                          <div class="uk-width-expand">
                            <div class="uk-form-controls">
                              <input class="uk-input uk-form-small" type="number" name="qty" value="<?= $item['qty'] ?>" min="1" autocomplete="off">
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
        </div>
      </div>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-rectangle-list"></i> <?= lang('summary') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-expand">
                <?= lang('products') ?>:
              </div>
              <div>
                <?= $this->cart->total_items() ?>
              </div>
            </div>
            <hr class="uk-hr uk-margin-small">
            <div class="uk-grid-small uk-margin-small-top uk-margin-bottom" uk-grid>
              <div class="uk-width-expand">
                <?= lang('total') ?>:
              </div>
              <div>
                <?php if ($this->cart->total_dp() >= 0 && $this->cart->total_vp() == 0): ?>
                <span class="bc-dp-points"><?= $this->cart->total_dp() ?></span>
                <?php elseif ($this->cart->total_vp() >= 0 && $this->cart->total_dp() == 0): ?>
                <span class="bc-vp-points"><?= $this->cart->total_vp() ?></span>
                <?php else: ?>
                <span class="bc-dp-points"><?= $this->cart->total_dp() ?></span> <?= lang('and') ?> <span class="bc-vp-points"><?= $this->cart->total_vp() ?></span>
                <?php endif ?>
              </div>
            </div>
            <?php if ($this->cart->total_items()): ?>
            <a href="<?= site_url('store/cart/checkout') ?>" class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom"><i class="fa-solid fa-cash-register"></i> <?= lang('proceed_checkout') ?></a>
            <?php else: ?>
            <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom" type="button" disabled><i class="fa-solid fa-cash-register"></i> <?= lang('proceed_checkout') ?></button>
            <?php endif ?>
            <a href="<?= site_url('store') ?>" class="uk-button uk-button-danger uk-button-small uk-width-1-1"><i class="fa-solid fa-arrow-left"></i> <?= lang('back_store') ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
