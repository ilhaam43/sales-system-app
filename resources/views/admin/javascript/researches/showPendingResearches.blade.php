<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('admin.researches.data.pending')}}",
            "lengthMenu": [ 10, 20, 30, 50 ],
            columns: [
                { data: 'checkbox', 
                    name: 'checkbox', 
                    orderable: false, 
                    searchable: false 
                },

                { data:'id', name: 'id', render: function (data, type, row, meta) 
                    {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                { data: 'company_name', name: 'company_name'},

                { data: 'website', 
                    name: 'website', 
                    orderable: false, 
                    searchable: false 
                },
                
                { data: 'company_email', name: 'company_email'},
                { data: 'product_page', 
                    name: 'product_page', 
                    orderable: false, 
                    searchable: false 
                },
                { data: 'is_form', name: 'is_form'},
                { data: 'researcher', name: 'researcher'},
                

                { data: 'status', name: 'status'},

                { data: 'country', name: 'country'},
                
                { data: 'company_phone', name: 'company_phone'},

                { data: 'product_sources.sources', name: 'ProductSources.sources'},
                
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