<?php include '../inc_classes.php';?>
<!DOCTYPE html><html lang="en">
    <head>
        <meta charset="utf-8">    
        <meta content='width=device-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0' name='viewport'>  
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;" />
        <meta name="viewport" content="width=device-width">
        <title>Feedback Form</title>        <!-- CSS styles -->
        <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="css/jquery-ui.min.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/datepicker.min.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/styles.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/temporary_student.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/source-sans-pro.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/full-medium.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/full-medium1.css" media="screen" rel="stylesheet" type="text/css">        <!-- Js Scripts -->
        <script type="text/javascript">
            var BASE_URL = "https://isasbeautischool.com/";
            var isRunningPreview = 0;
            var isRunningTemplatePreview = 0;
            var surveyRefCode = 'f39jCQ';
            var trackRefCode = '';
            var surveyAssignBranchCount = parseInt('1');
            var queryStringParams = [];
            var screenWithCustomSettings = {};
            var screenIdsWithCustomSettings = [];
            var cmpSubPlanId = "1";
            var formLanguageCount = 1;
            var checkOtpValidation = "0";
            var isSmsSurvey = "";
            var setMobileCountryCode = "";
            var setMobileNumber = "";
            var setCustomerTrackingEmail = "";
            var strRedirectUrlFromWebSurvey = "";
            var timeRedirectWebSurveyIn = "10";
        </script>
    </head>
    <body class="larg light-theme double-full  full-web-view">
                <div id="LoadingSurvey">
            <div id="LoadingSurveyContent">
                <div><i class="fa fa-spinner fa-spin fa-3x zonka-default-color"></i></div>  
                <div class="mtop5">Starting up the Survey..</div>
            </div>
        </div>
        <div id="SavingAndRedirectingSurvey" style="display:none;">
            <div id="SavingAndRedirectingSurveyContent">
                <div><i class="fa fa-spinner fa-spin fa-3x zonka-default-color"></i></div>  
                <div class="mtop5"><strong>Please Wait!</strong> You will be redirected in 10 seconds.</div>
            </div>
        </div>
                        <div class="alert alert-info survey-redirect-message" style="display:none;">
            <a href="#CloseTopPreviewBar" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Please Wait!</strong> You will be redirected in 10 seconds.        </div>
        <!--Intro screen--> 
    <section class="intro-screen" style="background-image: url('test.jpg');">
        <header>
      
                </header>
        <article class="src-1">
                            <figure class="logo intro-screen-logo">
                    <img src="http://www.innocentsalon.com/images/logo.png">
                </figure>
                      
            <h2 id="IntroScreenUpperText" class="medium" style="color:#c5983b;font-family:Source Sans Pro;"><b>Please share your feedback about our Salon Service</b></h2>
            <div class="col-sm-12 intro-page-get-started-cont">
                <div class="intro_inner_circle">
                <a id="IntroScreenStartBtn" class="get-started-action medium get_started_style_rectangle" href="javascript:void(0);" style="font-family:Source Sans Pro;color:#ffffff;background-color:rgb(134, 193, 50);" >Tap to begin</a> 
                </div>
                </div>
            <h2 id="IntroScreenBottomText" class="medium" style="color:#ffffff;font-family:Open Sans;"></h2>
        </article>
            </section>
