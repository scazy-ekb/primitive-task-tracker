class AccountService {
    async login(name, password) {
        try {
            await $.post("/account/login", { name, password });
            return true;
        }
        catch (e) {
            return false;
        }
    }

    async register(name, email, password) {
        try {
            await $.post("/account/register", { name, email, password });
            return true;
        }
        catch (e) {
            return false;
        }
    }
}