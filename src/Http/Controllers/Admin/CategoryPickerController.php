<?php

namespace NumbersNebula\NebulaCosmetics\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webkul\Category\Repositories\CategoryRepository;

class CategoryPickerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected CategoryRepository $categoryRepository) {}

    /**
     * Search categories.
     */
    public function search(Request $request): JsonResponse
    {
        $query = (string) $request->input('query', '');

        $categories = $this->categoryRepository->scopeQuery(function ($builder) use ($query) {
            if (! empty($query)) {
                $like = db_grammar()->caseInsensitiveLike();

                $builder->whereTranslation('name', $like, "%{$query}%")
                    ->orWhereTranslation('slug', $like, "%{$query}%");
            }

            return $builder->orderBy('id', 'desc')->limit(30);
        })->all();

        $results = [];

        foreach ($categories as $category) {
            $results[] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => $category->logo_url ?: $category->banner_url,
            ];
        }

        return response()->json($results);
    }
}