<script type="text/javascript">
var surveyStyleInformation = {"StyleId":"12253","BackgroundColor":"#ffffff","ApplyFeedbackFormBackgroundImage":"0","BackgroundImageUrl":"","FontFamily":"Source Sans Pro","FontWeight":null,"FontType":"Medium","ApplyCustomFontSize":"0","LabelCustomFontSize":"Small","OptionCustomFontSize":"Small","FontColorLabel":"#2a13bb","FontColorValue":"#2a13bb","FillFeedbackFormTopStripColor":"0","PaginationStyle":"circular","ShowNumberInPaging":"0","TopStripColor":"#1d9d5b","ApplyTopStripAlpha":"0","TopStripAlphaValue":"0.3","ButtonColor":"#2a13bb","ButtonSelectedColor":"#c7c5c5","ButtonFontColor":"#ffffff","ButtonSelectedFontColor":"#ffffff","DoneButtonColor":"#2a13bb","DoneButtonTextColor":"#ffffff","PreviousNextArrowColor":"#2a13bb","PreviousNextTextColor":"#2a13bb","PreviousNextPosition":"top","ShowFieldInTheCenterOfScreen":"0","IsIconIntialStateBright":"0","SkipNavText":"Skip","ThemeName":"Light","FeedbackFormLogo":"","GalleryFeedbackFormLogo":"0\/1504870040_2284.png","GalleryFeedbackFormBackground":null,"ButtonText":{"SubmitButtonText":{"en_US":"Submit"},"DashboardButText":{"en_US":"Dashboard"},"GetStartedButText":{"en_US":"Get Started"},"ClearButText":{"en_US":"Back"},"NextArrowText":{"en_US":"Next"},"PreviousArrowText":{"en_US":"Previous"},"SkipNavText":{"en_US":"Skip"}},"InfoText":{"FeedbackFormTitle":{"en_US":"Website Visitor Feedback"},"Description":{"en_US":""}},"ButtonStyle":{"ButtonColor":"#2a13bb","ButtonSelectedColor":"#c7c5c5","ButtonFontColor":"#ffffff","ButtonSelectedFontColor":"#ffffff","DoneButtonColor":"#2a13bb","DoneButtonTextColor":"#ffffff"}};
var introScreenData = {"PageId":"36118","FontColorBottomText":"#ffffff","FontFamilyBottomText":"Open Sans","FontSizeBottomText":"Medium","FontColorUpperText":"#2a13bb","FontSizeUpperText":"Medium","FontFamilyUpperText":"Source Sans Pro","FontColorIDontWantToGiveFeedbackText":"#ffffff","FontSizeIDontWantToGiveFeedbackText":"Medium","FontFamilyIDontWantToGiveFeedbackText":"Open Sans","FontColorIWantToGiveFeedbackText":"#ffffff","FontSizeIWantToGiveFeedbackText":"Medium","FontFamilyIIWantToGiveFeedbackText":"Source Sans Pro","ButtonStyle":"rectangle","ButtonBackgroundColor":"#2a13bb","PageBgColor":"#ffffff","ApplyPageBackgroundImage":"1","PageName":"","PageLogo":"","ShowIDontWantToGiveFeedbackAction":"0","ShowFlagWithLanguage":"0","GalleryPageLogo":"0\/1505124621_8595.png","GalleryPageName":"6742\/1531724569_1740.png","IntroTextIWantToGiveFeedbackText":{"en_US":"Tap to begin"},"IntroTextIDontWantToGiveFeedbackText":{"en_US":"I Don't Want to Give Feedback"},"IntroUpperText":{"en_US":"Please share your feedback about our website"},"IntroBottomText":{"en_US":""}};
</script>
<!--Form Screens-->

<section class="wrapper-outer" style="background:#ffffff">
<!-- Top Strip-->
<!-- Footer Start here -->
<!-- Header Start here -->
  <header id="FormHeaderTopStrip" class="survey-form-header">
    <div class="" style=";"></div>
        <div class="top-next-prev-action prev-screen">
        <a style="font-family:Source Sans Pro;color:#2a13bb;" href="javascript:void(0);"><font class="fa" style="color:rgb(134, 193, 50);"></font><span>Previous</span></a>
    </div>
    <div class="top-next-prev-action next-screen">
        <a style="font-family:Source Sans Pro;color:#2a13bb;" href="javascript:void(0);"><font class="fa" style="color:rgb(134, 193, 50);"></font></br><span>Next</span></a>
    </div>
    <div class="done-button"><a style="font-family:Source Sans Pro;background:#2a13bb;color:#ffffff;" href="javascript:void(0);">Submit</a></div>
    <figure class="logo">
            <img src="https://zonka.co/img_gallery/0/1504870040_2284.png">
        </figure>
  </header>

