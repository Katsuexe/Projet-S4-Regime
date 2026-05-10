<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class PorteMonnaieController extends BaseController
{
    public function index()
    {
        return view('front/porte_monnaie', ['title' => 'Mon portefeuille']);
    }

    public function update()
    {
        return redirect()->back()->with('success', 'Portefeuille mis a jour.');
    }

    public function redeemCode()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Requête invalide']);
        }

        $json = $this->request->getJSON();
        $code = $json->code ?? '';
        if (empty($code)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code requis']);
        }

        $db = \Config\Database::connect();
        $codeRow = $db->table('codes')->where('code', $code)->where('is_used', 0)->get()->getRow();

        if (!$codeRow) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code invalide ou déjà utilisé']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur non connecté']);
        }

        $db->transStart();

        // Update user solde
        $db->table('users')->where('id', $userId)->set('solde', 'solde + ' . $codeRow->montant, false)->update();

        // Mark code as used
        $db->table('codes')->where('id', $codeRow->id)->update([
            'is_used' => 1,
            'used_by' => $userId,
            'used_at' => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la validation du code']);
        }

        // Get new solde
        $user = $db->table('users')->select('solde')->where('id', $userId)->get()->getRow();

        // Update session
        session()->set('solde', $user->solde);

        return $this->response->setJSON([
            'success' => true,
            'montant' => $codeRow->montant,
            'solde' => $user->solde
        ]);
    }

    public function activateGold()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Requête invalide']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur non connecté']);
        }

        $db = \Config\Database::connect();

        // Get prix_gold
        $param = $db->table('parametres')->where('cle', 'prix_gold')->get()->getRow();
        if (!$param) {
            return $this->response->setJSON(['success' => false, 'message' => 'Prix Gold non configuré']);
        }
        $prixGold = (float) $param->valeur;

        // Get current user solde
        $user = $db->table('users')->select('solde, is_gold')->where('id', $userId)->get()->getRow();
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur introuvable']);
        }

        if ($user->is_gold) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gold déjà activé']);
        }

        if ($user->solde < $prixGold) {
            return $this->response->setJSON(['success' => false, 'message' => 'Solde insuffisant']);
        }

        $db->transStart();

        // Deduct solde
        $newSolde = $user->solde - $prixGold;
        $db->table('users')->where('id', $userId)->update(['solde' => $newSolde, 'is_gold' => 1]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'activation Gold']);
        }

        // Update session
        session()->set(['solde' => $newSolde, 'is_gold' => true]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gold activé ! -' . number_format($prixGold, 2, ',', ' ') . ' Ar',
            'solde' => $newSolde
        ]);
    }
}
