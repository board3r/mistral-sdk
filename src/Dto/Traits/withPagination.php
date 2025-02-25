<?php

namespace Board3r\MistralSdk\Dto\Traits;

/**
 * @method self setPage(int|null $page)
 * @method int getPage()
 * @method self setPageSize(int|null $pageSize)
 * @method int getPageSize()
 */
trait withPagination
{
    public int|null $page;

    public int|null $pageSize;
}
