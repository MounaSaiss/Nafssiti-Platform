<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use App\Models\FollowRequest;
use Illuminate\Support\Facades\Auth;

class FollowRequestController extends Controller
{
    public function index()
    {
        $psychologist = Auth::user()->psychologist;

        $requests = FollowRequest::with('patient.user')
            ->where('psychologist_id', $psychologist->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('psychologue.follow_requests', compact('requests'));
    }

    public function accept(FollowRequest $followRequest)
    {
        $psychologist = Auth::user()->psychologist;

        if ($followRequest->psychologist_id !== $psychologist->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $followRequest->update(['status' => 'accepted']);

        return redirect()->route('psychologue.follow_requests.index')
            ->with('success', 'Demande de suivi acceptée avec succès.');
    }

    public function reject(FollowRequest $followRequest)
    {
        $psychologist = Auth::user()->psychologist;

        if ($followRequest->psychologist_id !== $psychologist->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $followRequest->update(['status' => 'rejected']);

        return redirect()->route('psychologue.follow_requests.index')
            ->with('success', 'Demande de suivi refusée.');
    }
}
