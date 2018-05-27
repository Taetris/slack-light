<?php require_once('partials/header.php'); ?>


<div class="container">
    <div class="row main">

        <div class="panel-heading">
            <div class="panel-title text-center">
                <h1 class="title">Slack Light</h1>
                <hr/>
            </div>
        </div>

        <div class="main-login main-center">
            <form class="form-horizontal" method="post" action="#">

                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Username</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Enter your Username"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Password</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                            <input type="password" class="form-control" name="email" id="email"
                                   placeholder="Enter your Password"/>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <button type="button" class="btn btn-primary btn-lg btn-block login-button">Login</button>
                </div>

                <div class="login-register">
                    <a href="index.php">Not a user yet? Click here to register</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('partials/footer.php'); ?>
