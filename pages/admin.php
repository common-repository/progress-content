<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?= _e('Progress Bar configuration', 'progress-content'); ?></h1>
    <p><?= _e('Welcome on the configuration page of your progress bar, you can personalize some specs of the bar, and decide where to show the progress bar.', 'progress-content'); ?></p>
    <h2 class="wp-heading-inline"><?= _e('Personalization', 'progress-content'); ?></h2>
    <form method="POST" action="" style="display: flex;flex-direction: column;gap: 10px;">
        <div style="display: flex;gap: 10px;flex-direction: column;max-width: 450px;">
            <label for="height_bar">
            <?= _e('Height of the bar', 'progress-content'); ?> (<span id="px-bar"><?php echo esc_html($optionsBar['height']); ?></span> px)
            </label>
            <input type="range" min="1" max="100" id="height_bar" name="height_bar" value="<?php echo esc_html($optionsBar['height']); ?>"/>
        </div>
        <div style="display: flex;gap: 10px;flex-direction: column;max-width: 450px;">
            <label for="color_bar">
            <?= _e('Color of the bar', 'progress-content'); ?>
            </label>
            <input type="color" id="color_bar" name="color_bar" value="<?php echo esc_html($optionsBar['color']); ?>"/>
        </div>
        <div style="display: flex;gap: 10px;flex-direction: column;max-width: 450px;">
            <label for="style_bar">
            <?= _e('Style of the bar', 'progress-content'); ?>
            </label>
            <select name="style_bar" id="style_bar">
                <?php
                foreach ($allStylesBar as $singleStyle) {
                    echo '<option value="' . esc_html($singleStyle['Class']) . '" ' . ((esc_html($singleStyle['Class']) == esc_html($optionsBar['style_bar'])) ? 'selected' : '') . '>' . esc_html($singleStyle['Name']) . '</option>';
                }
                
                ?>  
            </select>
        </div>
        <div style="display: flex;gap: 10px;flex-direction: column;max-width: 450px;">
            <label for="post_bar">
            <?= _e('Post type enabled', 'progress-content'); ?>
            </label>
            <small><?= _e('Where the progress bar is allowed to show ? (By default : only post)', 'progress-content'); ?></small>
            <?php
            $args = [];
            $post_types = get_post_types( $args, 'objects' );
            foreach ($selectedPost as $postType) {
                $natural_post_name='';
                try {
                    $natural_post_name=$post_types[$postType]->label;
                } catch (Exception $e) {
                    $natural_post_name='Error';
                }
                echo '<label class="post_type"><input type="checkbox" name="post_type[]" value="' . esc_html($postType) . '" ' . (in_array(esc_html($postType), $optionsBar['post_type']) ? 'checked' : '') . '/> ' . $natural_post_name . ' (' . esc_html($postType) . ')</label>';
            }
            ?>
        </div>
        <input type="text" name="wp_nonce_bar" value="<?php echo esc_html(wp_create_nonce('bar')); ?>" hidden/>
        <p><button type="submit" class="button button-primary"><?= _e('Save your preferences', 'progress-content'); ?></button></p>
    </form>
    <h2 class="wp-heading-inline"><?= _e('Preview', 'progress-content'); ?></h2>
    <div id="demo_container">
        <div id="demo_bar">
            <img src="<?php echo esc_html(plugin_dir_url(__FILE__)); ?>browser-header.png" alt="header browser"/>
        </div>
        <div id="bar_container">
            <div id="__progress_bar" style="height: <?php echo esc_html($optionsBar['height']); ?>px;background:<?php echo esc_html($optionsBar['color']); ?>;" class="<?php echo esc_html($optionsBar['style_bar']); ?>"></div>
        </div>
    </div>
</div>