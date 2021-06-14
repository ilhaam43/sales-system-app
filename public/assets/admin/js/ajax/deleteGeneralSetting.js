function deleteConfirmation(id) {
        swal({
            title: "Delete setting data",
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
                    url: "/admin/setting/" + id,
                    cache: false,
                    data: {_token: CSRF_TOKEN, _method: 'DELETE'},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                            window.setTimeout(function(){ 
                                window.location.replace('/admin/setting');
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
