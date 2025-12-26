<?php

namespace App\Services\Website\Filter;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\Website\Filter\FilterProductRepositoryInterface;
use App\Http\Requests\FilterRequest;

/**
 * Filter Product Service
 * 
 * Handles business logic for product filtering
 * Extracts and validates filter parameters from requests
 */
class FilterProductService
{
    public function __construct(
        private FilterProductRepositoryInterface $repository
    ) {}

    /**
     * Get products by subcategory slug with filters
     *
     * @param string $slug Subcategory slug
     * @param array $filters Filter parameters
     * @return LengthAwarePaginator
     */
    public function getBySubcategorySlug(string $slug, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->getBySubcategorySlug($slug, $filters);
    }

    /**
     * Get products by category ID with filters
     *
     * @param int $categoryId Category ID
     * @param array $filters Filter parameters
     * @return LengthAwarePaginator
     */
    public function getByCategoryId(int $categoryId, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->getByCategoryId($categoryId, $filters);
    }

    /**
     * Extract and validate filters from request
     *
     * @param Request|FilterRequest $request
     * @return array<string, mixed>
     */
    public function extractFilters(Request|FilterRequest $request): array
    {
        // If FilterRequest is used, data is already validated
        if ($request instanceof FilterRequest) {
            return [
                'min_price'     => $request->validated('min_price'),
                'max_price'     => $request->validated('max_price'),
                'subcategories' => $request->validated('subcategories', []),
                'has_discount'  => $request->validated('has_discount', false),
                'sort'          => $request->validated('sort', 'default'),
                'per_page'      => $request->validated('per_page', 12),
            ];
        }

        // Fallback for regular Request (backward compatibility)
        return [
            'min_price'     => $request->filled('min_price') ? (float) $request->min_price : null,
            'max_price'     => $request->filled('max_price') ? (float) $request->max_price : null,
            'subcategories' => $request->input('subcategories', []),
            'has_discount'  => $request->boolean('has_discount'),
            'sort'          => $request->input('sort', 'default'),
            'per_page'      => (int) $request->input('per_page', 12),
        ];
    }
}
