<script src="/js/AccountService.js"></script>
<script>
    $(document).ready(function () {

        let accountService = new AccountService();

        $('form').submit(async (e) => {
            e.preventDefault();
            const name = $('#name').val();
            const password = $('#password').val();
            if (await accountService.login(name, password)) {
                window.location = "/";
            }
        });
    });
</script>
<div class="container">
    <form method="post">
        <h1>Login</h1>
        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" name="name" class="form-control">
            <small id="name-validate" class="form-text text-danger" style="display: none;"></small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="form-control" >
            <small id="password-validate" class="form-text text-danger" style="display: none;"></small>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
            or <a href="/page/register">Register</a>
        </div>
    </form>
</div>