<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;
use App\Models\ActiviteModel;
use App\Models\RegimeDureeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;
use App\Models\UserRegimeModel;
use App\Models\UserSanteModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{
    public function export(int $id)
    {
        $userId = (int) session('user_id');

        if (! $userId) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour exporter un programme.');
        }

        $subscription = (new UserRegimeModel())->where('id', $id)->where('user_id', $userId)->first();

        if (! $subscription) {
            return redirect()->to('/profil')->with('error', 'Programme introuvable ou inaccessible.');
        }

        $user = (new UserModel())->find($userId);
        $sante = (new UserSanteModel())->where('user_id', $userId)->first() ?? [];
        $regime = (new RegimeModel())->find($subscription['regime_id']);
        $duree = (new RegimeDureeModel())->find($subscription['regime_duree_id']);
        $activite = null;

        if (! empty($subscription['activite_id'])) {
            $activite = (new ActiviteModel())->find($subscription['activite_id']);
        }

        if (! $user || ! $regime || ! $duree) {
            return redirect()->to('/profil')->with('error', 'Impossible de generer ce PDF avec les donnees actuelles.');
        }

        $imc = null;
        $categorie = null;
        $ideal = null;

        if (! empty($sante['poids']) && ! empty($sante['taille'])) {
            $imc = ImcCalculator::calculate((float) $sante['poids'], (float) $sante['taille']);
            $categorie = ImcCalculator::categorie($imc);
            $ideal = ImcCalculator::imcIdeal((string) ($user['genre'] ?? 'homme'), (float) $sante['taille']);
        }

        $html = view('front/pdf_template', [
            'user' => $user,
            'sante' => $sante,
            'subscription' => $subscription,
            'regime' => $regime,
            'duree' => $duree,
            'activite' => $activite,
            'imc' => $imc,
            'categorie' => $categorie,
            'ideal' => $ideal,
            'generatedAt' => date('d/m/Y H:i'),
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        $filename = 'programme-regime-' . $subscription['id'] . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($dompdf->output());
    }
}
