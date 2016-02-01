<?php

class WDPSViewUninstall_wdps {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    global $wpdb;
    $prefix = $wpdb->prefix;
    ?>
    <form method="post" action="admin.php?page=uninstall_wdps" style="width:99%;">
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <div class="wrap">
        <span class="uninstall_icon"></span>
        <h2><?php echo __('Uninstall Post Slider WD','wdps_back'); ?></h2>
        <p>
          <?php echo __('Deactivating Post Slider WD plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.','wdps_back'); ?>
        </p>
        <p style="color: red;">
          <strong><?php echo __('WARNING:','wdps_back'); ?></strong>
          <?php echo __("Once uninstalled, this can't be undone. You should use a Database Backup plugin of WordPress to back up all the data first.",'wdps_back'); ?>
        </p>
        <p style="color: red">
          <strong><?php echo __('The following Database Tables will be deleted:','wdps_back'); ?></strong>
        </p>
        <table class="widefat">
          <thead>
            <tr>
              <th><?php echo __('Database Tables','wdps_back'); ?></th>
            </tr>
          </thead>
          <tr>
            <td valign="top">
              <ol>
                  <li><?php echo $prefix; ?>wdpsslider</li>
                  <li><?php echo $prefix; ?>wdpsslide</li>
                  <li><?php echo $prefix; ?>wdpslayer</li>              
              </ol>
            </td>
          </tr>
        </table>
        <p style="text-align: center;">
         <?php echo __('Do you really want to uninstall Post Slider WD plugin?','wdps_back'); ?>
        </p>
        <p style="text-align: center;">
          <input type="checkbox" name="Post Slider WD" id="check_yes" value="yes" />&nbsp;<label for="check_yes"><?php echo __('Yes','wdps_back'); ?></label>
        </p>
        <p style="text-align: center;">
          <input type="submit" value="<?php echo __('UNINSTALL','wdps_back'); ?>" class="button-primary" onclick="if (check_yes.checked) { 
                                                                                    if (confirm('<?php echo addslashes(__('You are About to Uninstall Post Slider WD plugin from WordPress.This Action Is Not Reversible.','wdps_back')); ?>')) {
                                                                                        spider_set_input_value('task', 'uninstall');
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                  }
                                                                                  else {
                                                                                    return false;
                                                                                  }" />
        </p>
      </div>
      <input id="task" name="task" type="hidden" value="" />
    </form>
  <?php
  }

  public function uninstall() {
    $flag = TRUE;
    global $wpdb;
    $this->model->delete_db_tables();
    $prefix = $wpdb->prefix;
    $deactivate_url = add_query_arg(array('action' => 'deactivate', 'plugin' => 'post-slider-wd/post-slider-wd.php'), admin_url('plugins.php'));
    $deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_post-slider-wd/post-slider-wd.php');
    ?>
    <div id="message" class="wd_updated fade">
      <p><?php echo __('The following Database Tables successfully deleted:','wdps_back'); ?></p>
      <p><?php echo $prefix; ?>wdpsslider,</p>
      <p><?php echo $prefix; ?>wdpsslide,</p>
      <p><?php echo $prefix; ?>wdpslayer.</p>
    </div>
    <?php
    if (isset($_POST['bwg_delete_files'])) {
    ?>
    <div class="<?php echo ($flag) ? 'wd_updated' : 'wp_error'?>">
      <p><?php echo ($flag) ? __('The folder was successfully deleted.','wdps_back') : __('An error occurred when deleting the folder.','wdps_back') ?></p>
    </div>
    <?php
    }
    ?>
    <div class="wrap">
      <h2><?php echo __('Uninstall Post Slider WD','wdps_back'); ?></h2>
      <p><strong><a href="<?php echo $deactivate_url; ?>"><?php echo __('Click Here','wdps_back'); ?></a> <?php echo __('To Finish the Uninstallation and Post Slider WD will be Deactivated Automatically.','wdps_back'); ?></strong></p>
      <input id="task" name="task" type="hidden" value="" />
    </div>
  <?php
  }
  
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}