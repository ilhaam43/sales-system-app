<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('admin.inquiries.data.removed')}}",
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

                { data: 'research_jobs.company_name', name: 'ResearchJobs.company_name', orderable: false },

                {   data: 'screenshot', 
                    name: 'screenshot', 
                    orderable: false, 
                    searchable: false 
                },

                {   data: 'website', 
                    name: 'website', 
                    orderable: false, 
                    searchable: false 
                },

                { data: 'user', name: 'user'},

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