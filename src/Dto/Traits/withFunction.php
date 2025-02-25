<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\Tool;
use Board3r\MistralSdk\Dto\Objects\ToolChoice;
use Board3r\MistralSdk\Dto\Objects\ToolChoiceFunction;
use Board3r\MistralSdk\Dto\Objects\ToolCollection;
use Board3r\MistralSdk\Enums\ToolChoiceEnum;
use InvalidArgumentException;
use Jasny\PhpdocParser\PhpdocParser;
use Jasny\PhpdocParser\Tag\DescriptionTag;
use Jasny\PhpdocParser\Tag\FlagTag;
use Jasny\PhpdocParser\Tag\MultiTag;
use Jasny\PhpdocParser\Tag\PhpDocumentor\TypeTag;
use Jasny\PhpdocParser\Tag\PhpDocumentor\VarTag;
use Jasny\PhpdocParser\Tag\WordTag;
use Jasny\PhpdocParser\TagSet;
use ReflectionException;
use ReflectionFunction;

/**
 * @method ToolCollection|Tool[]|null getTools()
 * @method self setTools(array|ToolCollection $tools)
 * @method ToolChoiceFunction|string|null getToolChoice()
 */
trait withFunction
{
    public ToolCollection|null $tools;

    public ToolChoice|string|null $toolChoice;
    /**
     * @param  callable  $callable
     * @param  string|null  $description
     * @param  array|null  $paramDesc
     * @param  bool|null  $strict
     * @return Tool[]|ToolCollection|false|null
     */
    public function addFunction(callable $callable, ?string $description = null, ?array $paramDesc = null, ?bool $strict = null): array|ToolCollection|null|false
    {
        try {
            $function = $this->generateFunction($callable, $description, $paramDesc, $strict);
            if ($function) {
                if (isset($this->tools)) {
                    $this->tools->append($function);
                } else {
                    $this->setTools([$function]);
                }
            }
        } catch (ReflectionException) {
            return false;
        }
        return $this->getTools();
    }
    /**
     * @param  callable  $callable
     * @param  string|null  $description  set default function description
     * @param  array|null  $paramDesc  set description for each parameters [['paramName'=>'Parameter description'],...]
     * @param  bool|null  $strict
     * @return array
     * @throws ReflectionException
     */
    protected function generateFunction(callable $callable, ?string $description = null, ?array $paramDesc = null, ?bool $strict = null): array
    {
        $fn = $callable(...);
        $reflection = new ReflectionFunction($fn);
        $doc = $this->parseFromPhpDoc($reflection->getDocComment());
        $return = [
            'type' => 'function',
            'function' => [
                'name' => $doc['mistralName'] ?? $reflection->getShortName(),
                'description' => $description ?? ($doc['mistralDesc'] ?? ''),
                'parameters' => ['type' => 'object', 'required' => [], 'properties' => []]
            ]
        ];

        if (isset($doc['mistralStrict']) || isset($strict)) {
            $return['function']['strict'] = $strict ?? true;
            // additionalProperties is not set in the mistral AI, but needed to run. https://platform.openai.com/docs/guides/function-calling
            $return['function']['parameters']['additionalProperties'] = false;
        }

        if ($reflection->getNumberOfParameters()) {
            foreach ($reflection->getParameters() as $param) {
                if (isset($doc['mistralJSON'][$param->getName()]) &&
                    ($json = json_decode($doc['mistralJSON'][$param->getName()], true))
                ) {
                    $return['function']['parameters']['properties'][$param->getName()] = $json;
                } else {
                    $return['function']['parameters']['properties'][$param->getName()] = [
                        'type' => $doc['mistralParams'][$param->getName()]['type'] ?? $param->getType(),
                        'description' => $paramDesc[$param->getName()] ?? ($doc['mistralParams'][$param->getName()]['description'] ?? ''),
                    ];
                }

                if (!$param->isOptional() ||
                    (isset($doc['mistralParams'][$param->getName()]['required']) && $doc['mistralParams'][$param->getName()]['required'] === true)
                ) {
                    $return['function']['parameters']['required'][] = $param->getName();
                }
            }
        }
        return $return;
    }

    /**
     * Get PHP Doc with Mitral tags, follow example :
     *
     * @mistralName functionName
     * @mistralDesc Information about the function to describe it to give information to Mistral
     * @mistralParam int $var Type / Name / and description of the parameter to give information to Mistral (multiple tags are allowed)
     * @mistralJSON varName {'fullJson to describe the var, use format defined by https://json-schema.org/'}
     * @mistralRequired $var Define a required parameter to send to Mistral (multiple tags are allowed)
     * @mistralStrict Flag to enable strict mode
     *
     * @param  string  $docBlock
     * @return array
     */
    protected function parseFromPhpDoc(string $docBlock): array
    {
        $tagParam = new VarTag('mistralParam');
        $tagRequired = new VarTag('mistralRequired');
        $tagJson = new TypeTag('mistralJSON');
        $customTags = new TagSet([
            new WordTag('mistralName'),
            new DescriptionTag('mistralDesc'),
            new MultiTag('mistralParams', $tagParam),
            new MultiTag('mistralJSON', $tagJson),
            new MultiTag('mistralRequired', $tagRequired),
            new FlagTag('mistralStrict'),
        ]);

        $parser = new PhpdocParser($customTags);
        $parsed = $parser->parse($docBlock);
        if (isset($parsed['mistralParams'])) {
            foreach ($parsed['mistralParams'] as $i => $p) {
                if (isset($p['name'])) {
                    $parsed['mistralParams'][$p['name']] = $p;
                }
                unset($parsed['mistralParams'][$i]);
            }
        }
        if (isset($parsed['mistralJSON'])) {
            foreach ($parsed['mistralJSON'] as $p) {
                if (isset($p['type']) && isset($p['description'])) {
                    $parsed['mistralJSON'][$p['type']] = $p['description'];
                }
            }
        }
        if (isset($parsed['mistralRequired'])) {
            foreach ($parsed['mistralRequired'] as $p) {
                if (isset($p['name']) && isset($parsed['mistralParams'][$p['name']])) {
                    $parsed['mistralParams'][$p['name']]['required'] = true;
                }
            }
            unset($parsed['mistralRequired']);
        }
        return $parsed;
    }

    public function setToolChoice(array|ToolChoice|string|null $toolChoice): static
    {
        if ($toolChoice instanceof ToolChoice) {
            $this->toolChoice = $toolChoice;
        } elseif (is_array($toolChoice)) {
            $this->toolChoice = new ToolChoice($toolChoice);
        } elseif (is_null($toolChoice)) {
            $this->toolChoice = null;
        } else {
            if (ToolChoiceEnum::tryFrom($toolChoice)) {
                $this->toolChoice = $toolChoice;
            } else {
                throw new InvalidArgumentException($toolChoice.' is not allowed');
            }
        }
        return $this;
    }
}
