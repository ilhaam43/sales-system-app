<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('auditor.researches.data')}}",
            "lengthMenu": [ 10, 20, 30, 50 ],
            columns: [

                { data:'id', name: 'id', render: function (data, type, row, meta) 
                    {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                { data: 'company_name', name: 'company_name'},
                { data: 'company_website', name: 'company_website'},
                { data: 'company_product_url', name: 'company_product_url'},
                { data: 'status', name: 'status'},

                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });

    });
</script>