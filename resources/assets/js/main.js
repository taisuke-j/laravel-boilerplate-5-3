;(function($) {

  'use strict';

  $(function() {

    var $doc = $(document);
    var $body = $('body');

    // Deletes an instance from the list
    var deleteDataAttr = '[data-delete-id]';
    var comfirmDataAttr = '[data-delete-comfirm]';

    $doc.on('click', deleteDataAttr, function(e) {

      e.preventDefault();

      var target = e.target;
      var $link = target.hasAttribute(deleteDataAttr) ? $(target) : $(target).closest(deleteDataAttr);
      var $form = $('#' + $link.data('deleteId'));
      if (confirm($link.data('deleteConfirm'))) {
        $form.submit();
      }

    });

  });

})(jQuery);
