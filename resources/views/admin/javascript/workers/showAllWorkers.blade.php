<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        
        var workers = "{{$workers}}";
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            "ajax":{
                "url": "{{ route('admin.workers.data.all', ['workers' => $workers]) }}", 
                "type": "GET",
                "data": {workers: workers },
            },
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

                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'country.country_name', name: 'Country.country_name' },
                { data: 'product_category.category_name', name: 'ProductCategory.category_name' },

                { data: 'status', name: 'status'},

                {
                    data: 'actions', 
                    name: 'actions', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });

    });
</script>