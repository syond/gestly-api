<?php

namespace App\Repository;

use App\Models\FormInput;
use App\Models\Form;
use App\Exceptions\NotFoundException;

class FormRepository
{
    public function createFormWithInputs($validatedData)
    {
        $inputs = $validatedData['form_inputs'];
        $persistedInputsIds = [];

        foreach ($inputs as $inputDecoded) {
            $inputEncoded = json_encode($inputDecoded['content']);

            $formInput = FormInput::create([
                'content' => $inputEncoded,
            ]);

            $persistedInputsIds[] = $formInput->id;
        }

        $form = Form::create([
            'title' => $validatedData['title'],
            'is_default' => $validatedData['is_default'],
        ]);
        $form->formInputs()->attach($persistedInputsIds);

        return $form;
    }

    public function updateFormAndInputs($validatedData, $formId)
    {
        $inputs = $validatedData['form_inputs'];

        $FormInputsToPersist = [];

        foreach ($inputs as $inputDecoded) {
            $formInput = FormInput::find($inputDecoded['id']);

            if (!$formInput) throw new NotFoundException('Form Input ' . $inputDecoded['id'] . ' not found.');

            $FormInputsToPersist[] = [
                'formInput' => $formInput,
                'content' => json_encode($inputDecoded['content']),
            ];
        }

        foreach ($FormInputsToPersist as $inputData) {
            $inputData['formInput']->update([
                'content' => $inputData['content'],
            ]);
        }

        $form = Form::find($formId);

        if (!$form) throw new NotFoundException('Form not found.');

        $form->update([
            'title' => $validatedData['title'],
            'is_default' => $validatedData['is_default'],
        ]);

        return $form->with('formInputs')->get()->toArray();
    }

    public function showFormWithInputs($id)
    {
        $form = Form::with('formInputs')->find($id);

        if (!$form) throw new NotFoundException('Form not found.');

        return $form->toArray();
    }

    public function listFormsWithInputs()
    {
        $forms = Form::with('formInputs')->get();
        return $forms;
    }

    public function deleteFormWithInputs($formId) {
        $form = Form::find($formId);

        if (!$form) throw new NotFoundException('Form not found.');

        $form->delete($formId);

        return $form;
    }
}
