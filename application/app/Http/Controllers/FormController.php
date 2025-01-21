<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\FormRepository;
use App\Repository\FormInputRepository;
use App\Http\Responses\ApiResponse;

class FormController extends Controller
{
    private $formRepository;
    private $formInputRepository;

    public function __construct(FormRepository $formRepository, FormInputRepository $formInputRepository)
    {
        $this->formRepository = $formRepository;
        $this->formInputRepository = $formInputRepository;
    }

    public function list()
    {
        $forms = $this->formRepository->listFormsWithInputs();
        return $forms;
    }

    public function show($id)
    {
        $form = $this->formRepository->showFormWithInputs($id);
        return $form;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'is_default' => 'required|boolean',
            'form_inputs' => 'required|array',
        ]);

        try {
            $form = $this->formRepository->create($validatedData['title'], $validatedData['is_default']);
            if (!$form) {
                return ApiResponse::error('Form creation failed', 500);
            }
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred: ' . $e->getMessage(), 500);
        }

        $this->formInputRepository->syncFormInputs($form, $validatedData['form_inputs']);

        return ApiResponse::success($form, 'Form created successfully');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'is_default' => 'required|boolean',
            'form_inputs' => 'required|array',
        ]);

        try {
            $form = $this->formRepository->update($id, [$validatedData['title'], $validatedData['is_default']]);
            if (!$form) {
                return ApiResponse::error('Form updating failed', 500);
            }
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred: ' . $e->getMessage(), 500);
        }

        $this->formInputRepository->syncFormInputs($form, $validatedData['form_inputs']);

        return $form;
    }

    public function delete($id)
    {
        $this->formRepository->deleteFormWithInputs($id);
        return ApiResponse::success(null, 'Form created successfully', 204);
    }
}
