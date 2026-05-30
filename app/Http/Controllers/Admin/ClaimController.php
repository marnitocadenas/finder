<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\LogsActivity;
use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\TmcNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClaimController extends Controller
{
    use LogsActivity;

    public function index(Request $request): View
    {
        $claimStats = [
            ['label' => 'Total Claims', 'value' => Claim::count(), 'icon' => 'fa-file-signature', 'tone' => 'primary'],
            ['label' => 'Pending', 'value' => Claim::where('status', 'pending')->count(), 'icon' => 'fa-hourglass-half', 'tone' => 'warning'],
            ['label' => 'Approved', 'value' => Claim::where('status', 'approved')->count(), 'icon' => 'fa-circle-check', 'tone' => 'success'],
            ['label' => 'Rejected', 'value' => Claim::where('status', 'rejected')->count(), 'icon' => 'fa-circle-xmark', 'tone' => 'danger'],
        ];

        return view('claims.index', [
            'role' => 'admin',
            'claims' => Claim::with(['student', 'foundItem.category'])->filtered($request->all())->latest()->paginate(15)->withQueryString(),
            'claimStats' => $claimStats,
        ]);
    }

    public function show(Claim $claim): View
    {
        return view('claims.show', ['role' => 'admin', 'claim' => $claim->load(['student', 'foundItem.category', 'lostItem', 'reviewer'])]);
    }

    public function update(Request $request, Claim $claim): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
            'review_note' => 'nullable|string|max:1000',
        ]);

        $claim->update($data + ['reviewed_by' => $request->user()->id, 'reviewed_at' => now()]);

        if ($data['status'] === 'approved') {
            $claim->foundItem->update(['status' => 'claimed']);
        }

        TmcNotification::create([
            'user_id' => $claim->student_id,
            'title' => 'Claim '.$data['status'],
            'message' => 'Your claim for '.$claim->foundItem->title.' was '.$data['status'].'.',
            'type' => 'claim_update',
            'link' => route('student.claims.show', $claim),
        ]);

        $this->logAction($request, ucfirst($data['status']).' claim #'.$claim->id, $claim);

        return back()->with('success', 'Claim reviewed.');
    }
}
