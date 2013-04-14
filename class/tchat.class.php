<?php

class tchat {

    private $messagesList;

    function tchat() {
        
    }

    function getMessageList() {
        return $this->messagesList;
    }

    function setMessageList($messages) {
        $this->messagesList = $messages;
    }

    function loadLastMessages($char, $max = '10', $canal = '0') {
        $sql = "SELECT * FROM tchat";
        $sql .= " WHERE canal = " . $canal;

        if ($canal == 2) {
            $sql .= " && idcanal = '" . $char->getGuildId() . "'";
        }

        if ($canal == 4) {
            $sql .= " && idcanal = '" . group::getGroup($char->getId()) . "'";
        }

        $sql .= " ORDER BY id DESC LIMIT 0," . $max;

        $result = loadSqlResultArrayList($sql);
        $this->setMessageList($result);
    }

    function printMessagesList($array_smiley = array()) {
        if (count($this->getMessageList()) > 0) {
            foreach ($this->getMessageList() as $message) {
                echo timestampToHour($message['timestamp'], 'h');
                $login = char::getNameById($message['user_id']);
                echo ' : ';
                echo $login;
                echo ' : ';
                $messageTxt = $this->cleanMessage($message['message']);

                // on remplace les symboles par des smileys
                if (count($array_smiley) > 0) {
                    foreach ($array_smiley as $key => $pict) {
                        $messageTxt = str_replace($key, $pict, $messageTxt);
                    }
                }

                echo $messageTxt . ' <br />';
            }
        }
    }

    function cleanMessage($message) {
        return $message;
    }

    function getCharParameter($char_id) {
        $sql = "SELECT parameter FROM `tchat_parameter` WHERE char_id = " . $char_id;
        $result = loadSqlResult($sql);

        if ($result == '')
            $result = 0;

        return $result;
    }

    function swapChannel($char_id, $channel = 0) {
        $sql = "INSERT INTO `tchat_parameter` (char_id,parameter) VALUES ($char_id,'$channel') ON DUPLICATE KEY UPDATE parameter = $channel";
        loadSqlExecute($sql);
    }

    public static function addMessage($user_id, $message, $time, $canal, $idcanal) {
        $sql = "INSERT INTO tchat (user_id,message,timestamp,canal,idcanal) VALUES ($user_id,'$message',$time,$canal,$idcanal)";
        loadSqlExecute($sql);
    }

}

?>