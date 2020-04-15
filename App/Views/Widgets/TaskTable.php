<style>
    th.sortable { cursor: pointer; }
    th.sortable:after { margin-left: 5px; content: "\21C5"; color: gray; }
    th.sortable.order-asc.active:after { content: "\2191"; color: white; }
    th.sortable.order-desc.active:after { content: "\2193"; color: white; }
    tbody .description.editable, tbody input.editable + label:before { cursor: pointer; }
    .description-editor { display: block; width: 100%; }
    th.status-col { width: 100px; }
</style>
<ui id="pager" class="pagination pb-4 justify-content-end">
    <li class="page-item prev"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item next"><a class="page-link" href="#">Next</a></li>
</ui>
<table id="tasks-table" class="table table-striped table-hover">
    <thead>
    <tr>
        <th data-col-name="username" class="sortable active order-asc username-col">User Name</th>
        <th data-col-name="email" class="sortable order-desc">Email</th>
        <th data-col-name="description order-desc">Description</th>
        <th data-col-name="status" class="sortable order-desc status-col">Status</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
