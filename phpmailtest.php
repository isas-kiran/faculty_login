<?php include 'inc_classes.php';?>
<?php require 'PHPMailer-5.2.14/class.phpmailer.php';
    //require('phpmailer/PHPMailerAutoload.php');



    define ('GUSER','info@isasbeautyschool.com');
    define ('GPWD','7Jbond@!#007');

    $recever1 = 'kiran@isassystems.com';

    $enq_name = 'Kiran Vyavahare';
    $enq_email = 'kiran@isassystems.com';
    $enq_phone = '9822519894';
    $enq_message = 'Hi, Kiran is here for mail testing';

    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    
    if(empty($enq_name) || empty($enq_email) || empty($enq_phone) || empty($enq_message)){
        Redirect_to("index.php?error=1");
    }else{
        $mail = new PHPMailer(true);
        try{
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->SMTPDebug  = 2; 
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = "none";
            $mail->Port = 465;
            $mail->Host = "smtp.gmail.com";
            // $mail->CharSet   = "UTF-8";
            $mail->Username = 'info@isasbeautyschool.com';
            $mail->Password = '7Jbond@!#007';
            $mail->isHTML(true); 
            $mail->setFrom($enq_email,$enq_name);
            $mail->From = GUSER; 
            $mail->FromName = $enq_name;

            $mail->addAddress($recever1);
        
              $mail->Subject ='Test Mail from - '. $enq_name;
              $mail->Body = '<table class="table" cellspacing="0">
              <thead>
                <tr>
                    <th colspan="2">Enquiry Mail from - '. $enq_name .'</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td colspan="2">'. '<p>Dear Sir / Madam, I have some enquiries. My Details are as follows :</p></br>' .'</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>'. $enq_email .'</td>
                </tr>
                <tr>
                    <td>Phone No:</td>
                    <td>'. $enq_phone .'</td>
                </tr>
                <tr>
                    <td>Message:</td>
                    <td>'. $enq_message .'</td>
                </tr>
                <tr>
                    <td>Date and TIME of Enquery:</td>
                    <td>'. $DateTime .'</td>
                </tr>
              </tbody>
              </table>';
              
              $mail->send();
              $success_msg =  "Your Message Sent Successfully: ";
        }catch(phpmailerException $e){
            echo $e->errorMessage();
        }catch(Exception $e){
            echo $e->getMessage();
        }
	}

	?>