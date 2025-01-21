<?php

namespace App\Repository;

use App\Exceptions\NotFoundException;
use App\Models\FormInput;
use App\Models\Form;

class FormInputRepository
{
    public function listInputs()
    {
        $formInputs = FormInput::get();
        return $formInputs;
    }

    public function showInput($id)
    {
        $formInput = FormInput::find($id);
        if (!$formInput) throw new NotFoundException('Input not found.');
        return $formInput;
    }

    public function createInput($validatedData)
    {
        $formInput = FormInput::create($validatedData);
        return $formInput;
    }

    public function updateInput($validatedData, $id)
    {
        $formInput = FormInput::find($id);
        if (!$formInput) throw new NotFoundException('Input not found.');
        $formInput->update($validatedData);
        return $formInput;
    }

    public function deleteInput($id)
    {
        $formInput = FormInput::find($id);
        if (!$formInput) throw new NotFoundException('Input not found.');
        $formInput->delete($id);
        return $formInput;
    }

    public function associateInputsToForm(Form $form, array $inputIds)
    {
        $form->formInputs()->syncWithoutDetaching($inputIds);
        return $form->load('formInputs');
    }

    /**
     * Associate, Create and associate or update and asssociate a FormInput
     */
    public function syncFormInputs(Form $form, array $formInputs)
    {
        foreach ($formInputs as $input) {
            if (is_numeric($input)) {
                $this->associateInputsToForm($form, [$input]);
            } elseif (array_key_exists('id', $input)) {
                $updatedInput = $this->updateInput($input, $input['id']);
                $this->associateInputsToForm($form, [$updatedInput->id]);
            } else {
                $persistedInput = $this->createInput($input);
                $this->associateInputsToForm($form, [$persistedInput->id]);
            }
        }
    }
}
