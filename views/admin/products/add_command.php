<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
          <li><a href="<?= site_url('store/admin') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/admin/products') ?>"><?= lang('products') ?></a></li>
          <li><a href="<?= site_url('store/admin/products/'. $product->id) ?>"><?= html_escape($product->name) ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('add_command') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <?= $template['partials']['alerts'] ?>
    <?= form_open(current_url()) ?>
      <div class="uk-card uk-card-default uk-margin">
        <div class="uk-card-body">
          <div class="uk-margin-small">
            <label class="uk-form-label"><?= lang('type') ?></label>
            <div class="uk-radio-button-group bc-show-group">
              <div class="uk-radio-container">
                <input class="uk-radio-button" type="radio" name="type" value="item" <?= set_radio('type', Store_command_model::TYPE_ITEM) ?>>
                <div class="uk-label-container">
                  <div class="uk-label-dot"></div>
                  <label><?= lang('item') ?></label>
                </div>
              </div>
              <div class="uk-radio-container">
                <input class="uk-radio-button" type="radio" name="type" value="custom" <?= set_radio('type', Store_command_model::TYPE_CUSTOM) ?>>
                <div class="uk-label-container">
                  <div class="uk-label-dot"></div>
                  <label><?= lang('custom') ?></label>
                </div>
              </div>
            </div>
            <?= form_error('type', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
          </div>
          <div id="type_item" hidden>
            <div class="uk-margin-small">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('item') ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="item" value="<?= set_value('item') ?>" placeholder="<?= lang('item') ?>" autocomplete="off">
                  </div>
                  <?= form_error('item', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('quantity') ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="quantity" value="<?= set_value('quantity') ?>" placeholder="<?= lang('quantity') ?>" autocomplete="off">
                  </div>
                  <?= form_error('quantity', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
              </div>
            </div>
          </div>
          <div id="type_custom" hidden>
            <div class="uk-margin-small">
              <label class="uk-form-label"><?= lang('command') ?></label>
              <div class="uk-form-controls">
                <textarea class="uk-textarea" name="command" rows="2" autocomplete="off"><?= set_value('command') ?></textarea>
              </div>
              <?= form_error('command', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-tile uk-tile-muted uk-padding-small">
              <h5 class="uk-h6 uk-text-bold uk-text-uppercase uk-margin-remove"><i class="fa-regular fa-circle-question"></i> <?= lang('variables_command') ?>:</h5>
              <ul class="uk-list uk-list-square uk-list-collapse uk-text-small uk-margin-remove">
                <li><span class="uk-text-secondary uk-text-bold">{character}</span> <?= lang('character_variable_command') ?></li>
                <li><span class="uk-text-secondary uk-text-bold">{subject}</span> <?= lang('subject_variable_command') ?></li>
                <li><span class="uk-text-secondary uk-text-bold">{body}</span> <?= lang('body_variable_command') ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <button class="uk-button uk-button-primary" type="submit"><?= lang('add') ?></button>
    <?= form_close() ?>
  </div>
</section>
