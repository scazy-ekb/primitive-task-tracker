<script>
    ((function(taskService) {
        $(document).ready(() => {
            $('#modal form').submit(async (e) => {
               e.preventDefault();
               let formData = $('#modal form').serializeArray();
               let data = {};
               formData.forEach(obj => {
                   data[obj.name] = obj.value;
               });

               try {
                   await taskService.createTask(data['username'], data['email'], data['description'], data['status'] === "on");
                   $('#modal form')[0].reset();
                   $("#modal .close").click();
               }
               catch (errors) {
                   $('#modal form small.form-text').hide();
                   for(var name in  errors)
                       $(`#modal form #${name} + small.form-text`).text(errors[name]).show();
               }
            });
        });
    })(window.TaskService));
</script>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="username">User Name</label>
                    <input id="username" name="username" class="form-control" required>
                    <small class="form-text text-danger"></small>
                    <label for="email">Email</label>
                    <input id="email" name="email" class="form-control" required>
                    <small class="form-text text-danger"></small>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="10" required></textarea>
                    <small class="form-text text-danger"></small>
                    <div class="form-check has-danger">
                        <label for="status" class="form-check-label">
                            <input type="checkbox" id="status" name="status" class="form-check-input">
                            Status
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>