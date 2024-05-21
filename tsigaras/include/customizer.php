<?php

/**
 * Custom fields for Customizer
 */
if (class_exists('WP_Customize_Control')) {
  class Tsigaras_Select2_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'dropdown_select2';
    /**
     * The type of Select2 Dropwdown to display. Can be either a single select dropdown or a multi-select dropdown. Either false for true. Default = false
     */
    private $multiselect = false;
    /**
     * The Placeholder value to display. Select2 requires a Placeholder value to be set when using the clearall option. Default = 'Please select...'
     */
    private $placeholder = 'Please select...';
    /**
     * Constructor
     */
    public function __construct($manager, $id, $args = array(), $options = array())
    {
      parent::__construct($manager, $id, $args);
      // Check if this is a multi-select field
      if (isset($this->input_attrs['multiselect']) && $this->input_attrs['multiselect']) {
        $this->multiselect = true;
      }
      // Check if a placeholder string has been specified
      if (isset($this->input_attrs['placeholder']) && $this->input_attrs['placeholder']) {
        $this->placeholder = $this->input_attrs['placeholder'];
      }
    }
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_script('select2', TSIGARAS_T_URI . '/assets/js/lib/select2.min.js', array('jquery'), null, true);
      wp_enqueue_script('tsigaras-customizer', TSIGARAS_T_URI . '/assets/js/admin/customizer.min.js', array('select2'), null, true);
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
      wp_enqueue_style('select2', TSIGARAS_T_URI . '/assets/css/lib/select2.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
      $defaultValue = $this->value();

      if ($this->multiselect) {
        $defaultValue = explode(',', $this->value());
      }
?>
      <div class="dropdown_select2_control">
        <?php if (!empty($this->label)) { ?>
          <label for="<?php echo esc_attr($this->id); ?>" class="customize-control-title">
            <?php echo esc_html($this->label); ?>
          </label>
        <?php } ?>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>
        <input type="hidden" id="<?php echo esc_attr($this->id); ?>" class="customize-control-dropdown-select2" value="<?php echo esc_attr($this->value()); ?>" name="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> />
        <select name="select2-list-<?php echo ($this->multiselect ? 'multi[]' : 'single'); ?>" class="customize-control-select2" data-placeholder="<?php echo $this->placeholder; ?>" <?php echo ($this->multiselect ? 'multiple="multiple" ' : ''); ?>>
          <?php
          if (!$this->multiselect) {
            // When using Select2 for single selection, the Placeholder needs an empty <option> at the top of the list for it to work (multi-selects dont need this)
            echo '<option></option>';
          }
          foreach ($this->choices as $key => $value) {

            if ($this->multiselect) {
              echo '<option value="' . esc_attr($key) . '" ' . (in_array(esc_attr($key), $defaultValue) ? 'selected="selected"' : '') . '>' . esc_attr($value) . '</option>';
            } else {
              echo '<option value="' . esc_attr($key) . '" ' . selected(esc_attr($key), $defaultValue, false)  . '>' . esc_attr($value) . '</option>';
            }
          }
          ?>
        </select>
      </div>
    <?php
    }
  }
  class Tsigaras_Sortable_Repeater_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'sortable_repeater';
    /**
     * Button labels
     */
    public $button_labels = array();
    /**
     * Constructor
     */
    public function __construct($manager, $id, $args = array(), $options = array())
    {
      parent::__construct($manager, $id, $args);
      // Merge the passed button labels with our default labels
      $this->button_labels = wp_parse_args(
        $this->button_labels,
        array(
          'add' => __('Add', 'tsigaras'),
        )
      );
    }
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_script('tsigaras-customizer', TSIGARAS_T_URI . '/assets/js/admin/customizer.min.js', array('jquery', 'jquery-ui-core'), null, true);
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
    ?>
      <div class="sortable_repeater_control">
        <?php if (!empty($this->label)) { ?>
          <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php } ?>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>
        <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="customize-control-sortable-repeater" <?php $this->link(); ?> />
        <div class="sortable_repeater sortable">
          <div class="repeater">
            <input type="text" value="" class="repeater-input" placeholder="https://" /><span class="dashicons dashicons-sort"></span><a class="customize-control-sortable-repeater-delete" href="#"><span class="dashicons dashicons-no-alt"></span></a>
          </div>
        </div>
        <button class="button customize-control-sortable-repeater-add" type="button"><?php echo $this->button_labels['add']; ?></button>
      </div>
    <?php
    }
  }
  class Tsigaras_Toggle_Switch_Custom_control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'toggle_switch';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
    ?>
      <div class="toggle-switch-control">
        <div class="toggle-switch">
          <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link();
                                                                                                                                                                                                  checked($this->value()); ?>>
          <label class="toggle-switch-label" for="<?php echo esc_attr($this->id); ?>">
            <span class="toggle-switch-inner"></span>
            <span class="toggle-switch-switch"></span>
          </label>
        </div>
        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>
      </div>
    <?php
    }
  }
  class Tsigaras_Image_Radio_Button_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'image_radio_button';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    { ?>
      <div class="image_radio_button_control">
        <?php if (!empty($this->label)) { ?>
          <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php } ?>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>

        <?php foreach ($this->choices as $key => $value) { ?>
          <label class="radio-button-label">
            <input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked(esc_attr($key), $this->value()); ?> />
            <img src="<?php echo esc_attr($value['image']); ?>" alt="<?php echo esc_attr($value['name']); ?>" title="<?php echo esc_attr($value['name']); ?>" />
          </label>
        <?php  } ?>
      </div>
    <?php
    }
  }
  class Tsigaras_Text_Radio_Button_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'text_radio_button';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
    ?>
      <div class="text_radio_button_control">
        <?php if (!empty($this->label)) { ?>
          <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php } ?>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>

        <div class="radio-buttons">
          <?php foreach ($this->choices as $key => $value) { ?>
            <label class="radio-button-label">
              <input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked(esc_attr($key), $this->value()); ?> />
              <span><?php echo esc_html($value); ?></span>
            </label>
          <?php  } ?>
        </div>
      </div>
    <?php
    }
  }
  class Tsigaras_Single_Accordion_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'single_accordion';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_script('tsigaras-customizer', TSIGARAS_T_URI . '/assets/js/admin/customizer.min.js', array(''), null, true);
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
      $allowed_html = array(
        'a' => array(
          'href' => array(),
          'title' => array(),
          'class' => array(),
          'target' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'i' => array(
          'class' => array()
        ),
      );
    ?>
      <div class="single-accordion-custom-control">
        <div class="single-accordion-toggle"><?php echo esc_html($this->label); ?><span class="accordion-icon-toggle dashicons dashicons-plus"></span></div>
        <div class="single-accordion customize-control-description">
          <?php
          if (is_array($this->description)) {
            echo '<ul class="single-accordion-description">';
            foreach ($this->description as $key => $value) {
              echo '<li>' . $key . wp_kses($value, $allowed_html) . '</li>';
            }
            echo '</ul>';
          } else {
            echo wp_kses($this->description, $allowed_html);
          }
          ?>
        </div>
      </div>
    <?php
    }
  }
  class Tsigaras_Simple_Notice_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'simple_notice';
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
      $allowed_html = array(
        'a' => array(
          'href' => array(),
          'title' => array(),
          'class' => array(),
          'target' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'i' => array(
          'class' => array()
        ),
        'span' => array(
          'class' => array(),
        ),
        'code' => array(),
      );
    ?>
      <div class="simple-notice-custom-control">
        <?php if (!empty($this->label)) { ?>
          <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php } ?>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo wp_kses($this->description, $allowed_html); ?></span>
        <?php } ?>
      </div>
    <?php
    }
  }
  class Tsigaras_TinyMCE_Custom_control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'tinymce_editor';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_script('tsigaras-customizer', TSIGARAS_T_URI . '/assets/js/admin/customizer.min.js', array('jquery', 'jquery-ui-core'), null, true);
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
      wp_enqueue_editor();
    }
    /**
     * Pass our TinyMCE toolbar string to JavaScript
     */
    public function to_json()
    {
      parent::to_json();
      $this->json['tsigarastinymcetoolbar1'] = isset($this->input_attrs['toolbar1']) ? esc_attr($this->input_attrs['toolbar1']) : 'bold italic bullist numlist alignleft aligncenter alignright link';
      $this->json['tsigarastinymcetoolbar2'] = isset($this->input_attrs['toolbar2']) ? esc_attr($this->input_attrs['toolbar2']) : '';
      $this->json['tsigarasmediabuttons'] = isset($this->input_attrs['mediaButtons']) && ($this->input_attrs['mediaButtons'] === true) ? true : false;
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
    ?>
      <div class="tinymce-control">
        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>
        <textarea id="<?php echo esc_attr($this->id); ?>" class="customize-control-tinymce-editor" <?php $this->link(); ?>><?php echo esc_html($this->value()); ?></textarea>
      </div>
    <?php
    }
  }
  class Tsigaras_Pill_Checkbox_Custom_Control extends WP_Customize_Control
  {
    /**
     * The type of control being rendered
     */
    public $type = 'pill_checkbox';
    /**
     * Define whether the pills can be sorted using drag 'n drop. Either false or true. Default = false
     */
    private $sortable = false;
    /**
     * The width of the pills. Each pill can be auto width or full width. Default = false
     */
    private $fullwidth = false;
    /**
     * Constructor
     */
    public function __construct($manager, $id, $args = array(), $options = array())
    {
      parent::__construct($manager, $id, $args);
      // Check if these pills are sortable
      if (isset($this->input_attrs['sortable']) && $this->input_attrs['sortable']) {
        $this->sortable = true;
      }
      // Check if the pills should be full width
      if (isset($this->input_attrs['fullwidth']) && $this->input_attrs['fullwidth']) {
        $this->fullwidth = true;
      }
    }
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
      wp_enqueue_script('tsigaras-customizer', TSIGARAS_T_URI . '/assets/js/admin/customizer.min.js', array('jquery', 'jquery-ui-core'), null, true);
      wp_enqueue_style('tsigaras-customizer', TSIGARAS_T_URI . '/assets/css/customizer.min.css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
      $reordered_choices = array();
      $saved_choices = explode(',', esc_attr($this->value()));

      // Order the checkbox choices based on the saved order
      if ($this->sortable) {
        foreach ($saved_choices as $key => $value) {
          if (isset($this->choices[$value])) {
            $reordered_choices[$value] = $this->choices[$value];
          }
        }
        $reordered_choices = array_merge($reordered_choices, array_diff_assoc($this->choices, $reordered_choices));
      } else {
        $reordered_choices = $this->choices;
      }
    ?>
      <div class="pill_checkbox_control">
        <?php if (!empty($this->label)) { ?>
          <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php } ?>
        <?php if (!empty($this->description)) { ?>
          <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>
        <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="customize-control-sortable-pill-checkbox" <?php $this->link(); ?> />
        <div class="sortable_pills<?php echo ($this->sortable ? ' sortable' : '') . ($this->fullwidth ? ' fullwidth_pills' : ''); ?>">
          <?php foreach ($reordered_choices as $key => $value) { ?>
            <label class="checkbox-label">
              <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php checked(in_array(esc_attr($key), $saved_choices, true), true); ?> class="sortable-pill-checkbox" />
              <span class="sortable-pill-title"><?php echo esc_attr($value); ?></span>
              <?php if ($this->sortable && $this->fullwidth) { ?>
                <span class="dashicons dashicons-sort"></span>
              <?php } ?>
            </label>
          <?php  } ?>
        </div>
      </div>
<?php
    }
  }
}


