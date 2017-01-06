<?php
/**
 * The view for the admin page used for listing licenses.
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/admin/partials
 */
?>
 
<div class="wrap">
    <h2>
        <?php _e( 'Licenses', $this->plugin_name ); ?>
        <a class="add-new-h2" href="<?php echo admin_url( 'admin.php?page=wp-licenses-new' );?>">
            <?php _e( 'Add new', $this->plugin_name ) ?>
        </a>
    </h2>
 
    <?php $list_table->display(); ?>
</div>