<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/admin/js/ajax/inquiries/selectAllCheckbox.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/deleteReports.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/reports/removeMultiReports.js') }}"></script>
<script>
$(document).ready(function(){
    $("#openAll").click(function(){
        var res = []
        var data = $("table input:checkbox:checked")
        
        data.map(function(){
            var id = parseInt(this.value)
            res.push(id)
        })

        @foreach($researchJobsLists as $researchjobs)
        var id = "{{ $researchjobs['id'] }}"

        if(jQuery.inArray( parseInt(id), res) !== -1){
            var windowPopup = window.open("{{ route('admin.reports.update',$researchjobs['id']) }}", '_blank');
        }
        @endforeach 
    })
})
</script>