<!-- Header End here --><!-- Top Strip ends-->
<div class="wrapper-working-area medium-survey-element">
<!-- Screens starts here -->
    <!-- Screens start here -->
    <div class="wrapper feedbackscreen-1 " screen-item-count="4" id="SurveyScreen_1">
    <div id="SurveyField_130901" class="inner-center-panel survey-field-container single_column variable_cls_ set-11"  f-field-id="130901" f-required="1" field-type="NumberRating" f-name="npsquestion" f-input-type="" options-has-image="0" is-rating="0" field-category="F" total-option-count="11" show-num-in-sel-option="1" min-option-sel-count="4" has-skip-logic="0" is-gradient="0" is-hide-field="" allow-hide-when-filled="" hide-field-setting="0" validate-custom-error="Invalid Input" validate-term="" question-serial-tag="{{Q1}}">
            <div class="row">
                <div class="inner-center-panel">
                    <div class="inner-div-center">
                    <h2 style="font-size:25px;font-family:Source Sans Pro; color:rgb(134, 193, 50);" class="field-main-label">How was your overall visit in terms of value of money? *</h2>
                    <div class="row">
                        <table class="table no-border table-cell-nps ">
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-show-option-symbol top">Very Likely</span></td>
                            </tr>
                            <tr>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360088" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(40, 140, 40);color:#ffffff;" class="nps-20" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','5','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">5</label>                           
                                    <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-hide-symbol">Very Likely</span>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360089" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(134, 193, 50);color:#ffffff;" class="nps-19" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','4','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">4</label>       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360090" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(84, 217, 140);color:#ffffff;" class="nps-18" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','3','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">3</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360091" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(239, 115, 115);color:#ffffff;" class="nps-17" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','2','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">2</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360092" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(230, 72, 72);color:#ffffff;" class="nps-16" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','1','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">1</label>                       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360093" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(246, 9, 9);color:#ffffff;" class="nps-15" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','0','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">0</label>
                                    <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-hide-symbol">Very Unlikely</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-show-option-symbol bottom">Very Unlikely</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="SurveyField_130902" class="inner-center-panel survey-field-container single_column variable_cls_ set-11"  f-field-id="130902" f-required="1" field-type="NumberRating" f-name="npsquestion" f-input-type="" options-has-image="0" is-rating="0" field-category="F" total-option-count="11" show-num-in-sel-option="1" min-option-sel-count="4" has-skip-logic="0" is-gradient="0" is-hide-field="" allow-hide-when-filled="" hide-field-setting="0" validate-custom-error="Invalid Input" validate-term="" question-serial-tag="{{Q1}}">
            <div class="row">
                <div class="inner-center-panel">
                    <div class="inner-div-center">
                    <h2 style="font-size:25px;font-family:Source Sans Pro; color:rgb(134, 193, 50);" class="field-main-label">How was your overall visit in terms of value of money? *</h2>
                    <div class="row">
                        <table class="table no-border table-cell-nps ">
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-show-option-symbol top">Very Likely</span></td>
                            </tr>
                            <tr>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360094" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(40, 140, 40);color:#ffffff;" class="nps-14" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','5','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">5</label>                           
                                        <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-hide-symbol">Very Likely</span>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360095" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(134, 193, 50);color:#ffffff;" class="nps-13" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','4','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">4</label>       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360096" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(84, 217, 140);color:#ffffff;" class="nps-12" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','3','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">3</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360097" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(239, 115, 115);color:#ffffff;" class="nps-11" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','2','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">2</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360098" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(230, 72, 72);color:#ffffff;" class="nps-10" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','1','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">1</label>                       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360099" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(246, 9, 9);color:#ffffff;" class="nps-9" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','0','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">0</label>
                                    <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-hide-symbol">Very Unlikely</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-show-option-symbol bottom">Very Unlikely</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="inner-center-panel">
                    <div class="inner-div-center">
                    <h2 style="font-size:25px;font-family:Source Sans Pro; color:rgb(134, 193, 50);" class="field-main-label">How was your overall visit in terms of value of money? *</h2>
                    <div class="row">
                        <table class="table no-border table-cell-nps ">
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-show-option-symbol top">Very Likely</span></td>
                            </tr>
                            <tr>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360100" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(40, 140, 40);color:#ffffff;" class="nps-8" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','5','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">5</label>                           
                                        <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-hide-symbol">Very Likely</span>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360101" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(134, 193, 50);color:#ffffff;" class="nps-7" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','4','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">4</label>       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360102" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(84, 217, 140);color:#ffffff;" class="nps-6" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','3','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">3</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360103" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(239, 115, 115);color:#ffffff;" class="nps-5" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','2','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">2</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360104" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(230, 72, 72);color:#ffffff;" class="nps-4" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','1','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">1</label>                       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360105" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(246, 9, 9);color:#ffffff;" class="nps-3" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','0','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">0</label>
                                    <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-hide-symbol">Very Unlikely</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-show-option-symbol bottom">Very Unlikely</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="inner-center-panel">
                    <div class="inner-div-center">
                    <h2 style="font-size:25px;font-family:Source Sans Pro; color:rgb(134, 193, 50);" class="field-main-label">How was your overall visit in terms of value of money? *</h2>
                    <div class="row">
                        <table class="table no-border table-cell-nps ">
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-show-option-symbol top">Very Likely</span></td>
                            </tr>
                            <tr>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360106" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(40, 140, 40);color:#ffffff;" class="nps-2" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','5','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">5</label>                           
                                        <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-first-help-text mobile-hide-symbol">Very Likely</span>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360107" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(134, 193, 50);color:#ffffff;" class="nps-1" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','4','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">4</label>       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360108" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(84, 217, 140);color:#ffffff;" class="nps-0" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','3','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">3</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360109" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(239, 115, 115);color:#ffffff;" class="nps-21" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','2','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">2</label>
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360110" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(230, 72, 72);color:#ffffff;" class="nps-22" onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','1','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">1</label>                       
                                </td>
                                <td action-taken="" skip-to-screen="" hide-screen="" tag-choice-id="360111" class="nps-option">
                                    <label style="font-family:Source Sans Pro;background-color:rgb(246, 9, 9);color:#ffffff;" class="nps-23 " onClick="save_values('<?php echo $data_name['customer_id']; ?>','<?php echo $data_name['customer_service_id']; ?>','0','0','3','<?php echo "3_".$data_name['customer_service_id']."_1"; ?>','0','<?php echo "How was your overall visit in terms of value of money"; ?>','<?php echo $data_brch['cm_id']; ?>','<?php echo $data_brch['staff_id']; ?>');">0</label>
                                    <span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-hide-symbol">Very Unlikely</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span style="font-family:Source Sans Pro;color:rgb(134, 193, 50);" class="nps-help-text nps-last-help-text mobile-show-option-symbol bottom">Very Unlikely</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


        </div>  
    </div>
