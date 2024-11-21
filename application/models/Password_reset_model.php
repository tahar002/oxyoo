<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password_reset_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
        $this->load->library('session');
	}

  function testMail($mail) {
            $config = $this->db->get('config')->row();

            $mailConfig= array(
              'protocol' =>'smtp',
              'smtp_host' => $config->SMTP_Host,
              'smtp_port' => $config->SMTP_Port,
              'smtp_user' => $config->SMTP_Username,
              'smtp_pass' => $config->SMTP_Password,
              'charset' => 'iso-8859-1',
              'mailtype' => 'text',
              'wordwrap' => TRUE
            );

            $this->load->library('email',$mailConfig);
		        $this->email->set_newline("\r\n");
        
		        $this->email->from($config->SMTP_Username,'');
		        $this->email->to($mail);
		        $this->email->subject('TEST MAIL');
		        $this->email->message("This a Test Mail to Test Mail Configuration");
        
		        if($this->email->send()) {
                    echo "Message has been sent";
                } else {
                    echo "Something Went Wrong!";
                }
  }

    function password_reset_mail($mail) {
		    $d=strtotime("now");
        $Current_DT =  date("Y-m-d h:i:s", $d);
        $Current_DT_encoded = base64_encode($Current_DT);

		    $this->db->where('email', $mail);
		    $num_rows = $this->db->get('user_db')->num_rows();

        $code = rand(1000, 9999);

		if($num_rows > 0) {
            $this->db->set('code', $code);
			  $this->db->set('token', $Current_DT_encoded);
		    $this->db->set('mail', $mail);
		    $this->db->set('type', 'Password Reset');
		    $this->db->insert('mail_token_details');
		    if($this->db->insert_id() == "") {
		    	echo "Something Went Wrong!";
		    } else {
				$config = $this->db->get('config')->row();

		    	$mailConfig= array(
		    		'protocol' =>'smtp',
		    		'smtp_host' => $config->SMTP_Host,
		    		'smtp_port' => $config->SMTP_Port,
		    		'smtp_user' => $config->SMTP_Username,
		    		'smtp_pass' => $config->SMTP_Password,
		    		'charset' => 'iso-8859-1',
		    		'mailtype' => 'html',
		    		'wordwrap' => TRUE
		    	);
		        $body= "<!doctype html>
                <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
                
                <head>
                  <title>
                  </title>
                  <!--[if !mso]><!-->
                  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                  <!--<![endif]-->
                  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1'>
                  <style type='text/css'>
                    #outlook a {
                      padding: 0;
                    }
                
                    body {
                      margin: 0;
                      padding: 0;
                      -webkit-text-size-adjust: 100%;
                      -ms-text-size-adjust: 100%;
                    }
                
                    table,
                    td {
                      border-collapse: collapse;
                      mso-table-lspace: 0pt;
                      mso-table-rspace: 0pt;
                    }
                
                    img {
                      border: 0;
                      height: auto;
                      line-height: 100%;
                      outline: none;
                      text-decoration: none;
                      -ms-interpolation-mode: bicubic;
                    }
                
                    p {
                      display: block;
                      margin: 13px 0;
                    }
                  </style>
                  <!--[if mso]>
                        <noscript>
                        <xml>
                        <o:OfficeDocumentSettings>
                          <o:AllowPNG/>
                          <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                        </xml>
                        </noscript>
                        <![endif]-->
                  <!--[if lte mso 11]>
                        <style type='text/css'>
                          .mj-outlook-group-fix { width:100% !important; }
                        </style>
                        <![endif]-->
                  <!--[if !mso]><!-->
                  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700' rel='stylesheet' type='text/css'>
                  <style type='text/css'>
                    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700);
                  </style>
                  <!--<![endif]-->
                  <style type='text/css'>
                    @media only screen and (min-width:480px) {
                      .mj-column-per-100 {
                        width: 100% !important;
                        max-width: 100%;
                      }
                    }
                  </style>
                  <style media='screen and (min-width:480px)'>
                    .moz-text-html .mj-column-per-100 {
                      width: 100% !important;
                      max-width: 100%;
                    }
                  </style>
                  <style type='text/css'>
                    @media only screen and (max-width:480px) {
                      table.mj-full-width-mobile {
                        width: 100% !important;
                      }
                
                      td.mj-full-width-mobile {
                        width: auto !important;
                      }
                    }
                  </style>
                </head>
                
                <body style='word-spacing:normal;background-color:#fafbfc;'>
                  <div style='background-color:#fafbfc;'>
                    <!--[if mso | IE]><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
                    <div style='margin:0px auto;max-width:600px;'>
                      <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
                        <tbody>
                          <tr>
                            <td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;'>
                              <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:middle;width:600px;' ><![endif]-->
                              <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;'>
                                <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:middle;' width='100%'>
                                  <tbody>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:25px;word-break:break-word;'>
                                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'>
                                          <tbody>
                                            <tr>
                                              <td style='width:125px;'>
                                              <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;line-height:1;text-align:center;color:#000000;'>".strtoupper($config->name)."</div>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <!--[if mso | IE]></td></tr></table><![endif]-->
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' bgcolor='#ffffff' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
                    <div style='background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;'>
                      <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'>
                        <tbody>
                          <tr>
                            <td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;'>
                              <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:middle;width:600px;' ><![endif]-->
                              <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;'>
                                <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:middle;' width='100%'>
                                  <tbody>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
                                        <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'><span>Hello,</span></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
                                        <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'>Please use the verification code below To Reset Your Password on ".$config->name.":</div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                                        <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;line-height:1;text-align:center;color:#000000;'>".$code."</div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;padding-right:16px;padding-left:25px;word-break:break-word;'>
                                        <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'>If you didn't request this, you can ignore this email or let us know.</div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align='center' style='font-size:0px;padding:10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
                                        <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'>Thanks! <br />".$config->name." team</div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <!--[if mso | IE]></td></tr></table><![endif]-->
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><![endif]-->
                  </div>
                </body>
                
                </html>";
		        
		        $this->load->library('email',$mailConfig);
		        $this->email->set_newline("\r\n");
        
		        $this->email->from($config->SMTP_Username,'');
		        $this->email->to($mail);
		        $this->email->subject('PASSWORD RESET');
		        $this->email->message($body);
        
		        if($this->email->send()) {
                    echo "Message has been sent";
                } else {
                    echo "Something Went Wrong!";
                }
                
		    }
		} else {
			echo 'Email Not Registered';
		}

		
	}

    function checkCode($code) {
        $this->db->where('code', $code);
        $mail_token_rows = $this->db->get('mail_token_details')->num_rows();
        if($mail_token_rows > 0) {
            $this->db->where('code', $code);
            $mail_token = $this->db->get('mail_token_details')->row();
            $Tkn_Time =  base64_decode($mail_token->token);
            $d=strtotime("now");
            $Current_DT =  date("Y-m-d h:i:s", $d);
            $to_time = strtotime($Current_DT);
            $from_time = strtotime($Tkn_Time);
            $Diff = ($to_time - $from_time) / 60;
            if($Diff>5) {
                echo "Expired";
            } else {
                if($mail_token->status == 0) {
                    $this->db->set('status', 1);
                    $this->db->where('code', $code);
                    $this->db->update('mail_token_details');
    
                    $_SESSION['code'] = $mail_token->code;
                    echo "valid Code";
                } else {
                    echo 'Used Code';
                }
            }

        } else {
			echo 'Invalid Request';
		}
    }

    function password_reset($code, $pass) {
        $this->db->where('code', $code);
        $mail_token_rows = $this->db->get('mail_token_details')->num_rows();
        if($mail_token_rows > 0) {
            $this->db->where('code', $code);
            $mail_token_details = $this->db->get('mail_token_details')->row();


            $Tkn_Time =  base64_decode($mail_token_details->token);
            $d=strtotime("now");
            $Current_DT =  date("Y-m-d h:i:s", $d);
            $to_time = strtotime($Current_DT);
            $from_time = strtotime($Tkn_Time);
            $Diff = ($to_time - $from_time) / 60;

            if($Diff>5) {
                echo "Expired!";
            } else {
                $this->db->set('password', $pass);
                $this->db->where('email', $mail_token_details->mail);
                $this->db->update('user_db');
                echo 'Password Updated successfully';
            }
        } else {
			echo 'Invalid Request';
		}
    }

}