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
use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\DisallowSpaceIndentSniff;
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
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function(ECSConfig $ecsConfig): void {
	$ecsConfig->indentation('tab');
	$ecsConfig->lineEnding("\n");

	$ecsConfig->skip([
		AssignmentInConditionSniff::class . '.FoundInWhileCondition' => null,
	]);

	$ecsConfig->sets([
		SetList::STRICT,
		SetList::ARRAY,
		SetList::COMMENTS,
		SetList::NAMESPACES,
		SetList::PHPUNIT,
	]);

	$ecsConfig->rule(PhpUnitMethodCasingFixer::class);
	$ecsConfig->rule(FunctionToConstantFixer::class);
	$ecsConfig->rule(ExplicitStringVariableFixer::class);
	$ecsConfig->rule(ExplicitIndirectVariableFixer::class);
	$ecsConfig->rule(NewWithBracesFixer::class);
	$ecsConfig->ruleWithConfiguration(ClassDefinitionFixer::class, [
		'single_line' => true,
	]);

	$ecsConfig->rule(StandardizeIncrementFixer::class);
	$ecsConfig->rule(SelfAccessorFixer::class);
	$ecsConfig->rule(MagicConstantCasingFixer::class);
	$ecsConfig->rule(AssignmentInConditionSniff::class);
	$ecsConfig->rule(NoUselessElseFixer::class);
	$ecsConfig->rule(SingleQuoteFixer::class);

	$ecsConfig->rule(OrderedClassElementsFixer::class);

	$ecsConfig->ruleWithConfiguration(PhpdocLineSpanFixer::class, [
		'const' => 'single',
		'property' => 'single',
		'method' => 'multi',
	]);

	$ecsConfig->rule(NoTrailingWhitespaceInCommentFixer::class);
	$ecsConfig->rule(PhpdocTrimConsecutiveBlankLineSeparationFixer::class);
	$ecsConfig->rule(PhpdocTrimFixer::class);
	$ecsConfig->rule(NoEmptyPhpdocFixer::class);
	$ecsConfig->rule(PhpdocIndentFixer::class);
	$ecsConfig->rule(PhpdocTypesFixer::class);
	$ecsConfig->rule(PhpdocReturnSelfReferenceFixer::class);
	$ecsConfig->rule(PhpdocVarWithoutNameFixer::class);
	$ecsConfig->rule(RemoveUselessDefaultCommentFixer::class);

	$ecsConfig->rule(MethodChainingIndentationFixer::class);

	$ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
		'elements' => [
			'const' => 'one',
			'property' => 'one',
			'method' => 'one',
			'trait_import' => 'none',
		],
	]);

	$ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
		'spacing' => 'one',
	]);

	$ecsConfig->ruleWithConfiguration(SuperfluousWhitespaceSniff::class, [
		'ignoreBlankLines' => false,
	]);

	$ecsConfig->rule(CastSpacesFixer::class);

	$ecsConfig->ruleWithConfiguration(BinaryOperatorSpacesFixer::class, [
		'operators' => [
			'=>' => BinaryOperatorSpacesFixer::SINGLE_SPACE,
			'=' => BinaryOperatorSpacesFixer::SINGLE_SPACE,
		],
	]);

	$ecsConfig->rule(EncodingFixer::class);
	$ecsConfig->rule(FullOpeningTagFixer::class);
	$ecsConfig->rule(BlankLineAfterNamespaceFixer::class);
	$ecsConfig->rule(BracesFixer::class);
	$ecsConfig->rule(ConstantCaseFixer::class);
	$ecsConfig->rule(ElseifFixer::class);
	$ecsConfig->ruleWithConfiguration(FunctionDeclarationFixer::class, [
		'closure_function_spacing' => 'none',
	]);
	$ecsConfig->rule(IndentationTypeFixer::class);
	$ecsConfig->rule(LineEndingFixer::class);
	$ecsConfig->rule(LowercaseKeywordsFixer::class);
	$ecsConfig->rule(NoBreakCommentFixer::class);
	$ecsConfig->rule(NoClosingTagFixer::class);
	$ecsConfig->rule(NoSpacesAfterFunctionNameFixer::class);
	$ecsConfig->rule(NoSpacesInsideParenthesisFixer::class);
	$ecsConfig->rule(NoTrailingWhitespaceFixer::class);
	$ecsConfig->rule(SingleBlankLineAtEofFixer::class);

	$ecsConfig->ruleWithConfiguration(SingleClassElementPerStatementFixer::class, [
		'elements' => ['property'],
	]);

	$ecsConfig->rule(SingleImportPerStatementFixer::class);
	$ecsConfig->rule(SingleLineAfterImportsFixer::class);
	$ecsConfig->rule(SwitchCaseSemicolonToColonFixer::class);
	$ecsConfig->rule(SwitchCaseSpaceFixer::class);
	$ecsConfig->rule(VisibilityRequiredFixer::class);

	$ecsConfig->rule(SingleTraitInsertPerStatementFixer::class);
	$ecsConfig->rule(FunctionTypehintSpaceFixer::class);
	$ecsConfig->rule(NoBlankLinesAfterClassOpeningFixer::class);
	$ecsConfig->rule(NoSinglelineWhitespaceBeforeSemicolonsFixer::class);
	$ecsConfig->rule(PhpdocSingleLineVarSpacingFixer::class);
	$ecsConfig->rule(NoLeadingNamespaceWhitespaceFixer::class);
	$ecsConfig->rule(NoSpacesAroundOffsetFixer::class);
	$ecsConfig->rule(NoWhitespaceInBlankLineFixer::class);
	$ecsConfig->rule(ReturnTypeDeclarationFixer::class);
	$ecsConfig->rule(TernaryOperatorSpacesFixer::class);

	$ecsConfig->rule(ParamReturnAndVarTagMalformsFixer::class);

	$ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
		'syntax' => 'short',
	]);

	$ecsConfig->rule(NoUnusedImportsFixer::class);
	$ecsConfig->rule(OrderedImportsFixer::class);
	$ecsConfig->rule(NoEmptyStatementFixer::class);
	$ecsConfig->rule(ProtectedToPrivateFixer::class);
	$ecsConfig->rule(ReturnAssignmentFixer::class);

	$ecsConfig->rule(AlignMultilineCommentFixer::class);
	$ecsConfig->rule(ArrayIndentationFixer::class);
	$ecsConfig->rule(BlankLineBeforeStatementFixer::class);
	$ecsConfig->ruleWithConfiguration(BracesFixer::class, [
		'allow_single_line_closure' => true,
	]);

	$ecsConfig->rule(CombineConsecutiveIssetsFixer::class);
	$ecsConfig->rule(CombineConsecutiveUnsetsFixer::class);
	$ecsConfig->rule(CompactNullableTypehintFixer::class);
	$ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
		'spacing' => 'one',
	]);

	$ecsConfig->rule(DeclareStrictTypesFixer::class);
	$ecsConfig->ruleWithConfiguration(DeclareEqualNormalizeFixer::class, [
		'space' => 'single',
	]);
	$ecsConfig->rule(ElseifFixer::class);
	$ecsConfig->rule(EncodingFixer::class);
	$ecsConfig->rule(FullyQualifiedStrictTypesFixer::class);
	$ecsConfig->rule(HeredocToNowdocFixer::class);
	$ecsConfig->rule(IncludeFixer::class);
	$ecsConfig->rule(IncrementStyleFixer::class);
	$ecsConfig->rule(LowercaseCastFixer::class);
	$ecsConfig->rule(LowercaseStaticReferenceFixer::class);
	$ecsConfig->rule(MagicMethodCasingFixer::class);
	$ecsConfig->ruleWithConfiguration(MethodArgumentSpaceFixer::class, [
		'on_multiline' => 'ensure_fully_multiline',
	]);
	$ecsConfig->rule(MethodChainingIndentationFixer::class);
	$ecsConfig->rule(MultilineCommentOpeningClosingFixer::class);
	$ecsConfig->rule(MultilineWhitespaceBeforeSemicolonsFixer::class);
	$ecsConfig->rule(NativeFunctionCasingFixer::class);
	$ecsConfig->rule(NativeFunctionTypeDeclarationCasingFixer::class);
	$ecsConfig->rule(NoAlternativeSyntaxFixer::class);
	$ecsConfig->rule(NoBinaryStringFixer::class);
	$ecsConfig->rule(NoBlankLinesAfterPhpdocFixer::class);
	$ecsConfig->rule(NoBreakCommentFixer::class);
	$ecsConfig->rule(NoEmptyCommentFixer::class);

	$ecsConfig->ruleWithConfiguration(NoExtraBlankLinesFixer::class, [
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
	]);

	$ecsConfig->rule(NoLeadingImportSlashFixer::class);
	$ecsConfig->rule(NoMixedEchoPrintFixer::class);
	$ecsConfig->rule(NoMultilineWhitespaceAroundDoubleArrowFixer::class);
	$ecsConfig->rule(NoNullPropertyInitializationFixer::class);
	$ecsConfig->rule(NoShortBoolCastFixer::class);
	$ecsConfig->rule(NoSuperfluousElseifFixer::class);
	$ecsConfig->ruleWithConfiguration(NoSuperfluousPhpdocTagsFixer::class, [
		'allow_mixed' => true,
		'remove_inheritdoc' => true,
		'allow_unused_params' => true,
	]);

	$ecsConfig->rule(NoTrailingCommaInListCallFixer::class);
	$ecsConfig->rule(NoTrailingCommaInSinglelineArrayFixer::class);

	$ecsConfig->rule(NoUnneededControlParenthesesFixer::class);

	$ecsConfig->ruleWithConfiguration(NoUnneededCurlyBracesFixer::class, [
		'namespaces' => true,
	]);

	$ecsConfig->rule(NoUnsetCastFixer::class);
	$ecsConfig->rule(NoUselessReturnFixer::class);
	$ecsConfig->rule(NoWhitespaceBeforeCommaInArrayFixer::class);
	$ecsConfig->rule(NormalizeIndexBraceFixer::class);
	$ecsConfig->rule(ObjectOperatorWithoutWhitespaceFixer::class); // ?
	$ecsConfig->rule(PhpUnitFqcnAnnotationFixer::class);
	$ecsConfig->rule(PhpUnitInternalClassFixer::class);
	$ecsConfig->rule(PhpUnitMethodCasingFixer::class);
	$ecsConfig->rule(PhpdocIndentFixer::class);
	$ecsConfig->rule(PhpdocNoAccessFixer::class);
	$ecsConfig->rule(PhpdocNoPackageFixer::class);
	$ecsConfig->rule(PhpdocNoUselessInheritdocFixer::class); // ?
	$ecsConfig->rule(PhpdocScalarFixer::class);
	$ecsConfig->rule(PhpdocTypesOrderFixer::class);
	$ecsConfig->rule(PhpdocVarAnnotationCorrectOrderFixer::class);
	$ecsConfig->rule(SemicolonAfterInstructionFixer::class);
	$ecsConfig->rule(ShortScalarCastFixer::class);
	$ecsConfig->rule(SimpleToComplexStringVariableFixer::class);
	$ecsConfig->rule(SingleBlankLineBeforeNamespaceFixer::class);
	$ecsConfig->ruleWithConfiguration(SpaceAfterSemicolonFixer::class, [
		'remove_in_empty_for_expressions' => true,
	]);
	$ecsConfig->rule(StandardizeNotEqualsFixer::class);
	$ecsConfig->rule(TrimArraySpacesFixer::class);
	$ecsConfig->rule(UnaryOperatorSpacesFixer::class);

	// sniffy z nasich CS
	$ecsConfig->rule(LanguageConstructSpacingSniff::class);
	$ecsConfig->rule(DisallowLongArraySyntaxSniff::class);
	$ecsConfig->rule(JumbledIncrementerSniff::class);
	$ecsConfig->rule(UnconditionalIfStatementSniff::class);
	$ecsConfig->rule(ForLoopShouldBeWhileLoopSniff::class);
	$ecsConfig->rule(UnnecessaryFinalModifierSniff::class);
	$ecsConfig->rule(DeprecatedFunctionsSniff::class);
	$ecsConfig->rule(DisallowShortOpenTagSniff::class);
	$ecsConfig->rule(CharacterBeforePHPOpeningTagSniff::class);
	$ecsConfig->rule(DisallowAlternativePHPTagsSniff::class);
	$ecsConfig->rule(DisallowSpaceIndentSniff::class);
	$ecsConfig->ruleWithConfiguration(ScopeIndentSniff::class, [
		'tabIndent' => true,
	]);
	$ecsConfig->rule(ConstructorNameSniff::class);
	$ecsConfig->rule(UpperCaseConstantNameSniff::class);
	$ecsConfig->rule(InlineControlStructureSniff::class);
	$ecsConfig->rule(ByteOrderMarkSniff::class);
	$ecsConfig->rule(DuplicateClassNameSniff::class);
	$ecsConfig->rule(InlineHTMLSniff::class);
	$ecsConfig->rule(SpaceAfterCastSniff::class);
	$ecsConfig->rule(NestingLevelSniff::class);
	$ecsConfig->rule(EmptyStatementSniff::class);
	$ecsConfig->rule(UselessLateStaticBindingSniff::class);
	$ecsConfig->rule(RequireNullCoalesceOperatorSniff::class);
	$ecsConfig->rule(RequireShortTernaryOperatorSniff::class);
	$ecsConfig->rule(StaticClosureSniff::class);
	$ecsConfig->rule(UnusedInheritedVariablePassedToClosureSniff::class);
	$ecsConfig->rule(DisallowGroupUseSniff::class);
	$ecsConfig->rule(FullyQualifiedGlobalConstantsSniff::class);
	$ecsConfig->rule(FullyQualifiedGlobalFunctionsSniff::class);
	$ecsConfig->rule(UselessAliasSniff::class);
	$ecsConfig->rule(StrictParamFixer::class);
};
