<?php

//echo "output" . PHP_EOL;

/***********************************************************************************************
 * While output buffering is active, no output is sent from the script (other than headers),   *
 * instead the output is stored in an internal buffer.                                         *
 *                                                                                             *
 * https://www.php.net/manual/en/function.ob-start.php                                         *
 *                                                                                             *
 * To flush (send/output) the content and destroy the buffer: ob_end_flush()                   *
 * To discard the content and destroy the buffer: ob_end_clean()                               *
 *                                                                                             *
 * The functions that achieve the same results but do not destroy the buffer:                  *
 * - https://www.php.net/manual/en/function.ob-flush.php                                       *
 * - https://www.php.net/manual/en/function.ob-clean.php                                       *
 ***********************************************************************************************/
ob_start();
//echo "buffer content" . PHP_EOL;
ob_end_flush();

ob_start();
//echo "buffer content" . PHP_EOL;
ob_end_clean();


/*******************************************************************
 * The buffer content may be stored in a variable.                 *
 *                                                                 *
 * See: https://www.php.net/manual/en/function.ob-get-contents.php *
 *******************************************************************/

ob_start();
echo "buffer content" . PHP_EOL;
$output = ob_get_contents();
ob_end_clean();

//echo $output;

/***********************************************************************
 * You may add a callback to ob_start() for postprocessing the output. *
 *                                                                     *
 * See also: https://www.php.net/manual/en/function.ob-gzhandler.php   *
 ***********************************************************************/
ob_start('capitalize');
//echo "buffer content" . PHP_EOL;
ob_end_flush();

function capitalize(string $buffer) : string
{
    return strtoupper($buffer);
}


/****************************************************************************
 * Discussion - reasons for output buffering:                               *
 * - when should the body of a response be sent in relation to its headers? *
 * - should output always be displayed?                                     *
 * - render output once vs in pieces?                                       *
 ***************************************************************************/

//ob_start();
//echo "before header";
//header('Content-Type: text/plain');
//ob_end_flush();
