
<?php
include('install.class.php');
$install = new Install();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Installation</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen">
  </head>
  <body>
    <div class="container my-5">
                         
                  <h1><img src="logo.svg" width="48"> Lure Installation</h1>
                    <hr>

                    <?php if($install->isWritable()) { ?>

                        <?php if($install->stepIdent() == 1) { ?>
                            <form method="POST" action="?step=2">
                            <h3>Database</h3>
                        <div class="input">
                            <span>Host</span>
                                    <input placeholder="127.0.0.1" type="text" class="form-control" name="host" value="" required autofocus autocomplete="off">
                        </div>

                        <div class="input">
                            <span>Database Name</span>
                                    <input placeholder="" type="text" class="form-control" name="db" value="" required autocomplete="off">
                        </div>

                        <div class="input">
                            <span>Username</span>
                                    <input placeholder="" type="text" class="form-control" name="user" value="" required autocomplete="off">
                        </div>

                        <div class="input">
                            <span>Password</span>
                                    <input placeholder="*******" type="password" class="form-control" name="pass" value="" required autocomplete="off">
                        </div>
                        
                        <hr>

                        <h3>APP Details</h3>
                        <div class="input">
                            <span>APP Url</span>
                                    <input placeholder="https://codeland.fun" type="text" class="form-control" name="app_url" value="" required autocomplete="off">
                        </div>
                        <hr>

                        <h3>Login Credentials</h3>
                        <div class="input">
                            <span>E-mail</span>
                                    <input placeholder="your@email.com" type="email" class="form-control" name="email" value="" required autocomplete="off">
                        </div>

                        <div class="input">
                            <span>Password</span>
                                    <input placeholder="*******" type="password" class="form-control" name="pass1" value="" required autocomplete="off">
                        </div>

                        <div class="input">
                            <span>Repeat Password</span>
                                    <input placeholder="*******" type="password" class="form-control" name="pass2" value="" required autocomplete="off">
                        </div>
                            
                        

                        <button type="submit" class="save-button">Continue</button>
                        </form>
                        <?php } ?>


                        <?php if($install->stepIdent() == 2) { ?>
                            <?php if($install->checkConnection() && $install->checkCredentials()) { ?>
                                <div class="alert alert-success">
                                    <p>Your MySQL & User credentials are correct. You can proceed with the installation.</p>
                                </div>
                                <div class="row">
                                    <div class="col-6"><a onclick="history.back(); return false;" href="#" class="save-button">Go Back</a></div>
                                    <div class="col-6">
                                        <form method="POST" action="?step=3">
                                            <input type="hidden" name="host" value="<?php echo $_POST['host']; ?>">
                                            <input type="hidden" name="db" value="<?php echo $_POST['db']; ?>">
                                            <input type="hidden" name="user" value="<?php echo $_POST['user']; ?>">
                                            <input type="hidden" name="pass" value="<?php echo $_POST['pass']; ?>">
                                            <input type="hidden" name="app_url" value="<?php echo $_POST['app_url']; ?>">
                                            <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
                                            <input type="hidden" name="pass1" value="<?php echo $_POST['pass1']; ?>">
                                            <input type="hidden" name="pass2" value="<?php echo $_POST['pass2']; ?>">
                                            <button type="submit" class="save-button">Install Lure</button>
                                        </form>
                                    </div>
                                </div>
                                
                            <?php } else { ?>

                                <?php if(!$install->checkConnection()) { ?>
                                <div class="alert alert-danger">
                                    <p>Connection to the MySQL server with credentials you provided failed.</p>
                                    <p>Please make sure:
                                        <ul>
                                            <li>You have created the database. It must exists prior to the installation.</li>
                                            <li>Your credentials are correct.</li>
                                        </ul>
                                    </p>
                                </div>
                                <?php } ?>

                                <?php if(!$install->checkCredentials()) { ?>
                                <div class="alert alert-danger">
                                    <p>Your User credentials are incorrect.</p>
                                    <p>Please make sure:
                                        <ul>
                                            <li>You have entered a valid Email</li>
                                            <li>Your password and repeated password are the same.</li>
                                        </ul>
                                    </p>
                                </div>
                                <?php } ?>
                                <a onclick="history.back(); return false;" href="#" class="save-button">Go Back</a>
                            <?php } ?>
                            <?php } ?>
                            
                            <?php if($install->stepIdent() == 3) { ?>
                            <?php if($install->checkConnection() && $install->checkCredentials() && $install->runInstall()) { ?>
                                <div class="alert alert-success">
                                    <p>Installation sucessfull.</p><br>
                                    <p>Do not forget to delete this install script. Delete folder "Install" in /public/ folder.</p><br>
                                    <p>You can now Login into Lure Booking Software with your credentials by clicking the button below.</p>
                                </div>
                                <a href="/login" class="save-button">Login</a>
                                
                            <?php } else { ?>

                                <?php if(!$install->checkConnection()) { ?>
                                <div class="alert alert-danger">
                                    <p>Connection to the MySQL server with credentials you provided failed.</p>
                                    <p>Please make sure:
                                        <ul>
                                            <li>You have created the database. It must exists prior to the installation.</li>
                                            <li>Your credentials are correct.</li>
                                        </ul>
                                    </p>
                                </div>
                                <?php } ?>

                                <?php if(!$install->runInstall()) { ?>
                                <div class="alert alert-danger">
                                    <p>Installation failed.</p>
                                    <p>The database tables allready exists.</p>
                                    <p>If you think that this is an error, please contact our support.</p>
                                </div>
                                <?php } ?>

                                <?php if(!$install->checkCredentials()) { ?>
                                <div class="alert alert-danger">
                                    <p>Your User credentials are incorrect.</p>
                                    <p>Please make sure:
                                        <ul>
                                            <li>You have entered a valid Email</li>
                                            <li>Your password and repeated password are the same.</li>
                                        </ul>
                                    </p>
                                </div>
                                <?php } ?>
                                <a href="?step=1" class="save-button">Go Back</a>
                            <?php } ?>
                            <?php } ?>
                    <?php } else { ?>
                        <div class="alert alert-danger">
                            <p>The .env file is not writable. Please make sure it is writable on your server, so we can proceed with the installation.</p>
                            <p>Where is .env file located?<br>You can find .env file in the root folder of Lure application.</p>
                        </div>
                    <?php } ?>
    </div>
</body>
</html>