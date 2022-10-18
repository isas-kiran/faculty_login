<?php include '../faculty_login/include/config.php';
$record_id = $_REQUEST['record_id'];

$sel_great_things="select * from wb_great_things where 1 and status='Active' and id='".$record_id."' order by sequence_id asc ";
$ptr_great_things=mysql_query($sel_great_things);
$data_gt=mysql_fetch_array($ptr_great_things);

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>ISAS Great Things</title>
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:image" content="path/to/image.html">
    <!--Favicon-->
    <link rel="icon" href="img/isas-logo.png">
    <!--Libs css-->
    <link rel="stylesheet" href="css/libs.css">
    <!--Main css-->
    <link rel="stylesheet" href="css/main.css">
    <style>
	@media only screen and (max-width: 480px) {
  	.single-post {
		padding-top:-15px !important;
		}
		.blog-page .single-post {
  			/*padding-top: 0px; */
		}
	}
	
	#sidebar {
		height:0px !important;
	}
	</style>
  </head>
  <body class="blog-page">
    <header id="top-nav" class="top-nav page-header" >
      <div class="container" ><a href="#" class="logo smooth-scroll"><img src="img/isas-logo.png" alt="ISAS" class="logo-white"><img src="img/isas-logo.png" alt="ISAS" class="logo-dark"></a>
        <nav class="top-menu">
          <ul class="sf-menu">
            <!--Menu default-->
            <li><a href="https://isasbeautyschool.com/">Home</a>
              <!--<ul>
                <li><a href="index.html">Home - Default</a></li>
                <li><a href="index-left-nav.html">Home - Left Menu</a></li>
                <li><a href="index-video-backgound.html">Home - Video</a></li>
                <li><a href="index-demo.html">Home - Demo</a></li>
                <li><a href="index-slide-content.html">Home - Slide content</a></li>
                <li><a href="index-project.html">Home - Project</a></li>
                <li><a href="index-project2.html">Home - Project 2</a></li>
                <li><a href="index-canvas.html">Home - Canvas</a></li>
                <li><a href="index-canvas-2.html">Home - Canvas 2</a></li>
                <li><a href="#">Home - Personal</a>
                  <ul>
                    <li><a href="index-freelance.html">Home - Freelancer</a></li>
                    <li><a href="index-personal-photo.html">Home - Photographs</a></li>
                    <li><a href="index-personal-photo-video.html">Home - Photographs video</a></li>
                  </ul>
                </li>
                <li><a href="#">Home - Portfolio</a>
                  <ul>
                    <li><a href="index-portfolio.html">Home - Portfolio default</a></li>
                    <li><a href="index-portfolio-photographs.html">Home - Portfolio photographs</a></li>
                  </ul>
                </li>
              </ul>-->
            </li>
            <!--<li><a href="#">Pages</a>
              <ul>
                <li><a href="about.html">About us</a></li>
                <li><a href="#">Contact</a>
                  <ul>
                    <li><a href="contact.html">Contact Default</a></li>
                    <li><a href="contact-2.html">Contact - 2</a></li>
                    <li><a href="contact-3.html">Contact - 3</a></li>
                    <li><a href="contact-4.html">Contact - 4</a></li>
                    <li><a href="contact-5.html">Contact - 5</a></li>
                  </ul>
                </li>
                <li><a href="#">Services</a>
                  <ul>
                    <li><a href="services.html">Services page</a></li>
                    <li><a href="services-mini-head.html">Services mini head</a></li>
                    <li><a href="services-dark.html">Services page dark</a></li>
                    <li><a href="services-2-col.html">Services 2 columns</a></li>
                    <li><a href="service-single.html">Services single</a></li>
                  </ul>
                </li>
                <li><a href="#">Blog</a>
                  <ul>
                    <li><a href="blog.html">Blog sidebar</a></li>
                    <li><a href="blog-sidebar-right.html">Blog sidebar right</a></li>
                    <li><a href="blog-no-sidebar.html">Blog line</a></li>
                    <li><a href="blog-classic.html">Blog classic</a></li>
                    <li><a href="blog-masonry.html">Blog masonry</a></li>
                    <li><a href="blog-single.html">Single post</a></li>
                    <li><a href="blog-single-gallery.html">Single post gallery</a></li>
                    <li><a href="blog-single-youtube.html">Single post YouTube</a></li>
                    <li><a href="blog-single-vimeo.html">Single post Vimeo</a></li>
                  </ul>
                </li>
                <li><a href="#">Portfolio</a>
                  <ul>
                    <li><a href="portfolio.html">Page default</a></li>
                    <li><a href="portfolio-no-sortable.html">Page no filter</a></li>
                    <li><a href="portfolio-masonry.html">Page masonry</a></li>
                    <li><a href="portfolio-masonry-photos.html">Page masonry photos</a></li>
                    <li><a href="project-single.html">Project single</a></li>
                    <li><a href="project-single-gallery.html">Project gallery</a></li>
                    <li><a href="project-single-youtube.html">Project youtube</a></li>
                    <li><a href="project-single-vimeo.html">Project vimeo</a></li>
                  </ul>
                </li>
                <li><a href="#">Prices</a>
                  <ul>
                    <li><a href="prices.html">Prices 1</a></li>
                    <li><a href="prices-2.html">Prices 2</a></li>
                    <li><a href="prices-2-dark.html">Prices 3 dark</a></li>
                  </ul>
                </li>
                <li><a href="404-page.html">404 page</a></li>
                <li><a href="terms.html">TERMS</a></li>
                <li><a href="faq.html">FAQ page</a></li>
              </ul>
            </li>-->
            <li><a href="https://isasbeautyschool.com/about-us/" class="smooth-scroll">About</a></li>
            <!--<li><a href="#services" class="smooth-scroll">Services</a></li>
            <li><a href="#portfolio" class="smooth-scroll">Our works</a></li>
            <li><a href="#skills" class="smooth-scroll">Skills</a></li>-->
            <li> <a href="https://isasbeautyschool.com/contact-us/" class="smooth-scroll">Contact</a></li>
          </ul>
          <!-- Start toggle menu-->
          <!--<a href="#" class="toggle-mnu"><span></span></a>
          <a href="#" class="toggle-top"><span></span><span></span><span></span><span></span><span></span></a>-->
        </nav>
        <!-- Start mobile menu-->
        <div id="mobile-menu">
          <div class="inner-wrap">
            <nav>
              <ul class="nav_menu">
                <li class="menu-item-has-children current-menu-item"><a href="https://isasbeautyschool.com/">Home</a>
                  <!--<ul class="sub-menu">
                    <li><a href="index.html">Home - Default</a></li>
                    <li><a href="index-left-nav.html">Home - Left Menu</a></li>
                    <li><a href="index-video-backgound.html">Home - Video</a></li>
                    <li><a href="index-demo.html">Home - Demo</a></li>
                    <li><a href="index-slide-content.html">Home - Slide content</a></li>
                    <li><a href="index-project.html">Home - Project</a></li>
                    <li><a href="index-project2.html">Home - Project 2</a></li>
                    <li><a href="index-canvas.html">Home - Canvas</a></li>
                    <li><a href="index-canvas-2.html">Home - Canvas 2</a></li>
                    <li><a href="index-freelance.html">Home - Freelancer</a></li>
                    <li><a href="index-personal-photo.html">Home - Photographs</a></li>
                    <li><a href="index-personal-photo-video.html">Home - Photographs video</a></li>
                    <li><a href="index-portfolio.html">Home - Portfolio default</a></li>
                    <li><a href="index-portfolio-photographs.html">Home - Portfolio photographs</a></li>
                  </ul>-->
                </li>
                <!--<li class="menu-item-has-children"><a href="#">Pages</a>
                  <ul class="sub-menu">
                    <li><a href="contact.html">Contact Default</a></li>
                    <li><a href="contact-2.html">Contact - 2</a></li>
                    <li><a href="contact-3.html">Contact - 3</a></li>
                    <li><a href="contact-4.html">Contact - 4</a></li>
                    <li><a href="contact-5.html">Contact - 5</a></li>
                    <li><a href="services.html">Services page</a></li>
                    <li><a href="services-mini-head.html">Services mini head</a></li>
                    <li><a href="services-dark.html">Services page dark</a></li>
                    <li><a href="services-2-col.html">Services 2 columns</a></li>
                    <li><a href="service-single.html">Services single</a></li>
                    <li><a href="services.html">Services page</a></li>
                    <li><a href="services-mini-head.html">Services mini head</a></li>
                    <li><a href="services-dark.html">Services page dark</a></li>
                    <li><a href="services-2-col.html">Services 2 columns</a></li>
                    <li><a href="service-single.html">Services single</a></li>
                    <li><a href="portfolio.html">Page default</a></li>
                    <li><a href="portfolio-no-sortable.html">Page no filter</a></li>
                    <li><a href="portfolio-masonry.html">Page masonry</a></li>
                    <li><a href="portfolio-masonry-photos.html">Page masonry photos</a></li>
                    <li><a href="project-single.html">Project single</a></li>
                    <li><a href="project-single-gallery.html">Project gallery</a></li>
                    <li><a href="project-single-youtube.html">Project youtube</a></li>
                    <li><a href="project-single-vimeo.html">Project vimeo</a></li>
                    <li><a href="blog.html">Blog sidebar</a></li>
                    <li><a href="blog-sidebar-right.html">Blog sidebar right</a></li>
                    <li><a href="blog-no-sidebar.html">Blog line</a></li>
                    <li><a href="blog-classic.html">Blog classic</a></li>
                    <li><a href="blog-masonry.html">Blog masonry</a></li>
                    <li><a href="blog-single.html">Single post</a></li>
                    <li><a href="blog-single-gallery.html">Single post gallery</a></li>
                    <li><a href="blog-single-youtube.html">Single post YouTube</a></li>
                    <li><a href="blog-single-vimeo.html">Single post Vimeo</a></li>
                    <li><a href="prices.html">Prices 1</a></li>
                    <li><a href="prices-2.html">Prices 2</a></li>
                    <li><a href="prices-2-dark.html">Prices 3 dark</a></li>
                    <li><a href="404-page.html">404 page</a></li>
                    <li><a href="terms.html">TERMS</a></li>
                    <li><a href="faq.html">FAQ page</a></li>
                  </ul>
                </li>-->
                <li><a href="https://isasbeautyschool.com/about-us/" class="smooth-scroll">About</a></li>
                <!--<li><a href="#services" class="smooth-scroll">Services</a></li>
                <li><a href="#portfolio" class="smooth-scroll">Our works</a></li>
                <li><a href="#skills" class="smooth-scroll">Skills</a></li>-->
                <li> <a href="https://isasbeautyschool.com/contact-us/" class="smooth-scroll">Contact</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- End mobile menu-->
      </div>
    </header>
    <!-- Start full screen top nav-->
    <div class="container single-blog right-sidebar">
      <div class="row">
        <!--<div id="sidebar" class="col-md-3 col-sm-3 col-md-push-9 col-sm-push-9" style="height:0px !important">
        </div>-->
        <div class="col-md-12 col-sm-8 single-post" >
        	<div style="text-align:left; color:#000"><i class="fa fa-arrow-alt-left"></i><a href="https://www.isasbeautyschool.org/greatThings/isas_great_things.php" ><strong>Back</strong></a></div>
          <article class="post type-post format-image">
            <div class="post-thumb">
            
            	<div class="slider-wrap gallery-slide">
                    <div class="full-slider">
                        <div class="slide"><img src="../faculty_login/images/website/<?php echo $data_gt['image1']; ?>" alt="<?php echo $data_gt['event_name']; ?>" class="img-responsive" style="width:100% !important"></div>
                        <div class="slide"><img src="../faculty_login/images/website/<?php echo $data_gt['image2']; ?>" alt="<?php echo $data_gt['event_name']; ?>" class="img-responsive" style="width:100% !important"></div>
                        <div class="slide"><img src="../faculty_login/images/website/<?php echo $data_gt['image3']; ?>" alt="<?php echo $data_gt['event_name']; ?>" class="img-responsive" style="width:100% !important"></div>
                    </div>
                    <!--Contol slider-->
                    <div id="dots-control-full-slider" class="dots-control-carousel"></div>
                    <!-- Strat Control carousel-->
                    <div id="control-full-slider" class="prev-next-block-rotate opacity-control">
                        <div class="wrap-prev">
                            <div class="prev"><i aria-hidden="true" class="fa fa-angle-left"></i></div>
                        </div>
                        <div class="wrap-next">
                            <div class="next"><i aria-hidden="true" class="fa fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php 
			$orgDate=$data_gt['added_date'];
			$newDate = date("d-M-Y", strtotime($orgDate));  
			?>
            <!--Start post data-->
            <div class="post-data">
              <p class="data"><a href="#"><?php echo $newDate; ?></a></p>
            </div>
            <!--End post data-->
            <div class="content">
              <h2><?php echo $data_gt['event_name']; ?></h2>
              <p><?php echo $data_gt['description']; ?></p>
            </div>
            <hr>
            <div class="share-post">
              <h4>Did You Like This Post? Share it :</h4>
              <ul class="share-post-links">
                <li><a href="<?php echo $data_gt['fb_link']; ?>" title="Share on Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?php echo $data_gt['google_link']; ?>" title="Like this"><i class="fa fa-google"></i></a></li>
                <!--<li><a href="#" title="Share on VK"><i class="fa fa-vk"></i></a></li>
                <li><a href="#" title="Share on Dribbble"><i class="fa fa-dribbble"></i></a></li>
                <li><a href="#" title="Share on Pinterest"><i class="fa fa-pinterest"></i></a></li>-->
              </ul>
            </div>
            <hr>
            <!--<div class="row">
              <div class="col-md-12">
                <div class="author-bio">
                  <div class="col-md-2 profile-img"><span class="dark-hex"><img alt="avatar" src="img/ava3.jpg" class="avatar avatar-90"></span></div>
                  <div class="col-md-10 author-info">
                    <h3 class="author-title">Written Brainiak</h3>
                    <p class="author-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                  </div>
                </div>
              </div>
            </div>-->
          </article>
          <!--<div id="comments" class="comments-area comments">
            <div class="small-heading text-left">
              <h2>6 comments </h2>
            </div>
            <ul class="comment-list">
              <li class="row">
                <div class="col-md-2 col-sm-2"><img alt="alt" src="img/ava2.jpg" class="avatar avatar-80 photo"></div>
                <div class="col-md-10 col-sm-10">
                  <p class="user">admin <span><a rel="nofollow" href="#" aria-label="Reply to admin" class="comment-reply-link">Reply</a></span></p>
                  <p class="info">October 13, 2015 at 2:09 pm </p>
                  <p>Hello!</p>
                </div>
              </li>
              <ul class="children">
                <li class="row">
                  <div class="col-md-2 col-sm-2"><img alt="alt" src="img/ava2.jpg" class="avatar avatar-80 photo"></div>
                  <div class="col-md-10 col-sm-10">
                    <p class="user">admin <span><a rel="nofollow" href="#" aria-label="Reply to admin" class="comment-reply-link">Reply</a></span></p>
                    <p class="info">October 13, 2015 at 2:09 pm </p>
                    <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius!</p>
                  </div>
                </li>
                <ul class="children">
                  <li class="row">
                    <div class="col-md-2 col-sm-2"><img alt="alt" src="img/ava2.jpg" class="avatar avatar-80 photo"></div>
                    <div class="col-md-10 col-sm-10">
                      <p class="user">admin <span><a rel="nofollow" href="#" aria-label="Reply to admin" class="comment-reply-link">Reply</a></span></p>
                      <p class="info">October 13, 2015 at 2:09 pm </p>
                      <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.!</p>
                    </div>
                  </li>
                  <li class="row">
                    <div class="col-md-2 col-sm-2"><img alt="alt" src="img/ava2.jpg" class="avatar avatar-80 photo"></div>
                    <div class="col-md-10 col-sm-10">
                      <p class="user">admin <span><a rel="nofollow" href="#" aria-label="Reply to admin" class="comment-reply-link">Reply</a></span></p>
                      <p class="info">October 13, 2015 at 2:09 pm </p>
                      <p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.!</p>
                    </div>
                  </li>
                </ul>
                <li class="row">
                  <div class="col-md-2 col-sm-2"><img alt="alt" src="img/ava2.jpg" class="avatar avatar-80 photo"></div>
                  <div class="col-md-10 col-sm-10">
                    <p class="user">admin <span><a rel="nofollow" href="#" aria-label="Reply to admin" class="comment-reply-link">Reply</a></span></p>
                    <p class="info">October 13, 2015 at 2:09 pm </p>
                    <p>Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius!</p>
                  </div>
                </li>
              </ul>
              <li class="row">
                <div class="col-md-2 col-sm-2"><img alt="alt" src="img/ava2.jpg" class="avatar avatar-80 photo"></div>
                <div class="col-md-10 col-sm-10">
                  <p class="user">admin <span><a rel="nofollow" href="#" aria-label="Reply to admin" class="comment-reply-link">Reply</a></span></p>
                  <p class="info">October 13, 2015 at 2:09 pm </p>
                  <p>Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.!</p>
                </div>
              </li>
            </ul>
            <div class="comment-respond">
              <div class="row">
                <div class="col-md-12">
                  <div class="small-heading text-left">
                    <h2>Leave a Reply </h2>
                    <p>Your email address will not be published. Required fields are marked *</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <form action="#" class="contact-form-white">
                  <div class="col-md-12">
                    <textarea name="message" placeholder="Message *" cols="3" rows="5"></textarea>
                  </div>
                  <div class="col-md-4">
                    <input type="text" placeholder="Name *">
                  </div>
                  <div class="col-md-4">
                    <input type="text" placeholder="Email *">
                  </div>
                  <div class="col-md-4">
                    <input type="text" placeholder="Web site">
                  </div>
                  <div class="col-md-12">
                    <input type="submit" value="Post comment" class="btn">
                  </div>
                </form>
              </div>
            </div>
          </div>-->
          <!-- end comment-->
          
        </div>
        <!-- end single post-->
      </div>
      <!-- end row-->
    </div>
    <!-- end container-->
    <!-- Old browsers support--><!--[if lt IE 9]>
    <script src="libs/html5shiv/es5-shim.min.js"></script>
    <script src="libs/html5shiv/html5shiv.min.js"></script>
    <script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
    <script src="libs/respond/respond.min.js"></script>
    <![endif]-->
    <!--<footer>
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="logo"><img src="img/logo.png" alt="logo" class="logo-white"></div>
            <p>We are a creative agency with a passion for design & developing beautiful creations.</p>
            <ul class="social-links">
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="#"><i class="fa fa-skype"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <div class="links">
              <h5>ADDITIONAL LINKS</h5>
              <ul class="list">
                <li><a href="index-freelance.html">For Freelancer</a></li>
                <li><a href="index-portfolio-photographs.html">For Photographs</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="404-page.html">404 page</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
            <div class="links">
              <h5>Pages</h5>
              <ul class="list">
                <li><a href="about.html">About page</a></li>
                <li><a href="blog-masonry.html">Blog page</a></li>
                <li><a href="prices-2.html">Price page</a></li>
                <li><a href="portfolio.html">Portfolio page</a></li>
                <li><a href="project-single-gallery.html">Portfolio single</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
            <div class="links">
              <h5>Adress</h5>
              <p>1234 SOME AVENUE, <br>NEW YORK, NY 56789<br><a href="http://fidex.com.ua/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="1950575f565940564c4e5c5b4a504d5c375a5654">[email&#160;protected]</a><br> (123) 456-7890<br> (123) 456-7890</p>
            </div>
          </div>
        </div>
      </div>
      <div class="down-footer">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p>© 2017 All Rights Reserved.  -   Created by Brainiakthemes</p>
              <ul class="footer-menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="#about" class="smooth-scroll">About</a></li>
                <li><a href="#services" class="smooth-scroll">Services</a></li>
                <li><a href="#portfolio" class="smooth-scroll">Our works</a></li>
                <li><a href="#skills" class="smooth-scroll">Skills</a></li>
                <li> <a href="#contact" class="smooth-scroll">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>-->
    <!--button to top-->
    <div class="top icon-down toTopFromBottom"><a href="#top" class="smooth-scroll"><i class="pe-7s-angle-up"></i></a></div>
    <!--end button to top-->
    <!--Google map-->
    <script data-cfasync="false" src="email-decode.min.js"></script>
    <!--Libs-->
    <script src="js/libs.js"></script>
    <!--Use scripts-->
    <script src="js/common.js"></script>
  </body>

<!-- Mirrored from fidex.com.ua/monster/kanter/demos/blog-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 27 Oct 2021 06:31:12 GMT -->
</html>