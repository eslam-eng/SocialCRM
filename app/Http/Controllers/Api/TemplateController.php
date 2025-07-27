<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Template\TemplateDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Http\Requests\TemplateRequest;
use App\Services\Actions\Template\CreateTemplateService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct(private readonly CreateTemplateService $createTemplateService) {}

    public function index(Request $request) {}

    public function store(TemplateRequest $request)
    {
        try {
            $templateDTO = TemplateDTO::fromRequest($request);
            $template = $this->createTemplateService->handle(templateDTO: $templateDTO);

            return ApiResponse::success(data: $template);
        } catch (\Exception $exception) {
            return ApiResponse::error(message: $exception->getMessage());
        }

    }

    public function show($id) {}

    public function update(CurrencyRequest $request, $id) {}

    public function destroy($id) {}
}
