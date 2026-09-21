<?php

namespace NumbersNebula\NebulaCosmetics\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webkul\Product\Repositories\ProductRepository;

class ProductPickerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected ProductRepository $productRepository) {}

    /**
     * Search products with images.
     */
    public function search(Request $request): JsonResponse
    {
        $query = (string) $request->input('query', '');

        $products = $this->productRepository
            ->with(['images', 'attribute_values'])
            ->scopeQuery(function ($builder) use ($query) {
                if (! empty($query)) {
                    $like = db_grammar()->caseInsensitiveLike();

                    $builder->where(function ($sub) use ($query, $like) {
                        $sub->where('sku', $like, "%{$query}%")
                            ->orWhereHas('attribute_values', function ($attrQuery) use ($query, $like) {
                                $attrQuery->where('text_value', $like, "%{$query}%");
                            });
                    });
                }

                return $builder->orderBy('id', 'desc')->limit(30);
            })
            ->all();

        $results = [];

        foreach ($products as $product) {
            $baseImage = $product->images->first()?->url
                ?: (product_image()->getProductBaseImage($product)['medium_image_url'] ?? asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'));

            $results[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->name,
                'price' => core()->currency($product->price),
                'image' => $baseImage,
            ];
        }

        return response()->json($results);
    }
}
