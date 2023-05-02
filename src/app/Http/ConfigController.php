<?php

namespace Galtsevt\AppConf\app\Http;

use App\Http\Controllers\Controller;
use Galtsevt\AppConf\app\Services\ConfigService;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ConfigController extends Controller
{


    /**
     * @param ConfigService $service
     * @return Response
     */
    public function index(ConfigService $service, string $name = null): Response
    {
        Seo::metaData()->setTitle('Настройки');
        $service->setGroup($name);
        Seo::breadcrumbs()->add('Настройки');
        return response()->view('appconf::index', [
            'formElementContainers' => $service->getFormElementContainers(),
            'groupName' => $name,
        ]);
    }

    /**
     * @param Request $request
     * @param ConfigService $service
     * @return RedirectResponse
     */
    public function save(Request $request, ConfigService $service, string $name = null): RedirectResponse
    {
        $service->setGroup($name);
        $service->save($request);
        return redirect()->back()->with('success', 'Успешно сохранено');
    }
}
