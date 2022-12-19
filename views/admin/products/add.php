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
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('add_product') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <?= $template['partials']['alerts'] ?>
    <?= form_open_multipart(current_url()) ?>
      <div class="uk-margin" uk-grid>
        <div class="uk-width-3-5@s uk-width-2-3@m">
          <div class="uk-card uk-card-default uk-margin">
            <div class="uk-card-body">
              <div class="uk-grid-small uk-margin-small" uk-grid>
                <div class="uk-width-1-1">
                  <label class="uk-form-label"><?= lang('name') ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="name" value="<?= set_value('name') ?>" placeholder="<?= lang('name') ?>" autocomplete="off">
                  </div>
                  <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('category') ?></label>
                  <div class="uk-form-controls">
                    <select class="uk-select tail-single" id="select_category" name="category" autocomplete="off" data-placeholder="<?= lang('select_category') ?>">
                      <?php foreach ($categories as $category): ?>
                      <option value="<?= $category->id ?>" <?= set_select('category', $category->id) ?>><?= $category->name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <?= form_error('category', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('realm') ?></label>
                  <div class="uk-form-controls">
                    <select class="uk-select tail-single" id="select_realm" name="realm" autocomplete="off" data-placeholder="<?= lang('select_realm') ?>">
                      <?php foreach ($realms as $realm): ?>
                      <option value="<?= $realm->id ?>" <?= set_select('realm', $realm->id) ?>><?= $realm->realm_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <?= form_error('realm', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-1">
                  <label class="uk-form-label"><?= lang('description') ?></label>
                  <div class="uk-form-controls">
                    <textarea class="uk-textarea" name="description" rows="3" autocomplete="off"><?= set_value('description') ?></textarea>
                  </div>
                  <?= form_error('description', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-1">
                  <label class="uk-form-label"><?= lang('currency') ?></label>
                  <div class="uk-radio-button-group">
                    <div class="uk-radio-container">
                      <input class="uk-radio-button" type="radio" name="currency" value="<?= CURRENCY_DP ?>" <?= set_radio('currency', CURRENCY_DP) ?>>
                      <div class="uk-label-container">
                        <div class="uk-label-dot"></div>
                        <label><?= lang('dp') ?></label>
                      </div>
                    </div>
                    <div class="uk-radio-container">
                      <input class="uk-radio-button" type="radio" name="currency" value="<?= CURRENCY_VP ?>" <?= set_radio('currency', CURRENCY_VP) ?>>
                      <div class="uk-label-container">
                        <div class="uk-label-dot"></div>
                        <label><?= lang('vp') ?></label>
                      </div>
                    </div>
                    <div class="uk-radio-container">
                      <input class="uk-radio-button" type="radio" name="currency" value="<?= CURRENCY_BOTH ?>" <?= set_radio('currency', CURRENCY_BOTH) ?>>
                      <div class="uk-label-container">
                        <div class="uk-label-dot"></div>
                        <label><?= lang('dp_vp') ?></label>
                      </div>
                    </div>
                  </div>
                  <?= form_error('currency', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('dp') ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="dp" value="<?= set_value('dp', '0') ?>" placeholder="<?= lang('dp') ?>" autocomplete="off">
                  </div>
                  <?= form_error('dp', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('vp') ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="vp" value="<?= set_value('vp', '0') ?>" placeholder="<?= lang('vp') ?>" autocomplete="off">
                  </div>
                  <?= form_error('vp', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
              </div>
            </div>
          </div>
          <button class="uk-button uk-button-primary uk-visible@s" type="submit"><?= lang('add') ?></button>
        </div>
        <div class="uk-width-2-5@s uk-width-1-3@m">
          <div class="uk-card uk-card-default uk-margin">
            <div class="uk-card-header">
              <h3 class="uk-card-title"><i class="fa-solid fa-image"></i> <?= lang('image') ?></h3>
            </div>
            <div class="uk-card-body">
              <div id="mfp_container" class="uk-placeholder uk-padding-small uk-margin-small-bottom">
                <h5 class="uk-h5 uk-text-bold uk-text-uppercase uk-text-center uk-margin-medium-top uk-margin-medium-bottom"><i class="fa-solid fa-image"></i> <?= lang('image_not_loaded') ?></h5>
              </div>
              <div class="uk-margin-small-top">
                <div class="uk-form-controls">
                  <div class="uk-display-block" uk-form-custom>
                    <input class="mfp-input" type="file" id="product_img" name="file" data-container="mfp_container">
                    <button class="uk-button uk-button-default uk-width-1-1" type="button" tabindex="-1"><i class="fa-solid fa-upload"></i> <?= lang('select') ?></button>
                  </div>
                </div>
                <?= form_error('file', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
          </div>
          <ul uk-accordion>
            <li>
              <a class="uk-accordion-title" href="#"><i class="fa-solid fa-toggle-off"></i> <?= lang('optional') ?></a>
              <div class="uk-accordion-content">
                <div class="uk-grid-small uk-grid-divider uk-child-width-1-1" uk-grid>
                  <div>
                    <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                      <div class="uk-width-auto">
                        <label class="uk-switch uk-display-block">
                          <input type="checkbox" name="visible" value="1" <?= set_checkbox('visible', '1', true) ?>>
                          <div class="uk-switch-slider"></div>
                        </label>
                        <?= form_error('visible', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                      </div>
                      <div class="uk-width-expand">
                        <p class="uk-text-secondary uk-margin-remove"><?= lang('visible') ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <button class="uk-button uk-button-primary uk-hidden@s" type="submit"><?= lang('add') ?></button>
    <?= form_close() ?>
  </div>
</section>
