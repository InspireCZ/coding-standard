<?php declare(strict_types = 1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Classes\DuplicateClassNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\ForLoopShouldBeWhileLoopSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\JumbledIncrementerSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnconditionalIfStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnnecessaryFinalModifierSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\ControlStructures\InlineControlStructureSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\ByteOrderMarkSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\InlineHTMLSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\NestingLevelSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\ConstructorNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\CharacterBeforePHPOpeningTagSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DeprecatedFunctionsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowAlternativePHPTagsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowShortOpenTagSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\DisallowTabIndentSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\ScopeIndentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LanguageConstructSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SuperfluousWhitespaceSniff;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\MultilineCommentOpeningClosingFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoTrailingCommaInListCallFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededCurlyBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocLineSpanFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarAnnotationCorrectOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SemicolonAfterInstructionFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypehintFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use SlevomatCodingStandard\Sniffs\Classes\UselessLateStaticBindingSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullCoalesceOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireShortTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Functions\StaticClosureSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedInheritedVariablePassedToClosureSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\DisallowGroupUseSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedGlobalConstantsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedGlobalFunctionsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UselessAliasSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function(ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SETS, [
        SetList::STRICT,
        SetList::ARRAY,
        SetList::COMMENTS,
        SetList::NAMESPACES,
        SetList::PHPUNIT,
    ]);

    $services->set(PhpUnitMethodCasingFixer::class);
    $services->set(FunctionToConstantFixer::class);
    $services->set(ExplicitStringVariableFixer::class);
    $services->set(ExplicitIndirectVariableFixer::class);
    $services->set(NewWithBracesFixer::class);
    $services->set(ClassDefinitionFixer::class)
        ->call('configure', [[
            'single_line' => true,
        ]]);

    $services->set(StandardizeIncrementFixer::class);
    $services->set(SelfAccessorFixer::class);
    $services->set(MagicConstantCasingFixer::class);
    $services->set(AssignmentInConditionSniff::class);
    $services->set(NoUselessElseFixer::class);
    $services->set(SingleQuoteFixer::class);

    $services->set(YodaStyleFixer::class)
        ->call('configure', [[
            'equal' => true,
            'identical' => true,
            'less_and_greater' => false,
            'always_move_variable' => true,
        ]]);

    $services->set(OrderedClassElementsFixer::class);

    $parameters->set(Option::SKIP, [
        AssignmentInConditionSniff::class . '.FoundInWhileCondition' => null,
    ]);

    $services->set(PhpdocLineSpanFixer::class)
        ->call('configure', [[
            'const' => 'single',
            'property' => 'single',
            'method' => 'multi',
        ]]);

    $services->set(NoTrailingWhitespaceInCommentFixer::class);
    $services->set(PhpdocTrimConsecutiveBlankLineSeparationFixer::class);
    $services->set(PhpdocTrimFixer::class);
    $services->set(NoEmptyPhpdocFixer::class);
    $services->set(PhpdocIndentFixer::class);
    $services->set(PhpdocTypesFixer::class);
    $services->set(PhpdocReturnSelfReferenceFixer::class);
    $services->set(PhpdocVarWithoutNameFixer::class);
    $services->set(RemoveUselessDefaultCommentFixer::class);

    $services->set(MethodChainingIndentationFixer::class);

    $services->set(ClassAttributesSeparationFixer::class)
        ->call('configure', [[
            'elements' => [
                'const' => ClassAttributesSeparationFixer::SPACING_ONE,
                'property' => ClassAttributesSeparationFixer::SPACING_ONE,
                'method' => ClassAttributesSeparationFixer::SPACING_ONE,
                'trait_import' => ClassAttributesSeparationFixer::SPACING_NONE
            ],
        ]]);

    $services->set(ConcatSpaceFixer::class)
        ->call('configure', [[
            'spacing' => 'one',
        ]]);

    $services->set(SuperfluousWhitespaceSniff::class)
        ->property('ignoreBlankLines', false);

    $services->set(CastSpacesFixer::class);

    $services->set(BinaryOperatorSpacesFixer::class)
        ->call('configure', [[
            'operators' => [
                '=>' => 'single_space',
                '=' => 'single_space',
            ],
        ]]);

    $services->set(EncodingFixer::class);
    $services->set(FullOpeningTagFixer::class);
    $services->set(BlankLineAfterNamespaceFixer::class);
    $services->set(BracesFixer::class);
    $services->set(ConstantCaseFixer::class);
    $services->set(ElseifFixer::class);
    $services->set(FunctionDeclarationFixer::class);
    $services->set(IndentationTypeFixer::class);
    $services->set(LineEndingFixer::class);
    $services->set(LowercaseKeywordsFixer::class);
    $services->set(NoBreakCommentFixer::class);
    $services->set(NoClosingTagFixer::class);
    $services->set(NoSpacesAfterFunctionNameFixer::class);
    $services->set(NoSpacesInsideParenthesisFixer::class);
    $services->set(NoTrailingWhitespaceFixer::class);
    $services->set(SingleBlankLineAtEofFixer::class);

    $services->set(SingleClassElementPerStatementFixer::class)
        ->call('configure', [[
            'elements' => ['property'],
        ]]);

    $services->set(SingleImportPerStatementFixer::class);
    $services->set(SingleLineAfterImportsFixer::class);
    $services->set(SwitchCaseSemicolonToColonFixer::class);
    $services->set(SwitchCaseSpaceFixer::class);
    $services->set(VisibilityRequiredFixer::class);

    $services->set(SingleTraitInsertPerStatementFixer::class);
    $services->set(FunctionTypehintSpaceFixer::class);
    $services->set(NoBlankLinesAfterClassOpeningFixer::class);
    $services->set(NoSinglelineWhitespaceBeforeSemicolonsFixer::class);
    $services->set(PhpdocSingleLineVarSpacingFixer::class);
    $services->set(NoLeadingNamespaceWhitespaceFixer::class);
    $services->set(NoSpacesAroundOffsetFixer::class);
    $services->set(NoWhitespaceInBlankLineFixer::class);
    $services->set(ReturnTypeDeclarationFixer::class);
    $services->set(TernaryOperatorSpacesFixer::class);

    $services->set(ParamReturnAndVarTagMalformsFixer::class);

    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    $services->set(NoUnusedImportsFixer::class);
    $services->set(OrderedImportsFixer::class);
    $services->set(NoEmptyStatementFixer::class);
    $services->set(ProtectedToPrivateFixer::class); // ?
    $services->set(ReturnAssignmentFixer::class);

    $services->set(AlignMultilineCommentFixer::class);
    $services->set(ArrayIndentationFixer::class);
    $services->set(BinaryOperatorSpacesFixer::class);
    $services->set(BlankLineBeforeStatementFixer::class);
    $services->set(BracesFixer::class)
        ->call('configure', [[
            'allow_single_line_closure' => true,
        ]]);

    $services->set(CombineConsecutiveIssetsFixer::class);
    $services->set(CombineConsecutiveUnsetsFixer::class);
    $services->set(CompactNullableTypehintFixer::class);
    $services->set(ConcatSpaceFixer::class)
        ->call('configure', [[
            'spacing' => 'one',
        ]]);

    $services->set(DeclareStrictTypesFixer::class);
    $services->set(DeclareEqualNormalizeFixer::class)
        ->call('configure', [[
            'space' => 'none',
        ]]);
    $services->set(ElseifFixer::class);
    $services->set(EncodingFixer::class);
    $services->set(FullyQualifiedStrictTypesFixer::class);
    $services->set(HeredocToNowdocFixer::class);
    $services->set(IncludeFixer::class);
    $services->set(IncrementStyleFixer::class);
    $services->set(LowercaseCastFixer::class);
    $services->set(LowercaseStaticReferenceFixer::class);
    $services->set(MagicMethodCasingFixer::class);
    $services->set(MethodArgumentSpaceFixer::class)
        ->call('configure', [[
            'on_multiline' => 'ensure_fully_multiline',
        ]]);
    $services->set(MethodChainingIndentationFixer::class);
    $services->set(MultilineCommentOpeningClosingFixer::class);
    $services->set(MultilineWhitespaceBeforeSemicolonsFixer::class);
    $services->set(NativeFunctionCasingFixer::class);
    $services->set(NativeFunctionTypeDeclarationCasingFixer::class);
    $services->set(NoAlternativeSyntaxFixer::class);
    $services->set(NoBinaryStringFixer::class);
    $services->set(NoBlankLinesAfterPhpdocFixer::class);
    $services->set(NoBreakCommentFixer::class);
    $services->set(NoEmptyCommentFixer::class);

    $services->set(NoExtraBlankLinesFixer::class) // ?
        ->call('configure', [[
            'tokens' => [
                'break',
                'continue',
                'curly_brace_block',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'throw',
                'use',
            ],
    ]
    ]);

    $services->set(NoLeadingImportSlashFixer::class);
    $services->set(NoMixedEchoPrintFixer::class);
    $services->set(NoMultilineWhitespaceAroundDoubleArrowFixer::class);
    $services->set(NoNullPropertyInitializationFixer::class);
    $services->set(NoShortBoolCastFixer::class);
    $services->set(NoSuperfluousElseifFixer::class);
    $services->set(NoSuperfluousPhpdocTagsFixer::class)
        ->call('configure', [[
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
            'allow_unused_params' => true,
        ]]);

    $services->set(NoTrailingCommaInListCallFixer::class);
    $services->set(NoTrailingCommaInSinglelineArrayFixer::class);

    $services->set(NoUnneededControlParenthesesFixer::class);

    $services->set(NoUnneededCurlyBracesFixer::class)
        ->call('configure', [[
            'namespaces' => true,
        ]]);

    $services->set(NoUnsetCastFixer::class);
    $services->set(NoUselessReturnFixer::class);
    $services->set(NoWhitespaceBeforeCommaInArrayFixer::class);
    $services->set(NormalizeIndexBraceFixer::class);
    $services->set(ObjectOperatorWithoutWhitespaceFixer::class); // ?
    $services->set(PhpUnitFqcnAnnotationFixer::class);
    $services->set(PhpUnitInternalClassFixer::class);
    $services->set(PhpUnitMethodCasingFixer::class);
    $services->set(PhpdocIndentFixer::class);
    $services->set(PhpdocNoAccessFixer::class);
    $services->set(PhpdocNoPackageFixer::class);
    $services->set(PhpdocNoUselessInheritdocFixer::class); // ?
    $services->set(PhpdocScalarFixer::class);
    $services->set(PhpdocTypesOrderFixer::class);
    $services->set(PhpdocVarAnnotationCorrectOrderFixer::class);
    $services->set(SemicolonAfterInstructionFixer::class);
    $services->set(ShortScalarCastFixer::class);
    $services->set(SimpleToComplexStringVariableFixer::class);
    $services->set(SingleBlankLineBeforeNamespaceFixer::class);
    $services->set(SpaceAfterSemicolonFixer::class)
        ->call('configure', [[
            'remove_in_empty_for_expressions' => true,
        ]]);
    $services->set(StandardizeNotEqualsFixer::class);
    $services->set(TrimArraySpacesFixer::class);
    $services->set(UnaryOperatorSpacesFixer::class);

    // sniffy z nasich CS
    $services->set(LanguageConstructSpacingSniff::class);
    $services->set(DisallowLongArraySyntaxSniff::class);
    $services->set(JumbledIncrementerSniff::class);
    $services->set(UnconditionalIfStatementSniff::class);
    $services->set(ForLoopShouldBeWhileLoopSniff::class);
    $services->set(UnnecessaryFinalModifierSniff::class);
    $services->set(DeprecatedFunctionsSniff::class);
    $services->set(DisallowShortOpenTagSniff::class);
    $services->set(CharacterBeforePHPOpeningTagSniff::class);
    $services->set(DisallowAlternativePHPTagsSniff::class);
    $services->set(DisallowTabIndentSniff::class);
    $services->set(ScopeIndentSniff::class);
    $services->set(ConstructorNameSniff::class);
    $services->set(UpperCaseConstantNameSniff::class);
    $services->set(InlineControlStructureSniff::class);
    $services->set(ByteOrderMarkSniff::class);
    $services->set(DuplicateClassNameSniff::class);
    $services->set(InlineHTMLSniff::class);
    $services->set(SpaceAfterCastSniff::class);
    $services->set(NestingLevelSniff::class);
    $services->set(EmptyStatementSniff::class);
    $services->set(UselessLateStaticBindingSniff::class);
    $services->set(RequireNullCoalesceOperatorSniff::class);
    $services->set(RequireShortTernaryOperatorSniff::class);
    $services->set(StaticClosureSniff::class);
    $services->set(UnusedInheritedVariablePassedToClosureSniff::class);
    $services->set(DisallowGroupUseSniff::class);
    $services->set(FullyQualifiedGlobalConstantsSniff::class);
    $services->set(FullyQualifiedGlobalFunctionsSniff::class);
    $services->set(UselessAliasSniff::class);
    $services->set(StrictParamFixer::class);
};
