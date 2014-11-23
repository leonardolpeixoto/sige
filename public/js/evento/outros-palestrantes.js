
$(function() {
    $('table').dataTable({
        "ordering": false,
        "filter": false,
        "info": false,
        "lengthChange": false,
        "paginate": false,
        "language": {
            "url": "/lib/js/data-tables/Portuguese-Brasil.json"
        }
    });

    $("#sel").select2({
        placeholder: _("Enter speaker e-mail..."),
        minimumInputLength: 3,
        tags: function(options) {
            // https://groups.google.com/forum/#!msg/select2/bOF3CPXsqjI/YmR3yHN2yc4J
            var url = "/evento/ajax-buscar-participante/termo/" + options.term;
            $.getJSON(url, null, function(json) {
                options.callback(json);
            });
        }
    });

    $('a.deletar').click(function () {
        var link = $(this).attr('href');
        alertify.confirm(_('Are you sure you want you delete the speaker from this event?'), function () {
            window.location = link;
        }).set('reverseButtons', true);
        return false;
    });

    $('a[data-toggle="tooltip"]').tooltip();
});
