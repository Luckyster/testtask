<?php

function my_album_custom_fields_meta_box() {
    add_meta_box(
        'my_repeater_meta_box',
        'Custom Fields',
        'my_repeater_meta_box_html',
        'album'
    );
}
add_action('add_meta_boxes', 'my_album_custom_fields_meta_box');

function my_repeater_meta_box_html($post) {
    $custom_fields_data = get_post_meta($post->ID, 'custom_fields_data', true);
    wp_nonce_field('my_album_custom_fields_nonce', 'my_album_custom_fields_nonce_field');
    ?>

    <div id="custom-fields-repeater">
        <?php
        if (!empty($custom_fields_data)) {
            foreach ($custom_fields_data as $index => $field) {
                ?>
                <div class="repeater-item">
                    <div style="width:30%; display:inline-block;">
                        <label>Name</label><br>
                        <input type="text" name="custom_fields_data[<?php echo $index; ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Name" />
                    </div>
                    <div style="width:68%; display:inline-block;">
                        <label>Text</label><br>
                        <input type="text" name="custom_fields_data[<?php echo $index; ?>][text]" value="<?php echo esc_attr($field['text']); ?>" placeholder="Text" />
                    </div>
                    <button type="button" class="remove-repeater-item">Remove</button>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="repeater-item">
                <div style="width:30%; display:inline-block;">
                    <label>Name</label><br>
                    <input type="text" name="custom_fields_data[0][name]" placeholder="Name" />
                </div>
                <div style="width:68%; display:inline-block;">
                    <label>Text</label><br>
                    <input type="text" name="custom_fields_data[0][text]" placeholder="Text" />
                </div>
                <button type="button" class="remove-repeater-item">Remove</button>
            </div>
            <?php
        }
        ?>
    </div>
    <button type="button" id="add-repeater-item">Add Row</button>

    <script>
        jQuery(document).ready(function($) {
            var index = <?php echo !empty($custom_fields_data) ? count($custom_fields_data) : 1; ?>;

            $('#add-repeater-item').click(function() {
                var newItem = `<div class="repeater-item">
                    <div style="width:30%; display:inline-block;">
                        <label>Name</label><br>
                        <input type="text" name="custom_fields_data[` + index + `][name]" placeholder="Name" />
                    </div>
                    <div style="width:68%; display:inline-block;">
                        <label>Text</label><br>
                        <input type="text" name="custom_fields_data[` + index + `][text]" placeholder="Text" />
                    </div>
                    <button type="button" class="remove-repeater-item">Remove</button>
                </div>`;
                $('#custom-fields-repeater').append(newItem);
                index++;
            });

            $(document).on('click', '.remove-repeater-item', function() {
                $(this).closest('.repeater-item').remove();
            });
        });
    </script>

    <style>
        .repeater-item {
            margin-bottom: 10px;
        }
        .repeater-item input {
            margin-right: 5px;
            width: 100%;
        }
        .remove-repeater-item {
            background-color: #ff5e5e;
            color: #fff;
            border: none;
            padding: 5px;
            cursor: pointer;
            margin-top: 5px;
        }
        #add-repeater-item {
            margin-top: 10px;
            padding: 5px 10px;
        }
    </style>

    <?php
}
function save_my_album_custom_fields($post_id) {

    if (!isset($_POST['my_album_custom_fields_nonce_field']) ||
        !wp_verify_nonce($_POST['my_album_custom_fields_nonce_field'], 'my_album_custom_fields_nonce')) {
        return;
    }


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['custom_fields_data'])) {
        $custom_fields_data = array();
        foreach ($_POST['custom_fields_data'] as $field) {
            $custom_fields_data[] = array(
                'name' => sanitize_text_field($field['name']),
                'text' => sanitize_text_field($field['text']),
            );
        }
        update_post_meta($post_id, 'custom_fields_data', $custom_fields_data);
    } else {
        delete_post_meta($post_id, 'custom_fields_data');
    }
}
add_action('save_post', 'save_my_album_custom_fields');


