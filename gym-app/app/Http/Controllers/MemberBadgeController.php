<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberBadgeController extends Controller
{
    public function show(Member $member): View
    {
        $this->authorize('view', $member);

        $qrUrl = URL::temporarySignedRoute(
            'attendance.checkin.qr',
            now()->addMonths(6),
            ['member' => $member->id]
        );

        $qrSvg = QrCode::size(220)->margin(1)->generate($qrUrl);

        return view('members.badge', compact('member', 'qrSvg'));
    }
}
