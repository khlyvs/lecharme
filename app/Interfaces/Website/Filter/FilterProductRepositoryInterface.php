<?php

namespace App\Interfaces\Website\Filter;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Filter Product Repository Interface
 * 
 * Defines contract for product filtering operations
 * 
 * @package App\Interfaces\Website\Filter
 */
interface FilterProductRepositoryInterface
{
    /**
     * Get products filtered by subcategory slug
     *
     * @param string $slug Subcategory slug
     * @param array<string, mixed> $filters Optional filter parameters
     * @return LengthAwarePaginator Paginated products collection
     */
    public function getBySubcategorySlug(string $slug, array $filters = []): LengthAwarePaginator;

    /**
     * Get products filtered by category ID
     *
     * @param int $categoryId Category ID
     * @param array<string, mixed> $filters Optional filter parameters
     * @return LengthAwarePaginator Paginated products collection
     */
    public function getByCategoryId(int $categoryId, array $filters = []): LengthAwarePaginator;
}
