class TaskService {
    async getTasks(page, count, order, column) {
        try {
            return  await $.get("/task/getTasks", { page, count, column, order });
        }
        catch (e) {
            return false;
        }
    }

    async createTask(username, email, description, status) {
        try {
            return await $.post("/task/createTask", { username, email, description, status });
        }
        catch (e) {
            let errors = [];
            for (const name in e.responseJSON.errors)
                errors[name] = e.responseJSON.errors[name];
            throw errors;
        }
    }

    async editTask(id, description, status) {
        try {
            await $.post("/task/editTask", { id, description, status });
            return true;
        }
        catch (e) {
            return false;
        }
    }
}

window.TaskService = new TaskService();
