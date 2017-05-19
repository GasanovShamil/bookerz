<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {



    public function sub()
    {
        if(isset($_POST['email'])){
            $this->load->library('email');

            $subject = 'Bookerz - Inscription';
            $message = '<p>Bienvenu sur Bookerz.</p>';

            // Get full html:
            $urlsite = base_url('login/registration');
            $body = '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
                    <title>Bienvenu sur Bookerz</title>
                    <style type="text/css">
                        body {
                            font-family: Arial, Verdana, Helvetica, sans-serif;
                            font-size: 16px;
                        }
                    </style>
                </head>
                <body>
                    <div style="height: 100px; width: 100%; background-color: teal;text-align: center; line-height: 100px; color: white; font-weight: 400; font-size: 30px;">Bookerz</div>
                    <br><br>
                    <div style="font-size: 16px;">Bienvenu sur Bookerz</div>
                    <br>
                    <p>Pour continuer votre inscription, merci de <a href="'.$urlsite.'">cliquez ici</a>
                    <br>
                    <p>À très vite !<p>
                    <br>
                    <p>L\'équipe Bookerz.</p>
                    <div style="height: 100px; width: 100%; background-color: teal;"></div>
                </body>
            </html>';
                // Also, for getting full html you may use the following internal method:
                //$body = $this->email->full_html($subject, $message);

            $result = $this->email
                    ->from('booker.project@gmail.com')
                    ->to('elyes.elbahri77@gmail.com')
                    ->subject($subject)
                    ->message($body)
                    ->send();

            echo '<br />';
            echo $this->email->print_debugger();

            exit;
        } else {

        }
    }
}
