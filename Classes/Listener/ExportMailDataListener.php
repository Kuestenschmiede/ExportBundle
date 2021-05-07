<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
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
        $mail = new Email();
        $settings = $event->getSettings();
        $lang = $event->getLang();
        $returnstring = $event->getReturnstring();
        $mailaddress = $settings->getMailaddress();
        $filename = $event->getFilename();
        $webtitle = $event->getWebsitetile();
        $mail->from = $settings->getSender();
        $mail->charset = $event->getCharset();
        $mail->subject = sprintf($lang['MSC']['export']['mailsubject'], $webtitle);
        $mail->text = sprintf($lang['MSC']['export']['mailtext'], $webtitle);
        $mail->attachFileFromString($returnstring, $filename);
        $bytes = $mail->sendTo($mailaddress);

        if ($bytes !== false) {
            $event->addData(sprintf($GLOBALS['TL_LANG']['MSC']['export']['mailsuccess'], $mailaddress));
        } else {
            $event->addData($GLOBALS['TL_LANG']['MSC']['export']['mailerror']);
        }
    }
}
