<style>
</style>
<script src="/js/AccountService.js"></script>
<script>
    $(document).ready(function () {

        let accountService = new AccountService();

        $('form').submit(async (e) => {
            e.preventDefault();
            const name = $('#name').val();
            const email = $('#email').val();
            const password = $('#password').val();
            if (await accountService.register(name, email, password))             {
                window.location = "/";
            }
        });
    });
</script>
<div class="container">
    <div class="card card-block">
        <div class="card-body">
            <form method="post">
                <h1>Register</h1>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" class="form-control">
                    <small id="name-validate" class="form-text text-danger" style="display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control">
                    <small id="email-validate" class="form-text text-danger" style="display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control">
                    <small id="password-validate" class="form-text text-danger" style="display: none;"></small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Register</button>
                    or <a href="/page/login">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>