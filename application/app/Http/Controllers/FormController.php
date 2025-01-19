<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\FormRepository;
use App\Http\Responses\ApiResponse;

class FormController extends Controller
{
    private $formRepository;

    public function __construct(FormRepository $formRepository)
    {
        $this->formRepository = $formRepository;
    }

    public function list() {
        $forms = $this->formRepository->listFormsWithInputs();
        return $forms;
    }

    public function show($id) {
        $form = $this->formRepository->showFormWithInputs($id);
        return $form;
    }

    public function create(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'is_default' => 'required|boolean',
            'form_inputs' => 'required|array',
        ]);

        $form = $this->formRepository->createFormWithInputs($validatedData);

        return ApiResponse::success($form, 'Form created successfully');
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'is_default' => 'required|boolean',
            'form_inputs' => 'required|array',
        ]);

        $form = $this->formRepository->updateFormAndInputs($validatedData, $id);

        return $form;
    }

    public function delete($id) {
        $this->formRepository->deleteFormWithInputs($id);
        return ApiResponse::success(null, 'Form created successfully', 204);
    }
}
