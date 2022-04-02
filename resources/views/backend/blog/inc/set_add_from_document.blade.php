<?php

/* @var $title string
 * @var $models array
 */

use App\Common\Components\Helper;

?>
<?php if(!empty($models)){ ?>
    <?php $cnt = 0; ?>
    <?php foreach ($models as $model){ ?>
        <?php $uuid = Helper::uniqid(); ?>
        <div class="card mb-2 js-document-credit-parts-item" data-id="0" data-uuid="<?= $uuid ?>">
            <div class="card-body p-2 p-sm-3">
            <div class="media forum-item">
                <div class="text-muted small text-center align-self-center pr-3">
                    <span class="d-none d-sm-inline-block"><?= $cnt + 1 ?></span>
                </div>
                <div class="media-body">
                    <input
                        type="hidden"
                        name="document_credit[item][<?= $uuid ?>][catalog_document_content_id]">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select
                                    class="form-control js-document-credit-search-parts"
                                    data-placeholder="Запасная часть"
                                    name="document_credit[item][<?= $uuid ?>][spare_part]"
                                    data-validator="document_credit.item.<?= $uuid ?>.spare_part">
                                    <?php $array = $model->getSparePartForSelect(); ?>
                                    <option value='<?= $array['id'] ?? null ?>'><?= $array['text'] ?? null ?></option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <div class="js-document-credit-category-storage-select-group">
                                    <select
                                        class="form-control js-document-credit-category-storage"
                                        data-select-storage-cnt="0"
                                        data-validator="document_credit.item.<?= $uuid ?>.catalog_storage_place_id"
                                        data-placeholder="Выбрать склад">
                                        <option></option>
                                        <?php if(!empty($storages)){ ?>
                                            <?php foreach ($storages as $storage){ ?>
                                            <option value='<?= $storage['id'] ?>'><?= $storage['title'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="fieldset-input-in-<?= $uuid ?>">Входящая цена</label>
                                    <input
                                        type="text"
                                        value=""
                                        class="form-control inputmask"
                                        id="fieldset-input-in-<?= $uuid ?>"
                                        name="document_credit[item][<?= $uuid ?>][price_in]"
                                        data-inputmask-alias="currency"
                                        data-validator="document_credit.item.<?= $uuid ?>.price_in">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="fieldset-input-out-<?= $uuid ?>">Исходящая цена</label>
                                    <input
                                        type="text"
                                        value=""
                                        class="form-control inputmask"
                                        id="fieldset-input-out-<?= $uuid ?>"
                                        name="document_credit[item][<?= $uuid ?>][price_out]"
                                        data-inputmask-alias="currency"
                                        data-validator="document_credit.item.<?= $uuid ?>.price_out">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="list-with-gap">
                                <button type="button" class="btn btn-danger btn-xs js-document-credit-button-delete-parts-item-id">Удалить</button>
                                <label class="control-label" for="item-images-<?= $uuid ?>">
                                    <a type="button" class="btn btn-primary btn-xs">Загрузить фото</a>
                                </label>
                                <input
                                    type="file"
                                    id="item-images-<?= $uuid ?>"
                                    class="custom-input-file js-document-credit-parts-gallery-input"
                                    name="document_credit[item][<?= $uuid ?>][images][]"
                                    multiple=""
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php if($galleries = $model->catalogGalleriesWithImages ?? null){ ?>
                                <?php foreach ($galleries as $gallery){ ?>
                                    <div class="parts-gallery">
                                        <div class="custom-control custom-radio">
                                            <input
                                                type="radio"
                                                id="customRadio-<?= $cnt ?>-<?= $gallery->id ?>"
                                                name="document_credit[item][<?= $uuid ?>][catalog_gallery_id]"
                                                value="<?= $gallery->id ?>"
                                                class="custom-control-input"
                                                <?= $model->catalog_gallery_id == $gallery->id ? 'checked' : '' ?>
                                            >
                                            <label class="custom-control-label" for="customRadio-<?= $cnt ?>-<?= $gallery->id ?>"></label>
                                            <?php if($galleryImages = $gallery->catalogGalleryImages ?? null){ ?>
                                                <?php foreach ($galleryImages as $image){ ?>
                                                    <a data-fancybox="gallery-<?= $gallery->id ?>" href="<?= $image->url ?>">
                                                        <div style="display:inline-block;width:30px;height:25px;background: center/cover no-repeat url(<?= $image->url ?>)"></div>
                                                    </a>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="parts-gallery">
                                <div class="custom-control custom-radio">
                                    <input
                                        type="radio"
                                        id="customRadio-<?= $cnt ?>"
                                        name="document_credit[item][<?= $uuid ?>][catalog_gallery_id]"
                                        class="custom-control-input"
                                    <?= $model->catalog_gallery_id ? '' : 'checked' ?>
                                    >
                                    <label class="custom-control-label" for="customRadio-<?= $cnt ?>">
                                        Новая галерея
                                    </label>
                                </div>
                            </div>
                            <div class="parts-gallery js-document-credit-parts-gallery"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php $cnt++; ?>
    <?php } ?>
<?php } ?>
