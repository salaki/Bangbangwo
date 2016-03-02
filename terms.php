<?php
session_start();
include_once 'include/config.php';

// top part of page
if (isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
    $type = mysql_result(mysql_query("SELECT type FROM members WHERE id='" . $_SESSION['userid'] . "'"), 0);
    if ($type == 0) {
        $link = '<li><a href="dashboard.php">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
    } else {
        $link = '<li><a href="dashboard_tasker.php">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
    }
} else {
    $link = ' <li><a href="signup.php">Sign up</a></li><li style="border-right:none;"><a href="login.php">Login</a></li>';
}

// end top part here
?>
<!DOCTYPE html>
<html lang="en">
    <html>
        <head>
        
        <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

            <!-- Optional theme -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

            <link href="style.css" rel="stylesheet" type="text/css"/>
            <link rel="icon" 
                  type="image/png" 
                  href="/images/favicon.png" />
            <style>
                .terms p{
                    font-size: 15px;
                }
            </style>
        </head>
        <body>
            <div class="wrapper">
            
            	<header style="background:none; height:auto;">
		<div class="container">
        	<div class="col-xs-5" id="logo"><a href="/"><img class="col-sm-7" src="images/logo.png" style="width:90%; padding:0;"> </a> Beta</div>
            <div class="col-xl-7" id="navigation">
                <ul style="font-family: Adelle_Regular,sans-serif;" class="menu1">
                  <li><a href="/">How it Works</a></li>
                  <?=$link;?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
	</header>
            
            
            

                




