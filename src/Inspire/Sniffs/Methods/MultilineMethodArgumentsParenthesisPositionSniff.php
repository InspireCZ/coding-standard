<?php declare(strict_types = 1);

namespace Inspire\Sniffs\Methods;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use const T_OPEN_CURLY_BRACKET;
use const T_SEMICOLON;

/**
 * Checks whether there is no comma immediately preceding closing parenthesis of
 * function or method argument list.
 *
 * @author Jirka Hrazdil <jiri.hrazdil@inspire.cz>
 */
class MultilineMethodArgumentsParenthesisPositionSniff implements Sniff
{
    /**
     * Registers the tokens that this sniff wants to listen for.
     */
    public function register()
    {
        return [
            \T_FUNCTION,
        ];
    }

    /**
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

        $tokenIndex = $stackPtr + 1;
        $tokenCount = \count($tokens);

        while ($tokenIndex < $tokenCount) {
            $currentToken = $tokens[$tokenIndex];

            if (\T_CLOSE_PARENTHESIS === $currentToken['code']) {
                $closeParenthesisLine = $currentToken['line'];
                $i = 1;

                while ($stackPtr > $i) {
                    $previousToken = $tokens[$tokenIndex - $i];

                    if ('T_WHITESPACE' === $previousToken['type']) {
                        $i++;
                        continue;
                    }

                    if ('T_COMMA' === $previousToken['type'] && $closeParenthesisLine === $previousToken['line']) {
                        $phpcsFile->addError(
                            'Trailing comma in function argument list must not be on the same line as closing parenthesis.',
                            $tokenIndex,
                            'Trailingcomma'
                        );

                        return $tokenIndex + 1;
                    }

                    return $tokenIndex + 1;
                }
            }

            $tokenIndex++;
        }
    }
}
