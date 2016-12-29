<?php
error_reporting (E_ALL ^ E_NOTICE); /* Turn off notice errors */
require 'muximux.php';
if (is_session_started()) session_destroy();
session_start();
defined("CONFIG") ? null : define('CONFIG', 'settings.ini.php');
    defined("CONFIGEXAMPLE") ? null : define('CONFIGEXAMPLE', 'settings.ini.php-example');
    defined("SECRET") ? null : define('SECRET', 'secret.txt');
    require dirname(__FILE__) . '/vendor/autoload.php';
    $config = new Config_Lite(CONFIG);
    if ($config->get('general', 'authentication', 'false') == "true") {
        define('DS',  TRUE); // used to protect includes
        define('USERNAME', $_SESSION['username']);
        define('SELF',  $_SERVER['PHP_SELF'] );
        if (!USERNAME or isset($_GET['logout']))
                include('login.php');
    }
?>
<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Muximux - Application Management Console">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" class="droidtheme" content="#DFDFDF" />
    <meta name="msapplication-navbutton-color" class="mstheme" content="#DFDFDF" />
    <meta name="apple-mobile-web-app-status-bar-style" class="iostheme" content="#DFDFDF" />
    <link rel="shortcut icon" href="favicon.ico" type="image/ico"/>
    <link rel="stylesheet" href="css/loader.css"/>
    <link rel="stylesheet" href="combineify.php?type=css&files=css/cssreset.min.css,css/jquery-ui.min.css,css/bootstrap.min.css,css/bootstrap-iconpicker.min.css,css/font-awesome.min.css,css/font-muximux.css,css/font-pt_sans.css,css/style.css,css/spectrum.min.css,css/theme/<?php echo getTheme(); ?>.css">
    
	<title><?php echo getTitle(); ?></title>
	
</head>

<body>
<div class="loader" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" data-show="true" aria-labelledby="mySmallModalLabel" aria-hidden="false">
	<div class="cssload-loader">
		<div class="cssload-flipper">
			<div class="cssload-front"></div>
			<div class="cssload-back"></div>
		</div>
	</div>
    <div class="loader-header">
        <h4>Muximux is loading...</h4>
    </div>
    <div class="loader-body">
        <div class="loader">
            <div class="bar" style="width: 100%;"></div>
        </div>
    </div>
