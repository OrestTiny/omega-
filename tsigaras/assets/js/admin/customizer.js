jQuery(document).ready(function ($) {
  "use strict";

  $('.customize-control-dropdown-select2').each(function () {
    $('.customize-control-select2').select2({
      allowClear: true
    });
  });

  $(".customize-control-select2").on("change", function () {
    let select2Val = $(this).val();
    $(this).parent().find('.customize-control-dropdown-select2').val(select2Val).trigger('change');
  });

  // Update the values for all our input fields and initialise the sortable repeater
  $('.sortable_repeater_control').each(function () {
    // If there is an existing customizer value, populate our rows
    let defaultValuesArray = $(this).find('.customize-control-sortable-repeater').val().split(',');
    let numRepeaterItems = defaultValuesArray.length;
    if (numRepeaterItems > 0) {
      // Add the first item to our existing input field
      $(this).find('.repeater-input').val(defaultValuesArray[0]);
      // Create a new row for each new value
      if (numRepeaterItems > 1) {
        let i;
        for (i = 1; i < numRepeaterItems; ++i) {
          tsigarasAppendRow($(this), defaultValuesArray[i]);
        }
      }
    }
  });
  // Make our Repeater fields sortable
  $(this).find('.sortable_repeater.sortable').sortable({
    update: function (event, ui) {
      tsigarasGetAllInputs($(this).parent());
    }
  });
  // Remove item starting from it's parent element
  $('.sortable_repeater.sortable').on('click', '.customize-control-sortable-repeater-delete', function (event) {
    event.preventDefault();
    let numItems = $(this).parent().parent().find('.repeater').length;
    if (numItems > 1) {
      $(this).parent().slideUp('fast', function () {
        let parentContainer = $(this).parent().parent();
        $(this).remove();
        tsigarasGetAllInputs(parentContainer);
      })
    }
    else {
      $(this).parent().find('.repeater-input').val('');
      tsigarasGetAllInputs($(this).parent().parent().parent());
    }
  });
  // Add new item
  $('.customize-control-sortable-repeater-add').click(function (event) {
    event.preventDefault();
    tsigarasAppendRow($(this).parent());
    tsigarasGetAllInputs($(this).parent());
  });
  // Refresh our hidden field if any fields change
  $('.sortable_repeater.sortable').change(function () {
    tsigarasGetAllInputs($(this).parent());
  })
  // Add https:// to the start of the URL if it doesn't have it
  $('.sortable_repeater.sortable').on('blur', '.repeater-input', function () {
    let url = $(this);
    let val = url.val();
    if (val && !val.match(/^.+:\/\/.*/)) {
      // Important! Make sure to trigger change event so Customizer knows it has to save the field
      url.val('https://' + val).trigger('change');
    }
  });
  // Append a new row to our list of elements
  function tsigarasAppendRow($element, defaultValue = '') {
    let newRow = '<div class="repeater" style="display:none"><input type="text" value="' + defaultValue + '" class="repeater-input" placeholder="https://" /><span class="dashicons dashicons-sort"></span><a class="customize-control-sortable-repeater-delete" href="#"><span class="dashicons dashicons-no-alt"></span></a></div>';
    $element.find('.sortable').append(newRow);
    $element.find('.sortable').find('.repeater:last').slideDown('slow', function () {
      $(this).find('input').focus();
    });
  }
  // Get the values from the repeater input fields and add to our hidden field
  function tsigarasGetAllInputs($element) {
    let inputValues = $element.find('.repeater-input').map(function () {
      return $(this).val();
    }).toArray();
    // Add all the values from our repeater fields to the hidden field (which is the one that actually gets saved)
    $element.find('.customize-control-sortable-repeater').val(inputValues);
    // Important! Make sure to trigger change event so Customizer knows it has to save the field
    $element.find('.customize-control-sortable-repeater').trigger('change');
  }

  $('.single-accordion-toggle').on('click', function () {
    let $accordionToggle = $(this);
    $(this).parent().find('.single-accordion').slideToggle('slow', function () {
      $accordionToggle.toggleClass('single-accordion-toggle-rotate', $(this).is(':visible'));
    });
  });

  $('.customize-control-tinymce-editor').each(function () {
    // Get the toolbar strings that were passed from the PHP Class
    let tinyMCEToolbar1String = _wpCustomizeSettings.controls[$(this).attr('id')].tsigarastinymcetoolbar1;
    let tinyMCEToolbar2String = _wpCustomizeSettings.controls[$(this).attr('id')].tsigarastinymcetoolbar2;
    let tinyMCEMediaButtons = _wpCustomizeSettings.controls[$(this).attr('id')].tsigarasmediabuttons;

    wp.editor.initialize($(this).attr('id'), {
      tinymce: {
        wpautop: true,
        toolbar1: tinyMCEToolbar1String,
        toolbar2: tinyMCEToolbar2String
      },
      quicktags: true,
      mediaButtons: tinyMCEMediaButtons
    });
  });
  $(document).on('tinymce-editor-init', function (event, editor) {
    editor.on('change', function (e) {
      tinyMCE.triggerSave();
      $('#' + editor.id).trigger('change');
    });
  });

  $(".pill_checkbox_control .sortable").sortable({
    placeholder: "pill-ui-state-highlight",
    update: function (event, ui) {
      tsigarasGetAllPillCheckboxes($(this).parent());
    }
  });

  $('.pill_checkbox_control .sortable-pill-checkbox').on('change', function () {
    tsigarasGetAllPillCheckboxes($(this).parent().parent().parent());
  });

  // Get the values from the checkboxes and add to our hidden field
  function tsigarasGetAllPillCheckboxes($element) {
    let inputValues = $element.find('.sortable-pill-checkbox').map(function () {
      if ($(this).is(':checked')) {
        return $(this).val();
      }
    }).toArray();
    $element.find('.customize-control-sortable-pill-checkbox').val(inputValues).trigger('change');
  }

});