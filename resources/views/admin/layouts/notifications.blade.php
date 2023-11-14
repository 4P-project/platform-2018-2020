<script>
    jQuery(function() {
        PNotify.prototype.options.styling = "bootstrap3";
        PNotify.prototype.options.styling = "jqueryui";
        PNotify.prototype.options.styling = "fontawesome";

        @if(session()->has('message'))
        new PNotify({
            title: 'SUCCESS',
            type: 'success',
            text: '{{ session()->get('message') }}',
            after_init: function(notice) {
                notice.attention('tada');
            }
        });
        @endif
    });
</script>
