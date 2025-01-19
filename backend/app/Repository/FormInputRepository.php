<?php

namespace App\Repository;

use App\Exceptions\NotFoundException;
use App\Models\FormInput;

class FormInputRepository
{
    public function listInputs()
    {
        $forms = FormInput::get();
        return $forms;
    }

    public function showInput($id)
    {
        $form = FormInput::find($id);
        if (!$form) throw new NotFoundException('Input not found.');
        return $form;
    }

    public function createInput($validatedData)
    {
        $form = FormInput::create($validatedData);
        return $form;
    }

    public function updateInput($validatedData, $id) {
        $form = FormInput::find($id);
        if (!$form) throw new NotFoundException('Input not found.');
        $form->update($validatedData);
        return $form;
    }

    public function deleteInput($id)
    {
        $form = FormInput::find($id);
        if (!$form) throw new NotFoundException('Input not found.');
        $form->delete($id);
        return $form;
    }
}
