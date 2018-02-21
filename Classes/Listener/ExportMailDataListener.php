<?php
/**
 * con4gis
 * @version   php 7
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2011 - 2018
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\ExportBundle\Classes\Listener;

use Contao\Email;
use con4gis\ExportBundle\Classes\Events\ExportMailDataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportMailDataListener
 * @package con4gis\ExportBundle\Classes\Listener
 */
class ExportMailDataListener
{


    /**
     * Versendet den Export per Mail.
     * @param ExportMailDataEvent      $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportMailSendData(
        ExportMailDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $mail           = new Email();
        $settings       = $event->getSettings();
        $lang           = $event->getLang();
        $returnstring   = $event->getReturnstring();
        $mailaddress    = $settings->getMailaddress();
        $filename       = $event->getFilename();
        $webtitle       = $event->getWebsitetile();
        $mail->from     = $event->getAdminmail();
        $mail->charset  = $event->getCharset();
        $mail->subject  = sprintf($lang['MSC']['export']['mailsubject'], $webtitle);
        $mail->text     = sprintf($lang['MSC']['export']['mailtext'], $webtitle);
        $mail->attachFileFromString($returnstring, $filename);
        $bytes          = $mail->sendTo($mailaddress);

        if ($bytes !== false) {
            $event->addData(sprintf($GLOBALS['TL_LANG']['MSC']['export']['mailsuccess'], $mailaddress));
        } else {
            $event->addData($GLOBALS['TL_LANG']['MSC']['export']['mailerror']);
        }
    }
}
