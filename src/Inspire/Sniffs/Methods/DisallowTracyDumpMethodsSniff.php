<?php declare(strict_types = 1);

namespace Inspire\Sniffs\Methods;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff to detect Debugger forbidden method calls
 *
 * @author Marek Humpolik <marek.humpolik@inspire.cz>
 */
class DisallowTracyDumpMethodsSniff implements Sniff
{
    const BDUMP = 'bdump';
    const DUMP = 'dump';
    const BAR_DUMP = 'barDump';
    const DUMPEX = 'dumpex';

    const DEBUGGER_CLASS = [
        "Debugger",
        "NDebugger",
        "Tracy\Debugger",
        "\Tracy\Debugger",
    ];

    /**
     * @return array
     */
    public function register()
    {
        return [\T_STRING];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $keyword = $tokens[$stackPtr]['content'];
        $previousToken = $tokens[$stackPtr - 1];
        $prevPrevToken = $tokens[$stackPtr - 2] ?? ['code' => null];

        if (\in_array($keyword, [self::DUMP,
                self::BDUMP,
                self::DUMPEX], true) && \T_WHITESPACE === $previousToken['code'] && \T_FUNCTION !== $prevPrevToken['code']) {
            $phpcsFile->addError($this->getErrorMessage($keyword), $stackPtr, "Found");
        }

        if (\in_array($keyword, [self::DUMP, self::BAR_DUMP]) && \T_DOUBLE_COLON === $previousToken['code']) {
            $class = $tokens[$stackPtr - 2]['content'];

            if (\in_array($class, self::DEBUGGER_CLASS, true)) {
                $phpcsFile->addError($this->getErrorMessage($class . '::' . $keyword), $stackPtr, "Found");
            }
        }
    }

    /**
     * @param string $founded
     *
     * @return string
     */
    private function getErrorMessage(string $founded): string
    {
        return "Found disallowed '$founded' call";
    }
}