</div>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
    <div class="cd-tabs">
        <?php echo menuItems();?>

        <ul class="cd-tabs-content">
            <div class="constrain">
                <?php echo frameContent(); ?>

            </div>
        </ul>
    </div>

    <!-- Modal -->
    <div id="settingsModal" class="modal fade keyModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-title">
						<div class='logo smallLogo' id='settingsLogo'>
                            <?php 
							echo file_get_contents("images/muximux-white.svg")
							?>
						</div>
						<h1>Settings</h1>
					</div>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="btn-group" role="group" aria-label="Buttons" id="topButtons">
                            <a class="btn btn-primary" id="showInstructions"><span class="fa fa-book"></span> Show Guide</a>
                            <a class="btn btn-primary" id="showChangelog"><span class="fa fa-github"></span> Show Updates</a>
                        </div>
                    </div>

                    <div id="instructionsContainer" class="alert alert-info">
                        <h3>Instructions</h3>
                        <p>The order that you put these blocks in determine in what order they will be listed in the
                            menu.<br>
                            Enable or disable each block and edit the URL to point to your desired location.<br/><br/></p>
                        <h3>Bookmarking apps contained within Muximux</h3>
                        <p>If you want to go directly to a specific app within Muximux you can use hashes (<code>#</code>) in the URL.
                            For instance, if you have an app called "My app" you could use:<br/>
                            <code><script>document.write(location.href.replace(location.hash,""))</script>#My app</code><br/><br/>
                            This is great for when you want to bookmark specific services contained within Muximux.<br/>
                            Please note that the hashname should be the exact same as the <code>Name</code> you have configured in the settings below.<br/>
                            If you need to, you can replace spaces with underscores (i.e <code>#My_app</code>).
                            <br/><br/></p>
                        <h3>Running Muximux from SSL-enabled / HTTPS server</h3>
                        <p>Please note that if Muximux is served via HTTPS, any services that are NOT served via HTTPS might
                            be blocked by your web-browser.<br><br>
                            Loading of unsecured content in the context of an SSL encrypted website where you see a green
                            lock would be misleading, therefore the browser blocks it.<br>
                            One work-around is to serve Muximux via an unsecured website, or to make sure all the
                            services/urls you link to use https://</p>

                        <p>Alternatively, if you use Chrome or Opera (or any Chromium-based browser), you can install
                            the plugin "Ignore X-Frame headers", which<br>
                            drops X-Frame-Options and Content-Security-Policy HTTP response headers, allowing ALL pages to
                            be
                            iframed (like we're doing in Muximux).</p>

                        <p>See:
                            <a href="https://chrome.google.com/webstore/detail/ignore-x-frame-headers/gleekbfjekiniecknbkamfmkohkpodhe"
                               target="_blank">https://chrome.google.com/webstore/detail/ignore-x-frame-headers/gleekbfjekiniecknbkamfmkohkpodhe</a>
                        </p>

                        <p>See <a href="https://github.com/mescon/Muximux/" target="_blank">https://github.com/mescon/Muximux/</a>
                            for more information.</p>

                    </div>
                    <div id="changelogContainer" class="alert alert-warning">
                        <h3>Updates</h3>
                        <div id="changelog"></div>
                    </div>
                    <div id="backupiniContainer" class="alert alert-warning">
                        <h3>backup.ini.php Contents</h3>
                        <div class="text-center">
                            <a class="btn btn-danger" id="removeBackup"><span class="fa fa-trash"></span> Remove backup.ini.php</a>
                        </div>
                        <hr/>
                        <div id="backupContents"><pre><?php if (file_exists('backup.ini.php')) echo htmlentities(file_get_contents('backup.ini.php')); ?></pre></div>
                    </div>
                    <?php echo parse_ini(); ?>
                </div>
            </div>
            <div class="modal-footer">
				<div class='btn-group' role='group' aria-label='Buttons'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type='button' class="btn btn-primary" id='settingsSubmit' value='Submit Changes'>Save and Reload</button>
				</div>
            </div>
        </div>
    </div>
    <div id="upgradeModal" class="modal fade" role="dialog">
        <div class="modal-dialog upgradeDialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-title"><h1>Update Notification</h1></div>
                </div>
                <div class="modal-body upgradeBody">
                    <div class="alert alert-info">
                        There has been an update. We removed <code>config.ini.php</code> and copied it into <code>backup.ini.php</code>
                        This is the last time we will have to do this kind of change.
                        This is due to the fact that we made major changes to the config.ini.php
                        and it is now called settings.ini.php. Do not copy your old config into
                        the new settings.ini.php. It needs to be written by the settings menu that
                        can be now be found in the dropdown in the top right. Thank you for your understanding.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type='button' class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <div id="logModal" class="modal fade keyModal" role="dialog">
        <div class="modal-dialog logDialog">
            <!-- Modal content-->
            <div class="modal-content logContent" role="document">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-title"><h1>Muximux Log</h1></div>
                </div>
                <div class="modal-body logBody">
                    <div id="logContainer">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
				<div class='btn-group' role='group' aria-label='Buttons'>
                    <button type='button' class="btn btn-default" id="logRefresh">Refresh</button>
					<button type='button' class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
            </div>
        </div>
    </div>
	<div id="splashModal" class="modal keyModal" role="dialog" data-keyboard="true">
        <div class="modal-dialog splashDialog">
            <!-- Modal content-->
                <div class="modal-header splashHeader">
						<div class="logo smallLogo">
							<div class="modal-title"><?php echo file_get_contents("images/muximux-white.svg") ?></div>
						</div>
						<div id="splashNav">
							<button type="button" id="splashSettings" class="splashNavBtn btn btn-primary btn-lg" data-dismiss="modal"><span class="fa fa-cog icon-4x"></span></button>
							<button type="button" id="splashLog" class="splashNavBtn btn btn-primary btn-lg" data-dismiss="modal"><span class="fa fa-file-text-o icon-4x"></span></button>
							<button type="button" id="splashLogout" class="splashNavBtn btn btn-primary btn-lg"><span class="fa fa-sign-out icon-4x"></span></button>	
						</div>
						
					</div>
				
                <div id="splashContainer" class="alert">
				<?php echo splashScreen() ?>
		        
                </div>
            
        </div>
	<div id="splashBg"></div>
    </div>
	<div id="updateContainer"></div>
    <?php echo metaTags(); ?>
    <script type="text/javascript" src="combineify.php?type=javascript&files=js/jquery-2.2.4.min.js,js/jquery-ui.min.js,js/jquery.form.min.js,js/bootstrap.min.js,js/iconset-muximux.js,js/bootstrap-iconpicker.min.js,js/main.js,js/functions.js,js/spectrum.min.js,js/modernizr-custom-3.3.1.min.js,js/jquery.ui.touch-punch.min.js"></script>


<?php

if ($upgrade) echo "<script type=\"text/javascript\">$('#upgradeModal').modal();</script>"; ?>

    <meta id='secret'>

    </body>
</html>
