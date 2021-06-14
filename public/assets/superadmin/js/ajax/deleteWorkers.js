function deleteConfirmation(id, workers) {
    swal({
        title: "Delete " + workers + " data",
        text: "Are you sure to delete this data?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "/superadmin/workers/" + workers + "/" + id,
                data: {_token: CSRF_TOKEN, _method: 'DELETE'},
                dataType: 'JSON',
                success: function (results) {
                    if (results.success === true) {
                        swal("Done!", results.message, "success");
                        window.setTimeout(function(){ 
                            window.location.replace('/superadmin/workers/' + workers);
                        } ,2000);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        } else {
            e.dismiss;
        }

    }, function (dismiss) {
        return false;
    })
}
