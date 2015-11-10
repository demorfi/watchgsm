<?php

namespace App\Model;

class App extends \PHPixie\ORM\Model
{

    public function save()
    {
        if (!$this->loaded()) {
            $events = $this->pixie->orm->get('events')->where('apply_to', strtolower($this->model_name))->find_all();
            foreach ($events as $event) {

                // check specified phone number
                if ($event->addressee == 'specified') {
                    $addressee_from = strpos($event->addressee_from, ';') !== false
                        ? explode(';', $event->addressee_from) : array($event->addressee_from);

                    if (in_array(ltrim($this->from, '+'), $addressee_from) === false) {
                        continue;
                    }
                }

                // check containing text
                if ($event->rule == 'containing') {
                    $event->search_text = $event->search_text == '*' ? '.*' : $event->search_text;
                    if (strpos($this->text, $event->search_text) === false
                        && !preg_match('~' . str_replace('~', '', $event->search_text) . '~ui', $this->text)
                    ) {
                        continue;
                    }
                }

                // apply action
                switch ($event->action) {
                    case ('run_script'):
                        $result_script = shell_exec(escapeshellcmd($event->script_path));

                        switch ($event->result) {
                            case ('reply'):
                                $this->pixie->send_message($this->from, $result_script);
                                break;

                            case ('forward'):
                                $this->pixie->send_message($event->result_forward, $this->from . ':' . $result_script);
                                break;
                        }
                        break;

                    case ('reply'):
                        $this->pixie->send_message($this->from, $event->action_reply, $event->action_reply_voice);
                        break;

                    case ('forward'):
                        $this->pixie->send_message($event->action_forward, $this->from . ':' . $this->text);
                        break;
                }

                $event->last_run = (new \DateTime('now'))->getTimestamp();
                $event->save();
            }
        }

        parent::save();
    }
}