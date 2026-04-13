<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketPageController extends Controller
{
    public function notifications()
    {
        $notifications = [
            [
                'title' => 'Freshness Alert',
                'message' => 'Your banana is still fresh but nearing ripeness. Store in a cool and dry place.',
                'time' => '1m',
                'icon' => 'leaf',
                'highlight' => true,
            ],
            [
                'title' => 'New Fresh Produce Available!',
                'message' => 'Local farmers just stocked fresh tomatoes and lettuce. Order while supplies last.',
                'time' => '45m',
                'icon' => 'store',
                'highlight' => true,
            ],
            [
                'title' => 'Boost Your Immunity!',
                'message' => 'Fresh citrus fruits are packed with Vitamin C. Check recipes and meal plans now.',
                'time' => '9h',
                'icon' => 'lemon',
                'highlight' => false,
            ],
            [
                'title' => 'Sustainability Tip',
                'message' => 'Reduce food waste by storing vegetables properly. Learn more in our guide.',
                'time' => '12h',
                'icon' => 'globe',
                'highlight' => false,
            ],
            [
                'title' => 'Organic Spinach on Sale!',
                'message' => 'Get 20% off fresh greens from local farms.',
                'time' => '2d',
                'icon' => 'plant',
                'highlight' => false,
            ],
            [
                'title' => 'Daily Tip',
                'message' => 'Carrots stored in water last longer. Keep them fresh for up to two weeks.',
                'time' => '6d',
                'icon' => 'carrot',
                'highlight' => false,
            ],
        ];

        return view('market-notifications', compact('notifications'));
    }

    public function nutritionProfile(Request $request)
    {
        $search = trim((string) $request->input('q', ''));

        $groups = config('market_catalog.nutrition_index', []);

        if ($search !== '') {
            $groups = collect($groups)
                ->map(function ($items) use ($search) {
                    return collect($items)
                        ->filter(fn ($item) => str_contains(strtolower($item), strtolower($search)))
                        ->values()
                        ->all();
                })
                ->filter(fn ($items) => !empty($items))
                ->all();
        }

        $topTiles = [
            ['label' => 'Leafy greens', 'tile' => 'leafy'],
            ['label' => 'Watermelon', 'tile' => 'watermelon'],
            ['label' => 'Tomato', 'tile' => 'tomato'],
            ['label' => 'Carrot', 'tile' => 'carrot'],
        ];

        return view('market-nutrition-profile', [
            'groups' => $groups,
            'topTiles' => $topTiles,
            'search' => $search,
        ]);
    }

    public function nutritionValue(string $name)
    {
        $slug = Str::slug($name);
        $nutritionProfiles = config('market_catalog.nutrition_profiles', []);
        $productProfiles = config('market_catalog.products', []);
        $fallback = config('market_catalog.fallback', []);

        $profile = $nutritionProfiles[$slug] ?? null;

        if (!$profile) {
            $matchedProduct = null;
            foreach ($productProfiles as $key => $item) {
                if (Str::slug($key) === $slug || str_contains($slug, Str::slug($key)) || str_contains(Str::slug($key), $slug)) {
                    $matchedProduct = $item;
                    break;
                }
            }

            $profile = [
                'name' => Str::title(str_replace('-', ' ', $slug)),
                'type' => 'Philippine Produce',
                'image' => $matchedProduct['image'] ?? $fallback['image'] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80',
                'description' => $matchedProduct['nutrition'] ?? 'Locally sourced produce with essential vitamins, minerals, and fiber for daily nutrition.',
                'chips' => ['Farm Fresh', 'Nutrient Dense', 'Daily Cooking'],
                'stats' => [
                    ['value' => '45', 'label' => 'Cal'],
                    ['value' => '1g', 'label' => 'Protein'],
                    ['value' => '9g', 'label' => 'Carbs'],
                    ['value' => '3g', 'label' => 'Sugar'],
                    ['value' => '2g', 'label' => 'Fiber'],
                ],
                'facts' => [
                    ['name' => 'Total Fat', 'value' => '0.2 g', 'dv' => '0%'],
                    ['name' => 'Vitamin C', 'value' => '6 mg', 'dv' => ''],
                    ['name' => 'Potassium', 'value' => '120 mg', 'dv' => ''],
                ],
            ];
        } else {
            // Ensure image key exists in nutrition profiles
            if (!isset($profile['image'])) {
                $profile['image'] = $fallback['image'] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80';
            }
        }

        return view('market-nutrition-value', compact('profile'));
    }

    public function nutritionRecipe(string $slug)
    {
        $recipes = collect(config('market_catalog.recipe_articles', []));
        $recipe = $recipes->firstWhere('slug', $slug);

        if (!$recipe) {
            abort(404);
        }

        return view('market-nutrition-recipe', compact('recipe'));
    }
}
