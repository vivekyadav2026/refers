<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KycDocument;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KycController extends Controller
{
    public function index()
    {
        $kycDocument = auth()->user()->kycDocument;
        $kycStatus = auth()->user()->kyc_status;
        return view('kyc.index', compact('kycStatus', 'kycDocument'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aadhaar_number' => 'required|string',
            'aadhaar_front' => 'required|image|max:5120',
            'aadhaar_back' => 'required|image|max:5120',
            'pan_number' => 'required|string',
            'pan_image' => 'required|image|max:5120',
            'selfie' => 'required|image|max:5120',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'ifsc' => 'required|string',
            'bank_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $user = auth()->user();

        // Store Files
        $aadhaarFrontPath = $request->file('aadhaar_front')->store('kyc/' . $user->id, 'public');
        $aadhaarBackPath = $request->file('aadhaar_back')->store('kyc/' . $user->id, 'public');
        $panPath = $request->file('pan_image')->store('kyc/' . $user->id, 'public');
        $photoPath = $request->file('selfie')->store('kyc/' . $user->id, 'public');
        $bankProofPath = $request->file('bank_proof')->store('kyc/' . $user->id, 'public');

        // Create or Update KYC Document Record
        KycDocument::updateOrCreate(
            ['user_id' => $user->id],
            [
                'aadhaar_path' => json_encode(['front' => $aadhaarFrontPath, 'back' => $aadhaarBackPath, 'number' => $request->aadhaar_number]),
                'pan_path' => json_encode(['image' => $panPath, 'number' => $request->pan_number]),
                'photo_path' => $photoPath,
                'bank_details' => [
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'ifsc' => $request->ifsc,
                    'proof_path' => $bankProofPath
                ],
                'status' => 'pending'
            ]
        );

        // Update User Status
        $user->update(['kyc_status' => 'pending']);

        return redirect()->back()->with('success', 'KYC Documents submitted successfully and are under review.');
    }

    public function downloadIdCard()
    {
        $user = auth()->user();

        if ($user->kyc_status !== 'approved' || !$user->kycDocument) {
            return redirect()->back()->withErrors(['error' => 'Your KYC is not yet approved.']);
        }

        $pdf = Pdf::loadView('kyc.id-card', [
            'user' => $user,
            'kyc' => $user->kycDocument
        ]);

        return $pdf->download('SKSolutions_Partner_ID_' . $user->id . '.pdf');
    }

    public function downloadAgreement()
    {
        $user = auth()->user();

        // Pass any necessary variables to the view
        $pdf = Pdf::loadView('partner.agreement', compact('user'));

        return $pdf->download('Partner_Agreement_' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
