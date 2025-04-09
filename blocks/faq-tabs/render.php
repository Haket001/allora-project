<?php
$slug = get_field('slug');
$tabs = get_field('tabs');
?>

<section>
    <div class="container">
        <div class="accordion-block-wrap">
            <div class="tabs__wrap">
                <h1><?php echo esc_html($slug); ?></h1>
                <div class="tabs">
                    <?php if (!empty($tabs) && is_array($tabs)): ?>
                        <?php foreach ($tabs as $index => $tabGroup): ?>
                            <input type="radio" name="accordion-tabs" id="tab-<?php echo $index; ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                            <label for="tab-<?php echo $index; ?>" class="tab__label">
                                <?php echo esc_html($tabGroup['tab_slug'] ?? ''); ?>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tabs__content">
                <?php if (!empty($tabs) && is_array($tabs)): ?>
                    <?php foreach ($tabs as $index => $tabGroup): ?>
                        <div class="accordion-wrap" data-tab="tab-<?php echo $index; ?>">
                            <?php
                            $accordionItems = $tabGroup['accordion_items'] ?? [];
                            $accordionCounter = 0;
                            ?>
                            <?php if (!empty($accordionItems)): ?>
                                <?php foreach ($accordionItems as $accordionItem): ?>
                                    <div class="accordion">
                                        <input type="checkbox" id="accordion-<?php echo $index . '-' . $accordionCounter; ?>">
                                        <label for="accordion-<?php echo $index . '-' . $accordionCounter; ?>" class="accordion__label">
                                            <?php echo esc_html($accordionItem['question'] ?? ''); ?>
                                        </label>
                                        <div class="accordion__content">
                                            <p><?php echo esc_html($accordionItem['answer'] ?? ''); ?></p>
                                        </div>
                                    </div>
                                    <?php $accordionCounter++; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>