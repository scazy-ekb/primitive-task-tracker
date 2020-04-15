((function(taskService) {
    $(document).ready(async () => {

        let page = 0;
        let pageSize = 3;
        let order = true;
        let column = 'username';
        let total = 0;
        let totalPages = 0;

        let isAdminMode = $('#task-board').data('board-mode') == 'admin';

        let $table = $('#tasks-table');
        let $pager = $('#pager');

        let mapTask = (task) => `<tr id='task_${task.id}' class="task">`
            + `<td>${task.username}</td>`
            + `<td>${task.email}</td>`
            + `<td class="${isAdminMode ? "editable" : ""}"><span class="description">${htmlDecode(task.description)}</span></td>`
            + `<td><div class="custom-control custom-switch task-status">`
                + `<input id="status_${task.id}" type="checkbox" class="editable custom-control-input" ${task.status ? "checked" : ""} ${!isAdminMode ? "disabled" : ""}>`
                + `<label class="custom-control-label" for="status_${task.id}"></label>`
            + `</div></td>`
            + `</tr>`;

        let getId = (el) => parseInt(el.attr('id').split('_')[1]);
        let htmlDecode = (input) => {
            let e = document.createElement('textarea');
            e.innerHTML = input;
            let result = e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
            e.remove();
            return result;
        };

        let editDescription = async ($el, description) => {
            return await new Promise((resolve, reject) => {
                var $input = $(`<textarea class="description-editor" rows="10" required>${description}</textarea>`);

                let $save = $('<button type="submit" class="btn btn-primary btn-sm float-right mt-2">Save</button>');
                let $cancel = $('<button type="button" class="btn btn-secondary btn-sm float-right mt-2 ml-2">Cancel</button>');

                $el.after($input);
                $input.after($cancel);
                $cancel.after($save);

                let done = (value) => {
                    $input.remove();
                    $save.remove();
                    $cancel.remove();

                    if (value)
                        resolve(value);
                    else
                        resolve(false);
                };

                $save.click(() => done($input.val()));
                $cancel.click(() => done(false));
            });
        };

        let refreshPage = async () => {

            let tasksResult = await taskService.getTasks(page, pageSize, order, column);
            let tasks = tasksResult.tasks;
            total = tasksResult.totalRowsCount;
            totalPages = total / pageSize;
            $table.find('tbody').empty().append(tasks.map(task => mapTask(task)));

            $table.find('tbody td.editable .description').click(async (e) => {
                let $el = $(e.target);
                let description = $el.text();
                $el.hide();
                let newDescription = await editDescription($el, description);

                if (newDescription !== false && newDescription !== description) {
                    let $task = $el.closest('.task');
                    let taskId = getId($task);
                    let $checkbox = $task.find('.task-status input');
                    let status = $checkbox.is(':checked');
                    if (await taskService.editTask(taskId, newDescription, status)) {
                        $el.text(newDescription);
                    }
                }

                $el.show();
            });

            $table.find('tbody .task-status').mousedown(async (e) => {
                let $checkbox = $(e.target).closest('.task-status').find('input');
                let status = !$checkbox.is(':checked');
                let $task = $checkbox.closest('.task');
                let taskId = getId($task);
                if (!await taskService.editTask(taskId, $task.find('.description').text(), status)) {
                    e.preventDefault();
                }
            });

            $pager.find('li:not(.prev,.next)').remove();

            for (let i = 0; i < totalPages; i++) {
                $pager.find('.next').before(`<li id="page_${i}" class="page-item"><a class="page-link" href="#">${i+1}</a></li>`);
            }

            $pager.find(`#page_${page}`).addClass('active');

            $pager.find('li.prev').toggleClass('disabled', page == 0);
            $pager.find('li.next').toggleClass('disabled', page >= (totalPages - 1));

            $pager.find('li:not(.prev,.next)').click(async (e) => {
                page = getId($(e.target).closest('li'));
                await refreshPage();
            });
        };

        $table.find('th.sortable').click(async (e) => {
            let $th = $(e.target);
            let siblings = $table.find('th').not($th);
            siblings.removeClass("active");
            column = $th.data('col-name');
            order = !$th.hasClass("order-asc");
            page = 0;
            $th.addClass("active").toggleClass("order-asc order-desc");
            await refreshPage();
        });

        $pager.find('li.prev').click(async (e) => {
            let $prev = $(e.target);
            if (!$prev.hasClass('disabled') && page > 0) {
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

        $('#modal form').submit(async (e) => {
            e.preventDefault();
            let formData = $('#modal form').serializeArray();
            let data = {};
            formData.forEach(obj => {
                data[obj.name] = obj.value;
            });

            try {
                await taskService.createTask(data['username'], data['email'], data['description'], data['status'] === "on");
                await refreshPage();
                $('#modal form')[0].reset();
                $("#modal .close").click();
            }
            catch (errors) {
                $('#modal form small.form-text').hide();
                for(var name in  errors)
                    $(`#modal form #${name} + small.form-text`).text(errors[name]).show();
            }
        });

        await refreshPage();
    });
})(window.TaskService));