<?php declare(strict_types = 1);

namespace Inspire\Sniffs\Methods;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Checks whether there is an empty line before return statement.
 *
 * @author Jirka Hrazdil <jiri.hrazdil@inspire.cz>
 */
class BlankLinesBeforeReturnSniff implements Sniff
{
    /**
     * Registers the tokens that this sniff wants to listen for.
     */
    public function register()
    {
        return [
            \T_RETURN,
        ];
    }

    /**
     * Called when one of the token types that this sniff is listening for
     * is found.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The PHP_CodeSniffer file where the
     *                                               token was found.
     * @param int $stackPtr The position in the PHP_CodeSniffer
     *                                               file's token stack where the token
     *                                               was found.
     *
     * @return void|int Optionally returns a stack pointer. The sniff will not be
     *                  called again on the current file until the returned stack
     *                  pointer is reached. Return (count($tokens) + 1) to skip
     *                  the rest of the file.
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $tokenLine = $tokens[$stackPtr]['line'];

        $i = 1;

        while ($stackPtr > $i) {
            $currentToken = $tokens[$stackPtr - $i];

            if ($currentToken['line'] === $tokenLine - 1) {
                if (
                    \T_WHITESPACE !== $currentToken['code'] &&
                    \T_OPEN_CURLY_BRACKET !== $currentToken['code'] &&
                    \T_COMMENT !== $currentToken['code'] &&
                    \T_DOC_COMMENT !== $currentToken['code'] &&
                    \T_DOC_COMMENT_CLOSE_TAG !== $currentToken['code'] &&
                    \T_DOC_COMMENT_STRING !== $currentToken['code'] &&
                    \T_DOC_COMMENT_WHITESPACE !== $currentToken['code'] &&
                    \T_DOC_COMMENT_TAG !== $currentToken['code'] &&
                    \T_DOC_COMMENT_OPEN_TAG !== $currentToken['code']
                ) {
                    $error = 'There should be blank line before return statement';
                    $fix = $phpcsFile->addFixableError($error, $stackPtr, 'Invalid');

                    if (true === $fix) {
                        $this->fix($phpcsFile, $stackPtr);
                    }
                    break;
                }
                if (\T_OPEN_CURLY_BRACKET === $currentToken['code']) {
                    break;
                }
            }
            if ($tokens[$stackPtr - $i]['line'] < $tokenLine - 1) {
                // end here
                break;
            }
            $i++;
        }
    }

    /**
     * @return void
     */
    private function fix(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $i = 1;

        while ($stackPtr > $i) {
            if (\T_WHITESPACE !== $tokens[$stackPtr - $i]) {
                $phpcsFile->fixer->addNewlineBefore($stackPtr - $i);
                break;
            }
            $i++;
        }
    }
}
