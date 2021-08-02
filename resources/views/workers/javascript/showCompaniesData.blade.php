<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('inqurier.data.company')}}",
            "lengthMenu": [ 10, 20, 30, 50 ],
            columns: [

                { data:'id', name: 'id', render: function (data, type, row, meta) 
                    {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                { data: 'company_name', name: 'company_name'},
                {
                    data: 'company_websites', 
                    name: 'company_websites', 
                    orderable: false, 
                    searchable: false
                },
                { data: 'country.country_name', name: 'Country.country_name'},

                {
                    data: 'inquiry', 
                    name: 'inquiry', 
                    orderable: false, 
                    searchable: false
                },

                {
                    data: 'website_problem', 
                    name: 'website_problem', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });

    });
</script>