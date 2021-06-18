<table class="table table-bordered display" width="100%" cellspacing="0">
    <thead>
        <tr>
                <th>No</th>
                <th>Name</th>
                <th>Website</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Product Page</th>
                <th>Country</th>
                <th>Status</th>
                <th>Researches</th>
                <th>Auditor</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $item['company_name'] ?? "NULL" }}</td>
            <td>{{ $item['company_website'] ?? "NULL" }}</td>
            <td>{{ $item['company_email'] ?? "NULL" }}</td>
            <td>{{ $item['company_phone'] ?? "NULL" }}</td>
            <td>{{ $item['company_product_url'] ?? "NULL" }}</td>
            <td>{{ $item['country']['country_name'] ?? "NULL" }}</td>
            <td>{{ $item['jobs_status']['status'] ?? "NULL" }}</td>
            <td>{{ $item['user']['name'] ?? "NULL" }}</td>
            <td>{{ $item['auditor_research_jobs']['user']['name'] ?? "NO" }}</td>
        </tr>
    @endforeach
    </tbody>
</table>