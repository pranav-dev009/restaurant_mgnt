<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
    require_once ("common_files/configuration.php");
    require_once ("common_files/cms_data.php");
?>
<?php require_once 'header.php';?>
            <!--Banner Images-->
            <section id="banners">
                <div id="slider3" class="carousel slide mb-5" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li class="active" data-target="#slider3" data-slide-to="0"></li>
                        <li data-target="#slider3" data-slide-to="1"></li>
                        <li data-target="#slider3" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img id="bannerimgs" src="/common_images/bgimg1.jpg">
                        </div>
                        <div class="carousel-item">
                            <img id="bannerimgs" src="/common_images/bgimg2.jpg">
                        </div>
                        <div class="carousel-item">
                            <img id="bannerimgs" src="/common_images/bgimg3.jpg">
                        </div>
                    </div>
                    <a href="#slider3" class="carousel-control-prev" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>
                    <a href="#slider3" class="carousel-control-next" data-slide="next"><span class="carousel-control-next-icon"></span></a>
                </div>
            </section>

            <!-- Page Descrption-->
            <div class="container mb-5 pb-5">
                <?php echo $pageDescription; ?>
            </div>
        </div>
<?php require_once 'footer.php';?>
