<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\Property\AddPropertyTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use RectorLaravel\Rector\Class_\LivewireComponentComputedMethodToComputedAttributeRector;
use RectorLaravel\Rector\Class_\LivewireComponentQueryStringToUrlAttributeRector;
use RectorLaravel\Rector\Coalesce\ApplyDefaultInsteadOfNullCoalesceRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use RectorLaravel\Rector\MethodCall\JsonCallToExplicitJsonCallRector;
use RectorLaravel\Rector\MethodCall\LumenRoutesStringMiddlewareToArrayRector;
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\StaticCall\CarbonSetTestNowToTravelToRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap/app.php',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/public',
        __DIR__.'/tests',
    ])
    ->withRules([
        DeclareStrictTypesRector::class,
        AddParamTypeDeclarationRector::class,
        AddReturnTypeDeclarationRector::class,
        AddPropertyTypeDeclarationRector::class,
        AssertStatusToAssertMethodRector::class,
        ApplyDefaultInsteadOfNullCoalesceRector::class,
        CarbonSetTestNowToTravelToRector::class,
        EloquentMagicMethodToQueryBuilderRector::class,
        EloquentOrderByToLatestOrOldestRector::class,
        EloquentWhereRelationTypeHintingParameterRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        JsonCallToExplicitJsonCallRector::class,
        LivewireComponentComputedMethodToComputedAttributeRector::class,
        LivewireComponentQueryStringToUrlAttributeRector::class,
        LumenRoutesStringMiddlewareToArrayRector::class,
        OptionalToNullsafeOperatorRector::class,
        WhereToWhereLikeRector::class,
        TypeHintTappableCallRector::class,
        RouteActionCallableRector::class,
        NewlineAfterStatementRector::class,
    ])
    ->withImportNames()
    ->withSkip([
        ReturnBinaryOrToEarlyReturnRector::class,
        ClosureToArrowFunctionRector::class,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
    )
    ->withPhpSets()
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_120,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
    ])
    ->withParallel(
        timeoutSeconds: 120,
        maxNumberOfProcess: 16,
        jobSize: 10
    );