/**
 * Callbacks
 */

if (!function_exists('tsigaras_validate_image')) {
  function tsigaras_validate_image($validity, $value)
  {

    // Get the url of the image
    $image = wp_get_attachment_image_src($value)[0];

    /*
        * Array of valid image file types.
        *
        * The array includes image mime types that are included in wp_get_mime_types()
        */
    $mimes = array(
      'svg' => 'image/svg+xml',
      'jpg|jpeg|jpe' => 'image/jpeg',
      'gif' => 'image/gif',
      'png' => 'image/png',
      'bmp' => 'image/bmp',
      'tif|tiff' => 'image/tiff',
      'ico' => 'image/x-icon'
    );
    // Return an array with file extension and mime_type.
    $file = wp_check_filetype($image, $mimes);

    if (!$value) {
      // If no image has been chosen, instruct user to choose an image
      $validity->add('required', esc_html__('Please choose an image', 'tsigaras'));
    } elseif (!$file['ext']) {
      // If a valid image file extension is not found, instruct user to choose appropriate image
      $validity->add('not_valid', esc_html__('Please choose a valid image type', 'tsigaras'));
    }
    return $validity;
  }
}

if (!function_exists('tsigaras_sanitize_url')) {
  function tsigaras_sanitize_url($url)
  {
    return esc_url_raw($url);
  }
}

