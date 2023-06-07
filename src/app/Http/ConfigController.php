<?php

namespace Galtsevt\AppConf\app\Http;

use App\Http\Controllers\Controller;
use Galtsevt\AppConf\app\Resources\FormElementContainerResource;
use Galtsevt\AppConf\app\Services\ConfigService;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Kontur\Dashboard\App\Facades\Template;

class ConfigController extends Controller
{


    /**
     * @param ConfigService $service
     * @param string|null $name
     * @return \Inertia\Response
     */
    public function index(ConfigService $service, string $name = null): \Inertia\Response
    {
        Seo::metaData()->setTitle('Настройки');
        $service->setGroup($name);
        Seo::breadcrumbs()->add('Настройки');
        return Template::render('Modules/Settings/Index', [
            'formElementContainers' => FormElementContainerResource::collection($service->getFormElementContainers()),
            'group' => $name,
        ]);
    }

    /**
     * @param Request $request
     * @param ConfigService $service
     * @return bool
     */
    public function save(Request $request, ConfigService $service, string $name = null): bool
    {
        $service->setGroup($name);
        $service->save($request);
        return true;
    }
}
