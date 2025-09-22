<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationInfo;
use Illuminate\Http\Request;

class RegistrationInfoController extends Controller
{
    public function index()
    {
        $infos = RegistrationInfo::all();
        return view('admin.fees.index', compact('infos'));
    }

    public function create()
    {
        return view('admin.fees.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'type' => 'required|in:fee,email',
    //         'label' => 'required|string|max:255',
    //         'value' => 'required|string|max:255',
    //     ]);

    //     RegistrationInfo::create($request->only('type', 'label', 'value'));

    //     return redirect()->route('admin.fees.index')->with('success', 'Info added successfully.');
    // }

    public function edit($id)
    {
        $info = RegistrationInfo::findOrFail($id);
        return view('admin.fees.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $info = RegistrationInfo::findOrFail($id);

        // Validation rules
        $rules = [
            'type' => 'required|in:fee,email,qr_image',
            'label' => 'required|string|max:255',
        ];

        // Conditional validation for value or file
        if ($request->type === 'qr_image') {
            $rules['qr_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['value'] = 'required|string|max:255';
        }

        $request->validate($rules);

        // Update type and label
        $info->type = $request->type;
        $info->label = $request->label;

        // Handle value or file
        if ($request->type === 'qr_image' && $request->hasFile('qr_image')) {
            // Delete old QR image if exists
            if ($info->value && file_exists(storage_path('app/public/' . $info->value))) {
                unlink(storage_path('app/public/' . $info->value));
            }

            $file = $request->file('qr_image');
            $path = $file->store('qr_images', 'public');
            $info->value = $path;
        } else {
            $info->value = $request->value;
        }

        $info->save();

        return redirect()->route('admin.fees.index')->with('success', 'Info updated successfully.');
    }


    public function destroy($id)
    {
        $info = RegistrationInfo::findOrFail($id);
        $info->delete();

        return redirect()->route('admin.fees.index')->with('success', 'Info deleted successfully.');
    }
}