if (!function_exists('tsigaras_sanitize_select')) {
  function tsigaras_sanitize_select($input, $setting)
  {

    // Ensure input is a slug.
    $input = sanitize_key($input);

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control($setting->id)->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return (array_key_exists($input, $choices) ? $input : $setting->default);
  }
}

if (!function_exists('tsigaras_sanitize_email')) {
  function tsigaras_sanitize_email($email, $setting)
  {
    return (is_email($email) ? $email : $setting->default);
  }
}

if (!function_exists('tsigaras_select2_sanitization')) {
  function tsigaras_select2_sanitization($input)
  {
    if (strpos($input, ',') !== false) {
      $input = explode(',', $input);
    }
    if (is_array($input)) {
      foreach ($input as $key => $value) {
        $input[$key] = sanitize_text_field($value);
      }
      $input = implode(',', $input);
    } else {
      $input = sanitize_text_field($input);
    }
    return $input;
  }
}

if (!function_exists('tsigaras_switch_sanitization')) {
  function tsigaras_switch_sanitization($input)
  {
    if (true === $input) {
      return 1;
    } else {
      return 0;
    }
  }
}

if (!function_exists('tsigaras_radio_sanitization')) {
  function tsigaras_radio_sanitization($input, $setting)
  {
    //get the list of possible radio box or select options
    $choices = $setting->manager->get_control($setting->id)->choices;

    if (array_key_exists($input, $choices)) {
      return $input;
    } else {
      return $setting->default;
    }
  }
}
