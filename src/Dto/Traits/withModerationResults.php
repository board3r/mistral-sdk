<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\ModerationResult;
use Board3r\MistralSdk\Dto\Objects\ModerationResultCollection;
use Board3r\MistralSdk\Enums\ClassificationEnum;

/**
 * @method ModerationResultCollection|ModerationResult getResults()
 */
trait withModerationResults
{
    public ModerationResultCollection $results;

    public function getScore(string $catName): float|null
    {
        if ($cat = ClassificationEnum::tryFrom($catName)){
            return $this->getResults()->get(0)->getCategoryScores()[$cat->name]??null;
        }
        return null;
    }

    public function getModeration(string $catName): bool|null
    {
        if ($cat = ClassificationEnum::tryFrom($catName)){
            return $this->getResults()->get(0)->getCategories()[$cat->name]??null;
        }
        return null;
    }
}
