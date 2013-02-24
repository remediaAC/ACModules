<?php

  /**
   * Do frequently check
   */
  function frosso_mail_notify_handle_on_frequently() {
    
    // Send messages that are set to be sent in background
    $messages = OutgoingMessages::findByMethod(ApplicationMailer::SEND_IN_BACKGROUD, MAILING_QUEUE_MAX_PER_REQUEST);
    if(is_foreachable($messages)) {
    	foreach($messages as $message) {
    		Logger::log($message->getId());
    	} // foreach
    } // if
    return count($messages);
    
  } // frosso_mail_notify_handle_on_frequently