<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ParametreController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $params = $db->table('parametres')->get()->getResultArray();
        
        $descriptions = [
            'gold_price' => 'Prix de l\'abonnement Gold',
            'gold_discount' => 'Pourcentage de réduction Gold',
            'imc_ideal_min' => 'Borne inférieure IMC idéal',
            'imc_ideal_max' => 'Borne supérieure IMC idéal',
            'code_prefix' => 'Préfixe des codes portefeuille générés'
        ];
        
        return view('admin/parametres/index', [
            'title' => 'Paramètres système',
            'params' => $params,
            'descriptions' => $descriptions
        ]);
    }
    
    public function update()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            
            $json = $this->request->getJSON();
            $cle = $json->cle ?? null;
            $valeur = $json->valeur ?? null;
            
            if ($cle !== null && $valeur !== null) {
                $db->table('parametres')->where('cle', $cle)->update(['valeur' => $valeur]);
                return $this->response->setJSON(['success' => true]);
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Données manquantes']);
        }
        
        return $this->response->setStatusCode(403);
    }
}
