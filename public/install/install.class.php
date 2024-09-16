<?php

class Install {

    public function isWritable() {
        $filename = '../../.env';
        return is_writable($filename) ? true : false;
    }

    public function stepIdent()
    {
        return isset($_GET['step']) && !empty($_GET['step']) ? $_GET['step'] : 1;
    }

    public function checkConnection()
    {
        $host = $_POST['host'];
        $db = $_POST['db'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        try {
            $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
            $dbh = null;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function tableExists($pdo, $table) {

        try {
            $result = $pdo->query("SELECT 1 FROM {$table} LIMIT 1");
        } catch (Exception $e) {
            return FALSE;
        }
        return $result !== FALSE;
    }

    public function runInstall()
    {
        $host = $_POST['host'];
        $db = $_POST['db'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $app_url = $_POST['app_url'];
        $email = $_POST['email'];
        $hash = password_hash($_POST['pass1'], PASSWORD_BCRYPT, [10]);

        try {

            // Write do database
            $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

            if($this->tableExists($dbh, "users"))
                return false;

            $sql = file_get_contents('install.sql');

            $sql .= "LOCK TABLES `users` WRITE;";
            $sql .= "INSERT INTO `users` VALUES (1,'".$email."','".$hash."',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2050-03-14 14:15:43',1,NULL,'default','2022-09-18 19:09:29','2022-02-21 11:08:50',NULL,NULL);";
            $sql .= "UNLOCK TABLES;";

            $dbh->exec($sql);
            $dbh = null;

            // Write to .env
            $file = fopen("../../.env","a");
            ftruncate($file, 0);

            $line1 = 'APP_NAME=lure';
            $line2 = 'APP_ENV=local';
            $line3 = 'APP_KEY=base64:0k0NzaSsMhATtkhkZ6adQXTJd1lKPUToNWT0DHCwkPo=';
            $line4 = 'APP_DEBUG=false';
            $line5 = 'APP_LOG_LEVEL=debug';
            $line6 = 'APP_URL='.$app_url;
            $line7 = '';
            $line8 = 'DB_CONNECTION=mysql';
            $line9 = 'DB_HOST='.$host;
            $line10 = 'DB_PORT=3306';
            $line11 = 'DB_DATABASE='.$db;
            $line12 = 'DB_USERNAME='.$user;
            $line13 = 'DB_PASSWORD='.$pass;
            $line14 = '';
            $line15 = 'BROADCAST_DRIVER=log';
            $line16 = 'CACHE_DRIVER=file';
            $line17 = 'SESSION_DRIVER=file';
            $line18 = 'QUEUE_DRIVER=sync';
            $line19 = '';
            $line20 = 'REDIS_HOST=127.0.0.1';
            $line21 = 'REDIS_PASSWORD=null';
            $line22 = 'REDIS_PORT=6379';
            $line23 = '';
            $line24 = 'MAIL_DRIVER=smtp';
            $line25 = 'MAIL_HOST=';
            $line26 = 'MAIL_PORT=465';
            $line27 = 'MAIL_USERNAME=';
            $line28 = 'MAIL_PASSWORD=';
            $line29 = 'MAIL_ENCRYPTION=ssl';
            $line30 = '';
            $line31 = 'PUSHER_APP_ID=';
            $line32 = 'PUSHER_APP_KEY=';
            $line33 = 'PUSHER_APP_SECRET=';

            for($i=1; $i<=33; $i++)
            {
                fwrite($file,${"line" . $i}.PHP_EOL);
            }


            fclose($file);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function checkCredentials() {

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            return false;

        if($_POST['pass1'] !== $_POST['pass2'])
            return false;

        return true;

    }
}
