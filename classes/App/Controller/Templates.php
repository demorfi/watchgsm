<?php

namespace App\Controller;

class Templates extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'SMS Templates';

        if ($this->request->method == 'POST') {
            foreach ($this->request->post('templatesId') as $templateId) {
                $template = $this->pixie->orm->get('templates', $templateId);
                if ($template->loaded()) {

                    // remove templates messages
                    if ($this->request->post('delete')) {
                        $template->delete();
                        $this->add_message_success('Templates removed!');
                    }

                    // send message from template
                    if ($this->request->post('send')) {
                        $this->pixie->send_message($template->to, $template->text)
                            ? $this->add_message_success('Message sent to the queue for sending!')
                            : $this->add_message_error('Error while sending message!');
                    }
                }
            }
        }

        $this->add_view_data('templates', $this->pixie->orm->get('templates')->find_all());
    }

}
