<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RegimeAdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $regimes = $db->table('regimes')->get()->getResultArray();
        
        foreach ($regimes as &$r) {
            $r['durees'] = $db->table('regime_durees')->where('regime_id', $r['id'])->get()->getResultArray();
        }
        
        return view('admin/regimes/index', [
            'title' => 'Gestion des régimes',
            'regimes' => $regimes
        ]);
    }
    
    public function creer()
    {
        return view('admin/regimes/create', [
            'title' => 'Créer un régime'
        ]);
    }
    
    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'pct_viande' => $this->request->getPost('pct_viande'),
            'pct_poisson' => $this->request->getPost('pct_poisson'),
            'pct_volaille' => $this->request->getPost('pct_volaille'),
            'delta_poids_min' => $this->request->getPost('delta_poids_min'),
            'delta_poids_max' => $this->request->getPost('delta_poids_max')
        ];
        
        $db->table('regimes')->insert($data);
        $regime_id = $db->insertID();
        
        $durees = $this->request->getPost('durees');
        if ($durees && is_array($durees)) {
            $durees_data = [];
            foreach ($durees as $d) {
                if (isset($d['jours']) && isset($d['prix'])) {
                    $durees_data[] = [
                        'regime_id' => $regime_id,
                        'duree_jours' => $d['jours'],
                        'prix' => $d['prix']
                    ];
                }
            }
            if (!empty($durees_data)) {
                $db->table('regime_durees')->insertBatch($durees_data);
            }
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Erreur lors de la création.');
        }
        
        return redirect()->to(site_url('admin/regimes'))->with('success', 'Régime créé.');
    }
    
    public function modifier($id)
    {
        $db = \Config\Database::connect();
        
        $regime = $db->table('regimes')->where('id', $id)->get()->getRowArray();
        $regime['durees'] = $db->table('regime_durees')->where('regime_id', $id)->get()->getResultArray();
        
        return view('admin/regimes/edit', [
            'title' => 'Modifier un régime',
            'regime' => $regime
        ]);
    }
    
    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'pct_viande' => $this->request->getPost('pct_viande'),
            'pct_poisson' => $this->request->getPost('pct_poisson'),
            'pct_volaille' => $this->request->getPost('pct_volaille'),
            'delta_poids_min' => $this->request->getPost('delta_poids_min'),
            'delta_poids_max' => $this->request->getPost('delta_poids_max')
        ];
        
        $db->table('regimes')->where('id', $id)->update($data);
        
        $db->table('regime_durees')->where('regime_id', $id)->delete();
        
        $durees = $this->request->getPost('durees');
        if ($durees && is_array($durees)) {
            $durees_data = [];
            foreach ($durees as $d) {
                if (isset($d['jours']) && isset($d['prix'])) {
                    $durees_data[] = [
                        'regime_id' => $id,
                        'duree_jours' => $d['jours'],
                        'prix' => $d['prix']
                    ];
                }
            }
            if (!empty($durees_data)) {
                $db->table('regime_durees')->insertBatch($durees_data);
            }
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Erreur lors de la modification.');
        }
        
        return redirect()->to(site_url('admin/regimes'))->with('success', 'Régime modifié.');
    }
    
    public function supprimer($id)
    {
        $db = \Config\Database::connect();
        $db->table('regimes')->where('id', $id)->delete();
        return redirect()->to(site_url('admin/regimes'))->with('success', 'Régime supprimé.');
    }
}
