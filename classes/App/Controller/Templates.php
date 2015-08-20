<?php

namespace App\Controller;

class Templates extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title = 'SMS Templates';

        if ($this->request->method == 'POST') {
            foreach ($this->request->post('templatesId', array()) as $templateId) {
                $template = $this->pixie->orm->get('templates', $templateId);
                if ($template->loaded()) {
                    $postData = $this->request->post();

                    // remove templates messages
                    if (isset($postData['delete'])) {
                        $template->delete();
                        $this->add_message_success('Templates removed!');
                    }

                    // send message from template
                    if (isset($postData['send'])) {
                        $this->pixie->send_message($template->to, $template->text, $template->use_voice)
                            ? $this->add_message_success('Message sent to the queue for sending!')
                            : $this->add_message_error('Error while sending message!');
                    }

                    // add schedule
                    if (isset($postData['schedule']) && strpos($postData['schedule'], '=') !== false) {
                        try {
                            list($date, $of_date) = explode('=', $postData['schedule']);
                            $turn = $this->pixie->orm->get('turn');

                            $turn->timestamp    = (new \DateTime($date))->getTimestamp();
                            $turn->of_timestamp = (new \DateTime($of_date))->getTimestamp();
                            $turn->text         = $template->text;
                            $turn->to           = $template->to;
                            $turn->use_voice    = $template->use_voice;
                            $turn->sign         = md5($template->text);
                            $turn->filename     = 'schedule_' . $turn->sign;

                            $turn->save();
                            $this->add_message_success('Messages added to a send schedule!');
                        } catch (\Exception $e) {
                            $this->add_message_error('Error added to a send schedule!');
                        }


                    }
                }
            }
        }

        $templates = $this->pixie->orm->get('templates');
        $this->add_view_data('templates', $templates->find_all());
        $this->add_view_data('total_templates', (int)$templates->count_all());
    }

}
