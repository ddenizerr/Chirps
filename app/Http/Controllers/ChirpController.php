<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Chirps/Index',[
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request): Application|RedirectResponse|Redirector
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirp()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Update resource from storage.
     *
     * @param Request $request
     * @param Chirp $chirp
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, Chirp $chirp): Redirector|RedirectResponse|Application
    {
        $this->authorize('update',$chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $chirp->update($validated);
        return redirect(route('chirps.index'));

    }

    /**
     * @param Chirp $chirp
     * @return Redirector|Application|RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Chirp $chirp): Redirector|Application|RedirectResponse
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();

        return redirect(route('chirps.index'));
    }

}
