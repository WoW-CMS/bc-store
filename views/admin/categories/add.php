<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
          <li><a href="<?= site_url('store/admin') ?>"><?= lang('store') ?></a></li>
          <li><a href="<?= site_url('store/admin/categories') ?>"><?= lang('categories') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('add_category') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <?= $template['partials']['alerts'] ?>
    <?= form_open(current_url()) ?>
      <div class="uk-card uk-card-default uk-margin">
        <div class="uk-card-body">
          <div class="uk-grid-small uk-margin-small" uk-grid>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('name') ?></label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" name="name" value="<?= set_value('name') ?>" placeholder="<?= lang('name') ?>" autocomplete="off">
              </div>
              <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('slug') ?></label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" name="slug" value="<?= set_value('slug') ?>" placeholder="<?= lang('slug') ?>" autocomplete="off">
              </div>
              <?= form_error('slug', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('type') ?></label>
              <div class="uk-form-controls">
                <select class="uk-select tail-single" id="select_type" name="type" autocomplete="off" data-placeholder="<?= lang('select_type') ?>">
                  <option value="<?= ITEM_LINK ?>" <?= set_select('type', ITEM_LINK) ?>><?= lang('link') ?></option>
                  <option value="<?= ITEM_DROPDOWN ?>" <?= set_select('type', ITEM_DROPDOWN) ?>><?= lang('dropdown') ?></option>
                </select>
              </div>
              <?= form_error('type', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('parent') ?></label>
              <div class="uk-form-controls">
                <select class="uk-select tail-single" id="select_parent" name="parent" autocomplete="off" data-placeholder="<?= lang('select_parent') ?>">
                  <option value="0" <?= set_select('parent', '0') ?>><?= lang('no_parent') ?></option>
                  <?php foreach ($parents as $item): ?>
                  <option value="<?= $item->id ?>" <?= set_select('parent', $item->id) ?>><?= $item->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <?= form_error('parent', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
          </div>
        </div>
      </div>
      <button class="uk-button uk-button-primary" type="submit"><?= lang('add') ?></button>
    <?= form_close() ?>
  </div>
</section>
