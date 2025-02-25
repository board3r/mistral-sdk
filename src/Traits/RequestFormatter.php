<?php
namespace Board3r\MistralSdk\Traits;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\FormatInterface;
use \InvalidArgumentException;

/**
 * @property array|DataObject $request
 * @property array $_requiredFields
 */
trait RequestFormatter
{
    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function requestAsArray():array
    {
        if (!is_array($this->request) && $this->request instanceof FormatInterface) {
            $arr = $this->request->toArray();
        } elseif (is_array($this->request)) {
            $arr = $this->request;
        }else{
            throw new InvalidArgumentException("The request must be an array or an instance of FormatInterface");
        }
        if (isset($this->_requiredFields) && is_array($this->_requiredFields)) {
            foreach ($this->_requiredFields as $field){
                if(!isset($arr[$field])){
                    throw new InvalidArgumentException("[$field] is required for this request");
                }
            }
        }
        return array_filter($arr);
    }
}
