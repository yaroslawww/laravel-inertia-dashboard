# Laravel think kit.

![Packagist License](https://img.shields.io/packagist/l/yaroslawww/laravel-inertia-dashboard?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/yaroslawww/laravel-inertia-dashboard)](https://packagist.org/packages/yaroslawww/laravel-inertia-dashboard)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/laravel-inertia-dashboard)](https://packagist.org/packages/yaroslawww/laravel-inertia-dashboard)
[![Build Status](https://scrutinizer-ci.com/g/yaroslawww/laravel-inertia-dashboard/badges/build.png?b=main)](https://scrutinizer-ci.com/g/yaroslawww/laravel-inertia-dashboard/build-status/main)
[![Code Coverage](https://scrutinizer-ci.com/g/yaroslawww/laravel-inertia-dashboard/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/yaroslawww/laravel-inertia-dashboard/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yaroslawww/laravel-inertia-dashboard/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/yaroslawww/laravel-inertia-dashboard/?branch=main)

"Laravel inertia dashboard development kit for quicker MVP ot live projects.

## Installation

Install the package via composer:

```bash
composer require yaroslawww/laravel-inertia-dashboard
```

Optionally you can publish the config file with:

```bash
php artisan vendor:publish --provider="InertiaDashboardKit\ServiceProvider" --tag="config"
```

## Usage

```php
return Inertia::render('Admin/Issue/ShowPage', [
            'translations' => get_ads_translations('issue-page'),
            'indexData' => IndexData::make(
                $request,
                (new AdvAsset())->getMorphClass(),
                $lineItemIssue->assets()
            )
                                    ->perPage(9)
                                    ->useResource(
                                        AttachedAssetResource::class,
                                        [
                                            'actions' => function (AdvAsset $entity, $user, $request) use ($lineItemIssue) {
                                                $actions = [];
                                                if (
                                                    $user->can('update', $lineItemIssue)
                                                    && !$entity->pivot
                                                        ->isStatus(\App\Domain\Advertising\Enums\AssetStatus::APPROVED)
                                                ) {
                                                    $actions[] = (new DetachAction())
                                                        ->setDetachable($lineItemIssue, 'assets');
                                                }

                                                return $actions;
                                            },
                                        ]
                                    )
                                    ->bulkActions([])
                                    ->columns($columns)
                                    ->toResponseArray(),
        ]);
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/) 
