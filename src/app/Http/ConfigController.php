<?php

namespace Galtsevt\AppConf\app\Http;

use App\Http\Controllers\Controller;
use Galtsevt\AppConf\app\Services\ConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * @param ConfigService $service
     * @return Response
     */
    public function index(ConfigService $service): Response
    {
        $data = [
            'title' => 'Настройки сайта',
            'formElementContainers' => $service->getFormElementContainers(),
        ];
        return response()->view('appconf::index', $data);
    }

    /**
     * @param Request $request
     * @param ConfigService $service
     * @return RedirectResponse
     */
    public function save(Request $request, ConfigService $service): RedirectResponse
    {
        $service->save($request);
        return redirect()->back()->with('success', 'Успешно сохранено');
    }
}