</div>
    <script type="text/javascript">
    var ScreenCountNum = 4;
    var surveyScreensData = [{"ScreenSequenceOrder":"1","ColumnLayout":"single","Fields":[{"FieldId":"130903","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Overall, how well does our website meet your needs? *"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"mcqquestion","SequenceOrder":"1","FieldType":"mcq_button","IsRating":"1","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Extremely well"},"FieldOptionId":"360099-10.00","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Very well"},"FieldOptionId":"360100-7.50","ChoiceWeight":"7.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Somewhat well"},"FieldOptionId":"360101-5.00","ChoiceWeight":"5.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not so well"},"FieldOptionId":"360102-2.50","ChoiceWeight":"2.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not at all well"},"FieldOptionId":"360103-0.00","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"1","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130908","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Welcome "},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"heading","SequenceOrder":"2","FieldType":"heading","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"2","ColumnLayout":"single","Fields":[{"FieldId":"130904","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"How easy was it to find what you were looking for on our website?"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"mcqquestion","SequenceOrder":"1","FieldType":"mcq_button","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Extremely easy"},"FieldOptionId":"360104","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Very easy"},"FieldOptionId":"360105","ChoiceWeight":"7.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Somewhat easy"},"FieldOptionId":"360106","ChoiceWeight":"5.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not so easy"},"FieldOptionId":"360107","ChoiceWeight":"2.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not at all easy"},"FieldOptionId":"360108","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"3","ColumnLayout":"single","Fields":[{"FieldId":"130905","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Did it take you more or less time than you expected to find what you were looking for on our website?"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"mcqquestion","SequenceOrder":"1","FieldType":"mcq_button","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"A lot less time"},"FieldOptionId":"360109","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"A little less time"},"FieldOptionId":"360110","ChoiceWeight":"7.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"About what I expected"},"FieldOptionId":"360111","ChoiceWeight":"5.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"A little more time"},"FieldOptionId":"360112","ChoiceWeight":"2.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"A lot more time"},"FieldOptionId":"360113","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"4","ColumnLayout":"single","Fields":[{"FieldId":"130900","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"How visually appealing is our webiste?"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"emotion_rating","SequenceOrder":"1","FieldType":"ScaleRating","IsRating":"1","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"5","ColumnLayout":"single","Fields":[{"FieldId":"130906","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"How easy is it to understand the information on our website?"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"mcqquestion","SequenceOrder":"1","FieldType":"mcq_button","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Extremely easy"},"FieldOptionId":"360114","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Very easy"},"FieldOptionId":"360115","ChoiceWeight":"7.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Somewhat easy"},"FieldOptionId":"360116","ChoiceWeight":"5.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not so easy"},"FieldOptionId":"360117","ChoiceWeight":"2.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not at all easy"},"FieldOptionId":"360118","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"6","ColumnLayout":"single","Fields":[{"FieldId":"130907","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"How much do you trust the information provided on our website?"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"mcqquestion","SequenceOrder":"1","FieldType":"mcq_button","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Completely"},"FieldOptionId":"360119","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Pretty much"},"FieldOptionId":"360120","ChoiceWeight":"7.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Moderately"},"FieldOptionId":"360121","ChoiceWeight":"5.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"A little"},"FieldOptionId":"360122","ChoiceWeight":"2.50","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Not at all"},"FieldOptionId":"360123","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"7","ColumnLayout":"single","Fields":[{"FieldId":"130901","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"How likely is it that you would recommend our website to a friend or colleague?"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":"Very unlikely"},"HelpTextLastOption":{"en_US":"Very likely"},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"npsquestion","SequenceOrder":"1","FieldType":"NumberRating","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"round","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"bottom","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":"0","FieldOptionId":"360088","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"1","FieldOptionId":"360089","ChoiceWeight":"1.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"2","FieldOptionId":"360090","ChoiceWeight":"2.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"3","FieldOptionId":"360091","ChoiceWeight":"3.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"4","FieldOptionId":"360092","ChoiceWeight":"4.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"5","FieldOptionId":"360093","ChoiceWeight":"5.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"6","FieldOptionId":"360094","ChoiceWeight":"6.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"7","FieldOptionId":"360095","ChoiceWeight":"7.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"8","FieldOptionId":"360096","ChoiceWeight":"8.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"9","FieldOptionId":"360097","ChoiceWeight":"9.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":"10","FieldOptionId":"360098","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"8","ColumnLayout":"single","Fields":[{"FieldId":"130902","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Do you have any comments about how can we improve our website?"},"PlaceHolder":{"en_US":"Please enter your comments"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"txtComments","SequenceOrder":"1","FieldType":"textarea","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]},{"ScreenSequenceOrder":"10","ColumnLayout":"single","Fields":[{"FieldId":"130909","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Heading"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"heading","SequenceOrder":"1","FieldType":"heading","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130910","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Single Line Content"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"text","SequenceOrder":"2","FieldType":"single_line_text","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130911","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Text Box"},"PlaceHolder":{"en_US":"Enter Here"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"text_box","SequenceOrder":"3","FieldType":"textbox","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"0","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130912","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Dropdown"},"PlaceHolder":{"en_US":"Select"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"dropdown","SequenceOrder":"4","FieldType":"drop_down","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Dropdown"},"FieldOptionId":"360124","ChoiceWeight":"10.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Dropdown"},"FieldOptionId":"360125","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"10,0","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130913","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Checkbox"},"PlaceHolder":{"en_US":"Select one or more"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"checkbox","SequenceOrder":"5","FieldType":"checkbox","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Checkbox"},"FieldOptionId":"360126","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Checkbox"},"FieldOptionId":"360127","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130914","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Multichoice Button"},"PlaceHolder":{"en_US":"Select one or more"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"msqquestion","SequenceOrder":"6","FieldType":"mcq_button","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Button"},"FieldOptionId":"360128","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Button"},"FieldOptionId":"360129","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Button"},"FieldOptionId":"360130","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Button"},"FieldOptionId":"360131","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130915","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Date"},"PlaceHolder":{"en_US":"YYYY-MM-DD"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"date","SequenceOrder":"7","FieldType":"date","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130916","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Ranking"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"RankingQuestion","SequenceOrder":"8","FieldType":"RankingQuestion","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Option 0"},"FieldOptionId":"360132","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Option 1"},"FieldOptionId":"360133","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130917","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Terms & Conditions"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"legalTerm","SequenceOrder":"9","FieldType":"TermsAndConditions","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"doubleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"I Agree"},"FieldOptionId":"360134","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"I don't Agree"},"FieldOptionId":"360135","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130918","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Phone"},"PlaceHolder":{"en_US":"Enter your landline number here"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"Phone","SequenceOrder":"10","FieldType":"phone_number_input_view","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"Mobile_Number","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130919","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Full Name"},"PlaceHolder":{"en_US":"Enter your full name here"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"FullName","SequenceOrder":"11","FieldType":"textbox","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"Full_Name","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130920","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"First Name"},"PlaceHolder":{"en_US":"Enter your first name here"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"FirstName","SequenceOrder":"12","FieldType":"textbox","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"Full_Name","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130921","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":" Email"},"PlaceHolder":{"en_US":"Enter your email address here"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"Email","SequenceOrder":"13","FieldType":"textbox","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"Email_Address","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130922","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Mobile Number"},"PlaceHolder":{"en_US":"Enter your mobile number here"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"Mobile","SequenceOrder":"14","FieldType":"phone_number_input_view","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"Mobile_Number","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130923","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Gender"},"PlaceHolder":{"en_US":""},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"gender","SequenceOrder":"15","FieldType":"radio_button","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"F","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"doubleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":{"FieldOption":[{"FieldOptionName":{"en_US":"Male"},"FieldOptionId":"360136","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""},{"FieldOptionName":{"en_US":"Female"},"FieldOptionId":"360137","ChoiceWeight":"0.00","ActionTaken":"","RedirectFieldId":"","RedirectScreenSequenceOrder":"","SkipToScreen":"","ShowScreenList":"","HideScreenList":""}]},"InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130924","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Birthday"},"PlaceHolder":{"en_US":"YYYY-MM-DD"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"birthday","SequenceOrder":"16","FieldType":"date","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"Birthday","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}},{"FieldId":"130925","HasSkipLogic":"0","OptionHasImages":"0","FieldImageUrl":"","FieldLabel":{"en_US":"Anniversary"},"PlaceHolder":{"en_US":"YYYY-MM-DD"},"HelpTextFirstOption":{"en_US":""},"HelpTextLastOption":{"en_US":""},"RegexValidationMessage":{"en_US":"Invalid Input"},"ValidateRegex":"","FieldParamId":"","FieldName":"anniversary","SequenceOrder":"17","FieldType":"date","IsRating":"0","MinValue":"","MaxValue":"","FieldCategory":"C","DisplayLayout":"single","IsButtonColored":"0","ButtonStyle":"square","buttonType":"singleColumn","PositiveOptionDirection":"left","HelpTextPlacement":"top","ShowSequenceNumberInSelectedOption":"1","SelOptionCount":"1","HideField":"0","AutoFillEnable":"0","OptionValue":"","InputType":"","Required":"0","Logic":{"ActionTaken":"","SkipToScreen":"","HideScreenList":""}}]}];
    var ratingScaleData = {"130900":{"FieldId":"130900","HasSkipLogic":"0","RatingScaleTemplate":"emotion_rating_scale","RatingScaleType":"1","RatingValue":"360083-0.00,360084-2.50,360085-5.00,360086-7.50,360087-10.00","ChoiceCount":5,"SkipLogic":[],"RatingType":{"en_US":"angry,sad,neutral,happy,overjoyed"},"ChoiceHelpText":{"en_US":"Not at all appealing,Not that appealing,Somewhat appealing,Pretty appealing,Extremely appealing"},"RatingFor":{"en_US":"~49876"}}};
    var arrScreenIndexInfo = {"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"10":9};
</script><!-- Screens ends here -->
</div>
<!--<div class="push"></div>-->
</section>
<!-- Footer Start here -->
<footer id="FooterPagination" class="survey-footer-pagination " style="display:none;"><!--Use "bothPagenation" to display both pagination-->
  <div class="" style=";"></div>
    <div class="dot-pagination">
    <ul>
        <li><a style="background-color:#c7c5c5;"></a></li>
              <li><a style="background-color:rgb(134, 193, 50)"></a></li>
              <!--<li><a style="background-color:rgb(134, 193, 50)"></a></li>
              <li><a style="background-color:rgb(134, 193, 50)"></a></li>
               <li><a style="background-color:rgb(134, 193, 50)"></a></li>
              <li><a style="background-color:rgb(134, 193, 50)"></a></li>
              <li><a style="background-color:rgb(134, 193, 50)"></a></li>
              <li><a style="background-color:rgb(134, 193, 50)"></a></li>
              <li><a style="background-color:rgb(134, 193, 50)"></a></li> -->
        
    </ul>
  </div>
      </footer>
<!-- Footer End here --><!--Form Screens End-->

<!--Thank you screen--> 
<section class="thank-you-screen" style="background-image: url('test.jpg');">
    <header>
      
    </header>
    <article class="src-1">
                <figure class="logo thankyou-screen-logo">
            <img src="http://www.innocentsalon.com/images/logo.png">
        </figure>
                <h2 id="ThankyouScreenUpperText" class="medium" style="color:#c5983b;font-family:Source Sans Pro;"><b>Thank you for your feedback!</b></h2>
        <h2 id="ThankyouScreenBottomText" class="medium" style="color:#ffffff;font-family:Open Sans;"></h2>
            </article>
    </section>

<script type="text/javascript">
var thankyouScreenData = {"FontColorBottomText":"#ffffff","FontFamilyBottomText":"Open Sans","FontSizeBottomText":"Medium","FontColorUpperText":"rgb(134, 193, 50)","FontSizeUpperText":"Medium","FontFamilyUpperText":"Source Sans Pro","ButtonStyle":null,"PageBgColor":"#ddb053","ApplyPageBackgroundImage":"0","PageName":"","PageLogo":"","ShowIDontWantToGiveFeedbackAction":"1","ShowFlagWithLanguage":"0","GalleryPageLogo":"0\/1505124621_8595.png","GalleryPageName":null,"ShowExitButtonOnThankyou":"1","ThankUpperText":{"en_US":"Thank you for your feedback!"},"ThankBottomText":{"en_US":""}}</script><div class="h-p-cont" id="StaffFormFieldsContainer">
    </div><div class="h-p-cont">

<input type="hidden" id="FeedbackFormId" value="12261" />
<input type="hidden" id="CompanyId" value="6742" />
<input type="hidden" id="BrandId" value="" />
<input type="hidden" id="BranchId" value="" />

<!-- Form Setting -->
<input type="hidden" id="ShowIntroPageInKioskMode" value="1" />
<input type="hidden" id="ShowThankyouPageInKioskMode" value="1" />
<input type="hidden" id="TotalFeedbackFormScreenCount" value="9" />
<input type="hidden" id="IsClickThrough" value="1" />
<input type="hidden" id="HidePrevNextButton" value="none" />
<input type="hidden" id="HideDoneButtonInClickThrough" value="0" />
<input type="hidden" id="ShowSkipButtonInsteadOfNext" value="0" />

<!-- Language -->
<input type="hidden" id="LoadedLanguageCode" value="en_US" />
<input type="hidden" id="LanguagePickView" value="button" />
<input type="hidden" id="SwitchLanguageScreenDisplay" value="after-intro" />
<input type="hidden" id="SwitchLanguageButtonDisplay" value="intro" />

<!-- Button Colors -->
<input type="hidden" id="ButtonColor" value="rgb(134, 193, 50)" />
<input type="hidden" id="ButtonSelectedColor" value="#c7c5c5" />
<input type="hidden" id="ButtonFontColor" value="#ffffff" />
<input type="hidden" id="ButtonSelectedFontColor" value="#ffffff" />


<!-- Time Stamps -->
<input type="hidden" id="StartTimeFeedBack"/>
<input type="hidden" id="StartTimeFeedBackFormFill"/>
<input type="hidden" id="OnSubmitDateTime"/>

<input type="hidden" id="WebIPAddress" value="49.35.43.109">
<input type="hidden" id="WebBrowserName">
<input type="hidden" id="WebBrowserVersion">
<input type="hidden" id="WebDeviceAndBrowserInfo">
<input type="hidden" id="WebUserOSPlatform">
<input type="hidden" id="WebSourceUrl">
<input type="hidden" id="WebQueryString">
<input type="hidden" id="SurveyUserLatitude">
<input type="hidden" id="SurveyUserLongitude">
<input type="hidden" id="SurveyUserLocation">

<input type="hidden" id="DeviceHeight">
<input type="hidden" id="DeviceWidth">

<input type="hidden" id="WebsiteMainTagName" value="Zonka Feedback">

</div><div class="modal fade" id="myPhoneCodesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content phone-codes-pop-up-outer"> 
            <div class="modal-body phone-codes-modal-body" style="font-family:Source Sans Pro;">
                <div class="phone-code-top">  
                    <button type="button" class="custom-pop-up-close cancel-buton" data-dismiss="modal">Cancel</button>
                    <div class="overflow-input">
                        <input id="PhonecodeInputString" type="text" class="input-block-level form-control" placeholder="Search Country Code">
                    </div>
                </div>
                <div class="phone-code-botom">
                    <ul id="PhoneCodeOptions"></ul>
                    <div style="display: none;" class="no-phonecode-found"><span>No code found as per your search</span><i class="fa fa-warning"></i></div>
                    <input type="hidden" id="PhoneCodeClickedEleId" />
                </div>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>
<!-- /.modal --><div class="modal fade" id="assignedLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content lang-pop-up-outer">
      <div class="modal-body">
      <div class="languageLogo"><img src="/assets/images/s-location.png" class="img-92"></div>
        <h2 class="language-text">Choose Location</h2>
        <input id="LocationInputString" type="text" class="input-block-level form-control locationSearch" placeholder="Search Location">
        <ul id="LocationScreenOptions">
                    <li style="display:none;" class="location-screen-sel-option none-location" tag-location="12103"> <a  href="javascript:void(0);"><span>None</span></a></li>
                  </ul>
        <div style="display: none;" class="no-location-found"><span>No location found as per your search</span><i class="fa fa-warning"></i></div>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --><style>
.ui-datepicker-header{ background:rgb(134, 193, 50);} 
.ui-datepicker-calendar a {border-color: rgb(134, 193, 50) !important;}
.ui-datepicker-calendar a.ui-state-active{background: #c7c5c5 !important;border-color:#c7c5c5!important; color:#ffffff !important}
.ui-datepicker-calendar a:hover{background: #c7c5c5 !important;border-color:#c7c5c5!important; color:#ffffff !important}
.div-in-box li{border-color:rgba(42,19,187,0.3);}
.rdo-option-withbox:before, .checkbox-option-withbox::before{border-color:#c7c5c5;}
.inside li .hover-tick-show{border-color: transparent #c7c5c5 transparent transparent;}
.div-in-box.inside .glyph{color: #ffffff;}
.form-checkbox .un-check::after{border-color:rgb(134, 193, 50);}
.form-radio .un-check::before{background:rgb(134, 193, 50);}
.form-radio > input:checked + .un-check , .hover-selected .un-check , .form-checkbox > input:checked + .un-check{background: transparent !important;border-color: none !important;}
.form-radio > input + .un-check , .form-checkbox > input + .un-check , .form input[type="text"], .form textarea[type="text"], .form select[type="text"] , .terms-and-condition-container {border-color: rgb(134, 193, 50) !important; color: rgb(134, 193, 50) }
.form input[type="text"]:hover, .form textarea[type="text"]:hover, .form select[type="text"]:hover , terms-and-condition-container:hover {border-color:rgba(42,19,187,0.5);}
::placeholder {color: rgb(134, 193, 50);}
</style>        <script type="text/javascript" src="js/jquery.1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/phone_codes.js"></script>
<script type="text/javascript" src="js/lang.en_US.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/survey.js"></script>        <!-- Date Theme-->
<script>
function save_values(customer_id,customer_service_id,service_id,therapist_id,m_q_id,q_id,ans,que,cm_id,admin_id)
{
	
	var data1="action=save_values&customer_id="+customer_id+"&customer_service_id="+customer_service_id+"&service_id="+service_id+"&therapist_id="+therapist_id+"&m_q_id="+m_q_id+"&q_id="+q_id+"&ans="+ans+"&que="+que+"&cm_id="+cm_id+"&admin_id="+admin_id;	
	//alert(data1);
	$.ajax({
		url: "save_values.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
		//	alert(html);
		}
	});
}
</script>
    </body>
</html>