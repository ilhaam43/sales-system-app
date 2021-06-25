<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/admin/js/ajax/inquiries/approveInquiries.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/inquiries/rejectInquiries.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/inquiries/selectAllCheckbox.js') }}"></script>
<script>
$(document).ready(function(){
    $("#openAll").click(function(){
        var res = []
        var data = $("table input:checkbox:checked")
        
        data.map(function(){
            var id = parseInt(this.value)
            res.push(id)
        })

        @foreach($inquiryJobsLists as $inquiries)
        var id = "{{ $inquiries['id'] }}"

        if(jQuery.inArray( parseInt(id), res) !== -1){
            var windowPopup = window.open("{{ route('admin.inquiries.update',$inquiries['id']) }}", '_blank');
        }
        @endforeach 
    })
})
</script>
