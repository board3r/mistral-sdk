<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withFilename;
use Board3r\MistralSdk\Dto\Traits\withFilePurpose;
use Board3r\MistralSdk\Traits\FileValidate;
use JsonException;
use Rs\JsonLines\Exception\File\NonReadable;

/**
 * @method resource getFile()
 */
class FileUploadRequest extends DataObject
{
    use FileValidate;
    use withFilePurpose;
    use withFilename;

    public mixed $file;

    /**
     * @param  string  $filepath
     * @param  bool  $validate
     * @return $this
     * @throws JsonException
     * @throws NonReadable
     */
    public function setFile(string $filepath,bool $validate = true): self
    {
        if (!$validate || $this->validateFile($filepath)) {
            $this->file =  fopen($filepath,'r');;
        }
        return $this;
    }
}
