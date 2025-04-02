<?php
/**
 * Render template for ModalForm
 */

$form_slug = get_field("form_slug");
?>

<div id="form-modal" class="modal-form">
    <div class="modal-content-form">
        <button class="close-modal-form">×</button>
        <h4><?php echo esc_html($form_slug) ?></h4>
        <?php echo do_shortcode('[contact-form-7 id="e2e684f" title="Contact form 1"]') ?>
    </div>
</div>