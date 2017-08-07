<?php
/**
 * con4gis
 * @version   2.0.0
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2016 - 2017.
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\exportBundle\classes\listener;

use Contao\Email;
use con4gis\exportBundle\classes\events\ExportMailDataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportMailDataListener
 * @package con4gis\exportBundle\classes\listener
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