<section>

                <div class="container">

                    <div class="main text-center terms" style="text-align: left">
                        <span class="txt_darkgrey"></span><h1 style="font-size: 25px" class="txt">LEBIU TECHNOLOGY LLC Terms and Conditions ("Terms") </h1>
                        <p style="font-size:13px" class="txt_slogan">Last updated: November 24, 2014</p>
                        <p>Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the ubangbangwo.com
                            website (the "Service") operated by LEBIU TECHNOLOGY LLC ("us", "we", or "our").
                            Your access to and use of the Service is conditioned upon your acceptance of and compliance with these Terms. These Terms 
                            apply to all visitors, users and others who wish to access or use the Service.
                            By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you do 
                            not have permission to access the Service.</p>
                        <p ><b>Communications</b></p>
                        <p >By creating an Account on our service, you agree to subscribe to newsletters, marketing or promotional materials and other information we may send. However, you may opt out of receiving any, or all, of these communications from us by following the unsubscribe link or instructions provided in any email we send.</p>
                        <p ><b>Content</b></p>
                        <p>Our Service allows you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material ("Content"). You are responsible for the Content that you post on or through the Service, including its legality, reliability, and appropria.</p>
                        <p>By posting Content on or through the Service, You represent and warrant that: (i) the Content is yours (you own it) and/or you have the right to use it and the right to grant us the rights and license as provided in these Terms, and (ii) that the posting of your Content on or through the Service does not violate the privacy rights, publicity rights, copyrights, contract rights or any other rights of any person or entity. We reserve the right to terminate the account of anyone found to be infringing on a copyright.</p>
                        <p>You retain any and all of your rights to any Content you submit, post or display on or through the Service and you are responsible for protecting those rights. We take no responsibility and assume no liability for Content you or any third party posts on or through the Service. However, by posting Content using the Service you grant us the right and license to use, modify, publicly perform, publicly display, reproduce, and distribute such Content on and through the Service.</p>
                        <p>LEBIU TECHNOLOGY LLC has the right but not the obligation to monitor and edit all Content provided by users.</p>
                        <p>In addition, Content found on or through this Service are the property of LEBIU TECHNOLOGY LLC or used with permission. You may not distribute, modify, transmit, reuse, download, repost, copy, or use said Content, whether in whole or in part, for commercial purposes or for personal gain, without express advance written permission from us.</p>
                        <p><b>Accounts</b></p>
                        <p>When you create an account with us, you guarantee that you are above the age of 18, and that the information you provide us is accurate, complete, and current at all times. Inaccurate, incomplete, or obsolete information may result in the immediate termination of your account on the Service.</p>
                        <p>You are responsible for maintaining the confidentiality of your account and password, including but not limited to the restriction of access to your computer and/or account. You agree to accept responsibility for any and all activities or actions that occur under your account and/or password, whether your password is with our Service or a third-party service. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>
                        <p>You may not use as a username the name of another person or entity or that is not lawfully available for use, a name or trademark that is subject to any rights of another person or entity other than you, without appropriate authorization. You may not use as a username any name that is offensive, vulgar or obscene.</p>
                        <p>We reserve the right to refuse service, terminate accounts, remove or edit content in our sole discretion.</p>
                        <p><b>Intellectual Property</b></p>
                        <p>The Service and its original content (excluding Content provided by users), features and functionality are and will remain the exclusive property of LEBIU TECHNOLOGY LLC and its licensors. The Service is protected by copyright, trademark, and other laws of both the United States and foreign countries. Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of LEBIU TECHNOLOGY LLC.</p>
                        <p><b>Our Service may contain links to third party web sites or services that are not owned or controlled by LEBIU TECHNOLOGY LLC.</b></p>
                        <p>LEBIU TECHNOLOGY LLC has no control over, and assumes no responsibility for the content, privacy policies, or practices of any third party web sites or services. We do not warrant the offerings of any of these entities/individuals or their websites.</p>
                        <p>You acknowledge and agree that LEBIU TECHNOLOGY LLC shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such third party web sites or services.</p>
                       <p>We strongly advise you to read the terms and conditions and privacy policies of any third party web sites or services that you visit.</p>
                        <p><b>Termination</b></p>
                        <p>We may terminate or suspend your account and bar access to the Service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of the Terms.</p>
                        <p>If you wish to terminate your account, you may simply discontinue using the Service.</p>
                        <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
                        <p><b>Indemnification</b></p>
                        <p>You agree to defend, indemnify and hold harmless LEBIU TECHNOLOGY LLC and its licensee and licensors, and their employees, contractors, agents, officers and directors, from and against any and all claims, damages, obligations, losses, liabilities, costs or debt, and expenses (including but not limited to attorney's fees), resulting from or arising out of a) your use and access of the Service, by you or any person using your account and password; b) a breach of these Terms, or c) Content posted on the Service.</p>
                        <p><b>Limitation Of Liability</b></p>
                        <p>In no event shall LEBIU TECHNOLOGY LLC, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from (i) your access to or use of or inability to access or use the Service; (ii) any conduct or content of any third party on the Service; (iii) any content obtained from the Service; and (iv) unauthorized access, use or alteration of your transmissions or content, whether based on warranty, contract, tort (including negligence) or any other legal theory, whether or not we have been informed of the possibility of such damage, and even if a remedy set forth herein is found to have failed of its essential purpose.</p>
                        <p><b>Disclaimer</b></p>
                        <p>Your use of the Service is at your sole risk. The Service is provided on an "AS IS" and "AS AVAILABLE" basis. The Service is provided without warranties of any kind, whether express or implied, including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, non-infringement or course of performance.</p>
                        <p>LEBIU TECHNOLOGY LLC its subsidiaries, affiliates, and its licensors do not warrant that a) the Service will function uninterrupted, secure or available at any particular time or location; b) any errors or defects will be corrected; c) the Service is free of viruses or other harmful components; or d) the results of using the Service will meet your requirements.</p>
                        <p><b>Exclusions</b></p>
                        <p>Some jurisdictions do not allow the exclusion of certain warranties or the exclusion or limitation of liability for consequential or incidental damages, so the limitations above may not apply to you.</p>
                        <p><b>Governing Law</b></p>
                        <p>These Terms shall be governed and construed in accordance with the laws of Maryland, United States, without regard to its conflict of law provisions.</p>
                        <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have had between us regarding the Service.</p>
                        <p><b>Changes</b></p>
                        <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
                        <p>By continuing to access or use our Service after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use the Service.</p>
                        <p><b>Contact Us</b></p>
                        <p>If you have any questions about these Terms, please contact us through <a href="/feedback">feedback link.</a></p>
                    </div>


                </div>
                
         </section>       
                <div class="footer">
                    <div class="container">
                        <div class="ftlft">
                            <ul>
                                <li><a href="aboutus">About Us</a></li>
                                <li><a href="feedback">Feedback</a></li>
                                <!--<li><a href="blog">Blog</a></li>-->
                                <li><a href="terms">Terms & Privacy</a></li>
                            </ul>
                        </div>
                        <div class="ftrgt45">
                            <ul>


                            </ul>
                        </div>

                    </div>


                </div>

        </body>
    </html>