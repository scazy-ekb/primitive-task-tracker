<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
<style>
    #table_id { width: 100%; }
</style>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/tasks/index"
        });
    } );
</script>
<div class="container">
    <h1>Tasks</h1>
    <table id="table_id">
        <thead>
        <tr>
            <th>id</th>
            <th>userId</th>
            <th>description</th>
            <th>completed</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>