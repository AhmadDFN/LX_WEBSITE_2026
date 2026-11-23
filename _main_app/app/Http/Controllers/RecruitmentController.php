<?php

namespace App\Http\Controllers;

use App\Models\GameMode;
use App\Models\RecruitmentApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruitmentController extends Controller
{
    public function create(): View
    {
        $gameModes = GameMode::where('is_active', true)->get();

        return view('recruitment.create', compact('gameModes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'ign' => ['required', 'string', 'max:100'],
            'delta_force_uid' => ['required', 'string', 'max:50'],
            'discord_tag' => ['required', 'string', 'max:100'],
            'target_game_mode_id' => ['required', 'exists:game_modes,id'],
            'preferred_class' => ['required', 'in:assault,engineer,support,recon'],
            'rank_tier' => ['required', 'string', 'max:100'],
            'proof_screenshot' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:4096'],
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_screenshot')) {
            $proofPath = $request->file('proof_screenshot')->store('recruitment', 'public');
        }

        RecruitmentApplication::create([
            'full_name' => $validated['full_name'],
            'ign' => $validated['ign'],
            'delta_force_uid' => $validated['delta_force_uid'],
            'discord_tag' => $validated['discord_tag'],
            'target_game_mode_id' => $validated['target_game_mode_id'],
            'preferred_class' => $validated['preferred_class'],
            'rank_tier' => $validated['rank_tier'],
            'proof_screenshot' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('join.squad')->with('status', [
            'type' => 'success',
            'code' => 'TRANSMISSION_CONFIRMED',
            'message' => 'Tactical recruitment application ingested into Luxury Elite Command Registry. Staff review pending.',
        ]);
    }
}
