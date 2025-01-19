<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Repository\FormInputRepository;

class FormInputController extends Controller
{
    private $formInputRepository;

    public function __construct(FormInputRepository $formInputRepository)
    {
        $this->formInputRepository = $formInputRepository;
    }

    public function list()
    {
        $inputs = $this->formInputRepository->listInputs();
        return $inputs;
    }

    public function show($id)
    {
        $input = $this->formInputRepository->showInput($id);
        return $input;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|json',
        ]);

        $input = $this->formInputRepository->createInput($validatedData);

        return ApiResponse::success($input, 'Form input created successfully.', 201);
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'content' => 'required|json',
        ]);

        $input = $this->formInputRepository->updateInput($validatedData, $id);

        return ApiResponse::success($input, 'Form input updated successfully.', 201);
    }

    public function delete($id)
    {
        $this->formInputRepository->deleteInput($id);
        return ApiResponse::success(null, '', 204);
    }
}
