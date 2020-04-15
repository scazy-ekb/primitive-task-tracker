<style>
    th.sortable { cursor: pointer; }
    th.sortable.order-asc {}
    th.sortable.order-desc {}
    th.sortable:after { margin-left: 5px; content: "\21C5"; color: gray; }
    th.sortable.order-asc.active:after { content: "\2191"; color: white; }
    th.sortable.order-desc.active:after { content: "\2193"; color: white; }
</style>
<ui id="pager" class="pagination pb-4 justify-content-end">
    <li class="page-item prev"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item next"><a class="page-link" href="#">Next</a></li>
</ui>
<table id="tasks-table" class="table table-striped table-hover">
    <thead>
    <tr>
        <th data-col-name="username" class="sortable active order-asc">User Name</th>
        <th data-col-name="email" class="sortable order-asc">Email</th>
        <th data-col-name="description order-asc">Description</th>
        <th data-col-name="status" class="sortable order-asc">Status</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
