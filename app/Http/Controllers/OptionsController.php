<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function page1()
    {
        return view('options.page-1');
    }

    public function save1(Request $request)
    {
        $request->validate([
            'sponsor_bonus.*.*' => 'required|numeric',
        ]);

        $option = Option::firstOrNew(['key' => 'sponsor_bonus']);
        $option->value = collect($request->get('sponsor_bonus'))->toJson();
        $option->save();

        flash(trans('option.updated'), 'success');

        return redirect()->route('options.page-1');
    }
}
