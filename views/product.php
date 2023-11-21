<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('store') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/category/'.$category->slug) ?>"><?= html_escape($category->name) ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('store') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s">
        <div class="uk-cover-container uk-border-rounded uk-height-medium uk-transition-toggle" uk-lightbox>
          <img src="<?= $template['uploads'].$product->image ?>" alt="<?= html_escape($product->name) ?>" uk-cover>
          <div class="uk-transition-fade uk-position-cover uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
            <div class="uk-transition-slide-bottom-small">
              <i class="fa-solid fa-image fa-xl"></i>
            </div>
          </div>
          <a href="<?= $template['uploads'].$product->image ?>" class="uk-position-cover" data-caption="<?= html_escape($product->name) ?>"></a>
        </div>
      </div>
      <div class="uk-width-2-3@s">
        <?= $template['partials']['alerts'] ?>
        <h3 class="uk-h4 uk-text-bold uk-text-break uk-margin-remove"><?= html_escape($product->name) ?></h3>
        <hr class="uk-hr uk-margin-small">
        <div class="uk-margin-small uk-text-break">
          <?= html_escape($product->description) ?>
        </div>
        <?= form_open(current_url()) ?>
          <div class="uk-margin-small">
            <label class="uk-form-label uk-text-emphasis uk-text-bold"><?= lang('price') ?>:</label>
            <div class="uk-grid-small uk-child-width-auto uk-grid">
              <?php if ($product->currency === Store_product_model::CURRENCY_DP): ?>
              <label><input class="uk-radio" type="radio" checked> <span class="bc-dp-points"><?= $product->dp ?></span></label>
              <?php elseif ($product->currency === Store_product_model::CURRENCY_VP): ?>
              <label><input class="uk-radio" type="radio" checked> <span class="bc-vp-points"><?= $product->vp ?></span></label>
              <?php elseif ($product->currency === Store_product_model::CURRENCY_BOTH): ?>
              <label><input class="uk-radio" type="radio" checked> <span class="bc-dp-points"><?= $product->dp ?></span> <?= lang('and') ?> <span class="bc-vp-points"><?= $product->vp ?></span></label>
              <?php elseif ($product->currency === Store_product_model::CURRENCY_CHOICE): ?>
              <label><input class="uk-radio" type="radio" name="price" value="<?= Store_product_model::CURRENCY_DP ?>" <?= set_radio('price', Store_product_model::CURRENCY_DP) ?>> <span class="bc-dp-points"><?= $product->dp ?></span></label>
              <label><input class="uk-radio" type="radio" name="price" value="<?= Store_product_model::CURRENCY_VP ?>" <?= set_radio('price', Store_product_model::CURRENCY_VP) ?>> <span class="bc-vp-points"><?= $product->vp ?></label>
            </div>
            <?= form_error('price', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            <?php endif ?>
          </div>
          <div class="uk-grid-small uk-margin-small" uk-grid>
            <div class="uk-width-1-3 uk-width-1-5@m">
              <label class="uk-form-label uk-text-emphasis uk-text-bold"><?= lang('realm') ?>:</label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" value="<?= $this->realm_model->get_name($product->realm_id) ?>" autocomplete="off" readonly>
              </div>
            </div>
            <div class="uk-width-2-3 uk-width-1-3@m">
              <label class="uk-form-label uk-text-emphasis uk-text-bold"><?= lang('character') ?>:</label>
              <div class="uk-form-controls">
                <select class="uk-select tail-single" id="select_character" name="guid" autocomplete="off" data-placeholder="<?= lang('select_character') ?>">
                  <?php foreach ($characters as $character): ?>
                  <option value="<?= $character->guid ?>"><?= $character->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <?= form_error('guid', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
          </div>
          <div class="uk-margin-small">
            <label class="uk-form-label uk-text-emphasis uk-text-bold"><?= lang('quantity') ?>:</label>
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-3 uk-width-1-5@m">
                <input class="uk-input" type="number" name="qty" value="1" min="1" autocomplete="off">
              </div>
              <div class="uk-width-2-3 uk-width-1-3@m">
                <button class="uk-button uk-button-default uk-width-1-1" type="submit"><?= lang('add_cart') ?></button>
              </div>
            </div>
          </div>
          <?= form_error('qty', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
