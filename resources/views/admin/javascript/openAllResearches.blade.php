<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/admin/js/ajax/researches/approveResearcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/researches/rejectResearcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/researches/selectAllCheckbox.js') }}"></script>
<script>
$(document).ready(function(){
    $("#openAll").click(function(){
        var res = []
        var data = $("table input:checkbox:checked")
        
        data.map(function(){
            var id = parseInt(this.value)
            res.push(id)
        })

        @foreach($researchesList as $researches)
        var id = "{{ $researches['id'] }}"

        if(jQuery.inArray( parseInt(id), res) !== -1){
            var windowPopup = window.open("{{ $researches['company_website'] }}", '_blank');
        }
        @endforeach 
    })
})
</script>