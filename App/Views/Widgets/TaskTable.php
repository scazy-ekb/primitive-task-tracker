<script>
    ((function(taskService) {
        $(document).ready(async function () {

            let page = 0;
            let pageSize = 3;
            let order = true;
            let column = 'username';
            let total = 0;
            let totalPages = 0;

            let $table = $('#tasks-table');
            let $pager = $('#pager');

            let mapTask = (task) => `<tr id='task_${task.id}'><td>${task.username}</td><td>${task.email}</td><td>${htmlDecode(task.description)}</td><td><input type="checkbox" ${task.status ? "checked" : ""}></td></tr>`;
            let getId = (el) => parseInt(el.attr('id').split('_')[1]);
            let htmlDecode = (input) => {
                let e = document.createElement('textarea');
                e.innerHTML = input;
                return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
                e.remove();
            }
            let refreshPage = async () => {

                let tasksResult = await taskService.getTasks(page, pageSize, order, column);
                let tasks = tasksResult.tasks;
                total = tasksResult.totalRowsCount;
                totalPages = total / pageSize;
                $table.find('tbody').empty().append(tasks.map(task => mapTask(task)));

                $pager.find('li:not(.prev,.next)').remove();

                for (let i = 0; i < totalPages; i++) {
                    $pager.find('.next').before(`<li id="page_${i}" class="page-item"><a class="page-link" href="#">${i+1}</a></li>`);
                }

                $pager.find(`#page_${page}`).addClass('active');

                $pager.find('li.prev').toggleClass('disabled', page == 0);
                $pager.find('li.next').toggleClass('disabled', page >= (totalPages - 1));
            };

            await refreshPage();

            $table.find('th').click(async (e) => {
                let $th = $(e.target);
                let name = $th.data('column-name');
            });

            $pager.on('click', 'li:not(.prev,.next)', async (e) => {
                page = getId($(e.target).closest('li'));
                await refreshPage();
            });

            $pager.find('li.prev').click(async (e) => {
                let $el = $(e.target);
                if (!$el.hasClass('disabled') && page > 0) {
                    page--;
                    await refreshPage();
                }
            });

            $pager.find('li.next').click(async (e) => {
                let $el = $(e.target);
                if (!$el.hasClass('disabled') && page < (totalPages - 1)) {
                    page++;
                    await refreshPage();
                }
            });
        });
    })(window.TaskService));
</script>
<ui id="pager" class="pagination pb-4 justify-content-end">
    <li class="page-item prev"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item next"><a class="page-link" href="#">Next</a></li>
</ui>
<table id="tasks-table" class="table table-striped table-hover">
    <thead>
    <tr>
        <th data-col-name="username" class="order-asc">User Name</th>
        <th data-col-name="email">Email</th>
        <th data-col-name="description">Description</th>
        <th data-col-name="status">Status</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
