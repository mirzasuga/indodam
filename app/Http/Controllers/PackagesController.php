<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the package.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::get();

        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Package);

        return view('packages.create');
    }

    /**
     * Store a newly created package in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Package);

        $newPackage = $request->validate([
            'name'           => 'required|max:60',
            'price'          => 'required|numeric',
            'wallet'         => 'required|numeric',
            'system_portion' => 'required|numeric',
            'description'    => 'nullable|max:255',
        ]);
        $newPackage['creator_id'] = auth()->id();

        $package = Package::create($newPackage);

        return redirect()->route('packages.show', $package);
    }

    /**
     * Display the specified package.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified package.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $this->authorize('update', $package);

        return view('packages.edit', compact('package'));
    }

    /**
     * Update the specified package in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $this->authorize('update', $package);

        $packageData = $request->validate([
            'name'           => 'required|max:60',
            'price'          => 'required|numeric',
            'wallet'         => 'required|numeric',
            'system_portion' => 'required|numeric',
            'description'    => 'nullable|max:255',
        ]);

        $package->update($packageData);

        return redirect()->route('packages.show', $package);
    }

    /**
     * Remove the specified package from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $this->authorize('delete', $package);

        $this->validate(request(), [
            'package_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('package_id') == $package->id && $package->delete()) {
            return redirect()->route('packages.index', $routeParam);
        }

        return back();
    }
}
