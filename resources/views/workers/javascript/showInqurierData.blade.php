<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('inqurier.data.all')}}",
            "lengthMenu": [ 10, 20, 30, 50 ],
            columns: [

                { data:'id', name: 'id', render: function (data, type, row, meta) 
                    {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                { data: 'research_jobs.company_name', name: 'ResearchJobs.company_name'},
                { data: 'research_jobs.country.country_name', name: 'ResearchJobs.Country.country_name'},
                { data: 'research_jobs.company_website', name: 'ResearchJobs.company_website'},
                { data: 'jobs_status.status', name: 'JobsStatus.status'},
            ]
        });

    });
</script>