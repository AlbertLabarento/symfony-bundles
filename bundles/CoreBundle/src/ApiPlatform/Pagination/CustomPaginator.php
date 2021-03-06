<?php
declare(strict_types=1);

namespace EonX\CoreBundle\ApiPlatform\Pagination;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;

final class CustomPaginator implements CustomPaginatorInterface
{
    /** @var \ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator */
    private $decorated;

    /**
     * CustomPaginator constructor.
     *
     * @param \ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator $decorated
     */
    public function __construct(Paginator $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(): array
    {
        return \iterator_to_array($this->decorated->getIterator());
    }

    /**
     * {@inheritdoc}
     */
    public function getPagination(): array
    {
        $hasNextPage = $this->decorated->getCurrentPage() < $this->decorated->getLastPage();
        $hasPreviousPage = $this->decorated->getCurrentPage() - 1 > 0;

        return [
            'currentPage' => $this->decorated->getCurrentPage(),
            'hasNextPage' => $hasNextPage,
            'hasPreviousPage' => $hasPreviousPage,
            'itemsPerPage' => $this->decorated->getItemsPerPage(),
            'totalItems' => $this->decorated->getTotalItems(),
            'totalPages' => $this->decorated->getLastPage()
        ];
    }
}
