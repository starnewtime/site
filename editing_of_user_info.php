<?php
/*
Plugin Name: editing_of_user_info
Description: Плагин редактирует информацию пользователя
Version: 1.0
Author: Владимир Зверев
*/
?>
<?php
//изменение 1
//изминение 2
add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');

function my_show_extra_profile_fields($user)
{ ?>
    <h3>Details</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone_number">Phone number</label></th>
            <td>
                <input type="text" name="phone_number" id="phone_number"
                       value="<?php echo esc_attr(get_the_author_meta('phone_number', $user->ID)); ?>"
                       class="regular-text"/><br/>
                <span class="description">Please enter your Phone</span>
            </td>
        </tr>
    </table>
    <?php
}


add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');

function my_save_extra_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id))
        return false;
    update_usermeta($user_id, 'phone_number', $_POST['phone_number']);
}


function add_custom_meta_box()
{
    add_meta_box(
        'custom_meta_box', // $id
        'Details', // $title
        'show_custom_meta_box', // $callback
        'post', // $page or custom post type
        'side', // $context
        'high'// $priority
    );
}

add_action('add_meta_boxes', 'add_custom_meta_box');
function show_custom_meta_box($post)
{
    $custom_meta = get_the_author_meta('phone_number', $post->post_author);
    ?>
    <div id="phone_number">
        phone_number
    </div>
    <?php
    ?>
    <p>
        <input class="widefat" type="text" name="phone_number" id="phone_number" value="<?php echo $custom_meta ?>"
               size="30"/>
    </p>
    <?php
}

add_action('save_post', 'save_custom_meta_box');

function save_custom_meta_box()
{
    global $post;
    // Get our form field
    if ($_POST) :
        $custom_meta = esc_attr($_POST['phone_number']);
        // Update post meta
        update_usermeta($post->post_author, 'phone_number', $custom_meta);
    endif;
}
